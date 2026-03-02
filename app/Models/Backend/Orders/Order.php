<?php

namespace App\Models\Backend\Orders;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postal',
        'comments',
        'subtotal',
        'shipping_cost',
        'total_amount',
        'payment_status',
        'order_status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images()
    {
        return $this->hasMany(OrderImage::class);
    }

}