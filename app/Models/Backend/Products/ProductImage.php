<?php

namespace App\Models\Backend\Products;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_name',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}