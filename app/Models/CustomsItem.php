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
        'auction_id',
        'category_id',
        'brand_id',
        'manager_approval',
        'rejection_reason',
        'quantity',
        'is_deleted',
        'vehicle_status',       // حالة المركبة
        'storage_location',     // مكان التخزين
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // في موديل CustomsItem
    public function images()
    {
        return $this->hasMany(ItemImage::class, 'item_id');  // تأكد أن الـ foreign key هو item_id
    }


    public function itemReviews()
    {
        return $this->hasMany(ItemReview::class);
    }
}
