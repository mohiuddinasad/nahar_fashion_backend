<?php

namespace App\Models\Backend\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'variant_name',
        'price',
        'qty',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}