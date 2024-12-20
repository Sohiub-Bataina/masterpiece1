<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomsItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'item_description',
        'base_price',
        'auction_id',
        'category_id',
        'brand_id',
        'manager_approval',
        'rejection_reason',
        'quantity',
        'is_deleted',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function itemImages()
    {
        return $this->hasMany(ItemImage::class);
    }

    public function itemReviews()
    {
        return $this->hasMany(ItemReview::class);
    }
}

