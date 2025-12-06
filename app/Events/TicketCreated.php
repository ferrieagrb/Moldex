<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;


class TicketCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public $ticket;
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket->load('user');
    }
    public function broadcastOn()
    {
        return new Channel('admin.tickets');
    }
    public function broadcastWith()
    {
        return ['ticket' => $this->ticket->toArray()];
    }
}