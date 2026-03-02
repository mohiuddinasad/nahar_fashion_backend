<?php

namespace App\Models\Backend\Contact;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'message',
        'is_read',
    ];
}