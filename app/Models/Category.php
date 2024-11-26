<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'category';

    protected $fillable = [
        'category_name',
        'category_image',
    ];

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function customsItems()
    {
        return $this->hasMany(CustomsItem::class);
    }
}

