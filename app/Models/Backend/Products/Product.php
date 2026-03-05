<?php

namespace App\Models\Backend\Products;

use App\Models\Backend\Products\Category;
use App\Models\Backend\Products\ProductImage;
use App\Models\Frontend\Review;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'slug',
        'description',
        'price',
        'discount_price',
        'discount_percentage',
        'quantity',
        'stock_status',
        'is_featured',
        'is_new',
        // SEO
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImage()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productVariant()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}