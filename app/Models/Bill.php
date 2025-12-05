<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'description',
        'due_date',
        'status',
        'paid_at',
        'issued_by'
    ];

    protected $dates = [
        'due_date',
        'paid_at',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function issuer()
    {
        return $this->belongsTo(\App\Models\User::class, 'issued_by');
    }

    public function markPaid($when = null)
    {
        $this->status = 'paid';
        $this->paid_at = $when ?: now();
        $this->save();
    }

    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class);
    }

}
