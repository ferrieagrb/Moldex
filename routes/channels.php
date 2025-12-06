<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Ticket;

Broadcast::channel('ticket.{ticketId}', function ($user, $ticketId) {
    $ticket = Ticket::find($ticketId);
    if (!$ticket) return false;
    // allow owner, assigned admin, or any admin (change logic if you want only assigned admin)
    if (property_exists($user, 'is_admin') && $user->is_admin) return true;
    return $ticket->user_id === $user->id || $ticket->assigned_admin_id ===
        $user->id;
});
Broadcast::channel('admin.tickets', function ($user) {
    // channel for admins to receive TicketCreated/TicketClaimed events
    return property_exists($user, 'is_admin') && $user->is_admin;
});
