<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model
{
    use HasFactory;
    // Disable timestamps
    public $timestamps = false;

    protected $fillable = [
        'auction_id',
        'user_id',
        'bid_amount',
        'bid_time',
        'is_winner',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
