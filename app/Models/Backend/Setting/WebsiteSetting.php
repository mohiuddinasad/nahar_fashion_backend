<?php

namespace App\Models\Backend\Setting;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_logo',
        'site_favicon',
        'contact_phone',
        'contact_email',
        'contact_address',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
    ];

    // Always get the first (and only) row
    public static function instance(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
