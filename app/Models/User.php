<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'admin',
        'maintenance',

        // --- ADDITIONS FOR LIVE CHAT ---
        'admin_id',       // assigned admin for a user
        'is_available',   // admin availability

        //Additional User Details
            'first_name',
            'middle_name',
            'last_name',
            'address',
            'date_of_birth',
            'contact_number',
            'tel_number',
            'nationality',
            'room_no'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function paymentHistories()
        {
            return $this->hasMany(PaymentHistory::class);
        }

    public function userPosts(){
        return $this->hasMany(Post::class, 'user_id');
    }

    }

    
