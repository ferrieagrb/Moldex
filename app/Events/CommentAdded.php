<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\TicketComment;

class CommentAdded implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public $comment;
    public function __construct(TicketComment $comment)
    {
        $this->comment = $comment->load(['user', 'admin']);
    }
    public function broadcastOn()
    {
        return new PrivateChannel('ticket.' . $this->comment->ticket_id);
    }
    public function broadcastWith()
    {
        return [
            'comment' => [
                'id' => $this->comment->id,
                'message' => $this->comment->message,
                'user' => $this->comment->user ? ['id' => $this->comment->user->id, 'name' => $this->comment->user->name] : null,
                'admin' => $this->comment->admin ? ['id' => $this->comment->admin->id, 'name' => $this->comment->admin->name] : null,
                'created_at' => $this->comment->created_at->toDateTimeString()
            ]
        ];
    }
}
