<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'rating',
        'review_text',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customsItem()
    {
        return $this->belongsTo(CustomsItem::class);
    }
}

