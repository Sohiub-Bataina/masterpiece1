<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'brand';

    protected $fillable = [
        'brand_name',
        'brand_image',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function customsItems()
    {
        return $this->hasMany(CustomsItem::class);
    }
}

