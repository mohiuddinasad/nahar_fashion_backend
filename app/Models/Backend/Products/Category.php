<?php

namespace App\Models\Backend\Products;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_image',
        'category_id',
        'meta_keywords',
        'meta_description',
        'meta_title',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_id')->with('children');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}