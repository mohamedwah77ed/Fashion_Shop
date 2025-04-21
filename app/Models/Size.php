<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProductVariant;


class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
