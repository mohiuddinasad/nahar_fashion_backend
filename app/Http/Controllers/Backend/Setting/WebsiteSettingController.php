<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Models\Backend\Setting\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
    public function index()
    {
        $setting = WebsiteSetting::instance();
        return view('backend.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'         => 'required|string|max:255',
            'site_logo'         => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'site_favicon'      => 'nullable|image|mimes:png,ico,jpg|max:512',
            'contact_phone'     => 'nullable|string|max:20',
            'contact_email'     => 'nullable|email|max:255',
            'contact_address'   => 'nullable|string|max:500',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string|max:255',
            'meta_image'        => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $setting = WebsiteSetting::instance();

        $data = $request->only([
            'site_name',
            'contact_phone',
            'contact_email',
            'contact_address',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ]);

        // Handle site_logo upload
        if ($request->hasFile('site_logo')) {
            if ($setting->site_logo && Storage::disk('public')->exists($setting->site_logo)) {
                Storage::disk('public')->delete($setting->site_logo);
            }
            $data['site_logo'] = $request->file('site_logo')->store('settings', 'public');
        }

        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            if ($setting->site_favicon && Storage::disk('public')->exists($setting->site_favicon)) {
                Storage::disk('public')->delete($setting->site_favicon);
            }
            $data['site_favicon'] = $request->file('site_favicon')->store('settings', 'public');
        }

        // Handle meta image upload
        if ($request->hasFile('meta_image')) {
            if ($setting->meta_image && Storage::disk('public')->exists($setting->meta_image)) {
                Storage::disk('public')->delete($setting->meta_image);
            }
            $data['meta_image'] = $request->file('meta_image')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()->route('dashboard.settings.index')
                         ->with('success', 'Settings updated successfully!');
    }
}