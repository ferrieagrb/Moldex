<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bill_id',
        'amount_paid',
        'date_paid',
        'status',
        'receipt_number',
    ];

    /**
     * A payment belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A payment belongs to a bill
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
