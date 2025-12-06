<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketComment;
use App\Events\TicketCreated;
use App\Events\CommentAdded;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TicketController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())->latest()->paginate(12);
        return view('tickets.index', compact('tickets'));
    }
    public function create()
    {
        return view('tickets.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'nullable|string|max:100',
            'attachments.*' => 'nullable|file|max:10240'
        ]);
        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'message' => $request->message,
            'category' => $request->category,
            'high_priority' => $request->has('high_priority') ? true : false,
        ]);
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('public/ticket_attachments');
                $ticket->attachments()->create([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }
        broadcast(new TicketCreated($ticket))->toOthers();
        return redirect()->route('tickets.show', $ticket)->with(
            'success',
            'Ticket created.'
        );
    }
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $ticket->load(['attachments', 'comments.user', 'comments.admin']);
        return view('tickets.show', compact('ticket'));
    }
    public function comment(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $request->validate(['message' => 'required|string|max:5000']);
        $comment = $ticket->comments()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);
        broadcast(new CommentAdded($comment))->toOthers();
        return response()->json(['success' => true, 'comment' => $comment - 0 > load('user')]);
    }
}
