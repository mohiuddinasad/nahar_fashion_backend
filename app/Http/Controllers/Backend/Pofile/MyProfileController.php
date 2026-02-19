<?php

namespace App\Http\Controllers\Backend\Pofile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyProfileController extends Controller
{
    public function index()
    {
        return view('backend.profile.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required',
            'position' => 'required',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->position = $request->position;
        $user->username = $request->username;

        if ($request->hasFile('user_image')) {
            if ($user->user_image && file_exists(public_path($user->user_image))) {
                unlink(public_path($user->user_image));
            }

            // Ensure directory exists
            $uploadPath = public_path('uploads/users');
            if (! file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true); // ← add this
            }

            $image = $request->file('user_image');
            $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move($uploadPath, $imageName);
            $user->user_image = 'uploads/users/'.$imageName;
        }

        $user->save();

        return redirect()->route('dashboard.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Use DB update instead of Auth user cache
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('dashboard.profile')->with('success', 'Password updated successfully.');
    }
}