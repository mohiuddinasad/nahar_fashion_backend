<?php

namespace App\Models\Frontend;

use App\Models\Backend\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'email',
        'rating',
        'comment',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}