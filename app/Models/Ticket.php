<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'category',
        'status',
        'high_priority',
        'assigned_admin_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assignedAdmin()
    {
        return $this->belongsTo(
            User::class,
            'assigned_admin_id'
        );
    }
    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }
    public function comments()
    {
        return $this->hasMany(TicketComment::class)->orderBy('created_at');
    }
}
