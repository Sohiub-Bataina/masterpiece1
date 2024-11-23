<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'image_url',
        'is_deleted',
    ];

    public function customsItem()
    {
        return $this->belongsTo(CustomsItem::class);
    }
}

