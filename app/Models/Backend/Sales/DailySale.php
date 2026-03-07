<?php

namespace App\Models\Backend\Sales;

use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    protected $fillable = [
        'sale_date', 'total_sale', 'total_cost', 'profit', 'note'
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];
}
