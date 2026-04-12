<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Models\Backend\Setting\WebsiteSetting;
use Illuminate\Http\Request;

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
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'site_favicon' => 'nullable|image|mimes:png,ico,jpg|max:512',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
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

        // ✅ Site Logo Upload
        if ($request->hasFile('site_logo')) {

            // delete old
            if ($setting->site_logo && file_exists(public_path($setting->site_logo))) {
                unlink(public_path($setting->site_logo));
            }

            $file = $request->file('site_logo');
            $filename = uniqid().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/settings'), $filename);

            $data['site_logo'] = 'uploads/settings/'.$filename;
        }

        // ✅ Favicon Upload
        if ($request->hasFile('site_favicon')) {

            if ($setting->site_favicon && file_exists(public_path($setting->site_favicon))) {
                unlink(public_path($setting->site_favicon));
            }

            $file = $request->file('site_favicon');
            $filename = uniqid().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/settings'), $filename);

            $data['site_favicon'] = 'uploads/settings/'.$filename;
        }

        // ✅ Meta Image Upload
        if ($request->hasFile('meta_image')) {

            if ($setting->meta_image && file_exists(public_path($setting->meta_image))) {
                unlink(public_path($setting->meta_image));
            }

            $file = $request->file('meta_image');
            $filename = uniqid().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/settings'), $filename);

            $data['meta_image'] = 'uploads/settings/'.$filename;
        }

        $setting->update($data);

        return redirect()->route('dashboard.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}
