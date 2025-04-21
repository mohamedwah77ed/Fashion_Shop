<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'user_id',
        'subcategory_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function colors()
    {
        return $this->variants()->select('color')->distinct();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }
    public function sizes()
    {
        return $this->hasManyThrough(
            Size::class,
            ProductVariant::class,
            'product_id',
            'id',
            'id',
            'size_id'
        );
    }
}
