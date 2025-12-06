<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Events\TicketClaimed;
use App\Events\CommentAdded;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('user')->latest()->paginate(20);
        return view('admin.tickets.index', compact('tickets'));
    }
    public function show(Ticket $ticket)
    {
        $ticket->load(['attachments', 'comments.user', 'comments.admin', 'assignedAdmin']);
        return view('admin.tickets.show', compact('ticket'));
    }
    public function claim(Request $request, Ticket $ticket)
    {
        // set the current admin as assigned
        $ticket->update([
            'assigned_admin_id' => auth()->id(),
            'status' => 'claimed'
        ]);
        broadcast(new TicketClaimed($ticket))->toOthers();
        return response()->json(['success' => true, 'ticket' => $ticket]);
    }
    public function status(Request $request, Ticket $ticket)
    {
        $request->validate(['status' => 'required|in:open,claimed,closed']);
        $ticket->update(['status' => $request->status]);
        return response()->json(['success' => true, 'status' => $ticket->status]);
    }
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with(
            'success',
            'Ticket deleted'
        );
    }
    public function comment(Request $request, Ticket $ticket)
    {
        // admin posting comment
        $request->validate(['message' => 'required|string|max:5000']);
        $comment = $ticket->comments()->create([
            'admin_id' => auth()->id(),
            'message' => $request->message,
        ]);
        broadcast(new CommentAdded($comment))->toOthers();
        return response()->json(['success' => true, 'comment' => $comment->load('admin')]);
    }
}
