<?php

namespace App\Models\Backend\Banners;

use App\Models\Backend\Products\Category;
use Illuminate\Database\Eloquent\Model;

class BottomBanner extends Model
{
    protected $fillable = [
        'bottom_image',
        'category_id',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}