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
        'is_deleted',
    ];

    public function customsItems()
    {
        return $this->hasMany(CustomsItem::class);
    }

    public function auctionBids()
    {
        return $this->hasMany(AuctionBid::class);
    }
}

