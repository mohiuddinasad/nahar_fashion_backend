<?php

namespace App\Models\Backend\Products;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'variant_name',
        'total_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}