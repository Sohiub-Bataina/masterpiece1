<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_name',
        'start_time',
        'end_time',
        'status',
        'announcement_start_time',
        'announcement_end_time',
        'inspection_start_time',
        'inspection_end_time',
        'minimum_price',
        'starting_price',
        'minimum_bid',
        'main_image',
        'insurance_fee',
        'item_id',
    ];

    public function customsItems()
    {
        return $this->hasMany(CustomsItem::class, 'auction_id');
    }

    public function auctionBids()
    {
        return $this->hasMany(AuctionBid::class);
    }
    public function bids()
    {
        return $this->hasMany(AuctionBid::class, 'auction_id');
    }
    public function highestBid()
    {
        return $this->auctionBids()->orderBy('bid_amount', 'desc')->first();
    }
}
