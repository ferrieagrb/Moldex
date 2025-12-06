<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;
    public function view(User $user, Ticket $ticket)
    {
        if ($user->admin) return true;
        return $ticket->user_id === $user->id || $ticket->assigned_admin_id === $user->id;
    }

    public function viewAny(User $user)
    {
        return $user->admin;
    }

    public function update(User $user, Ticket $ticket)
    {
        if ($user->admin) return true;
        return $ticket->user_id === $user->id;
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->admin;
    }

}
