<?php

namespace App\Models\Backend\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    protected $fillable = [
        'order_id',
        'image_path',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}