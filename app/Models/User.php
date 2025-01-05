<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone_number',
        'gender',
        'residence',
        'insurance_balance',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'insurance_balance' => 'decimal:2',
    ];

    /**
     * Automatically hash the password when set.
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Relationships.
     */
    public function bids()
    {
        return $this->hasMany(AuctionBid::class, 'user_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }
    public function wishlist()
    {
        return $this->belongsToMany(Auction::class, 'user_wishlist', 'user_id', 'auction_id');
    }
}
