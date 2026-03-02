<?php

namespace App\Models\Backend\Banners;

use App\Models\Backend\Products\Category;
use Illuminate\Database\Eloquent\Model;

class TopBanner extends Model
{
    protected $fillable = [
        'top_image',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}