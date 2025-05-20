<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('auth.edit-profile');
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the form data
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'profileImg' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Max 2MB
        ]);

        // Update name if provided
        if ($request->filled('name')) {
            $user->name = $validated['name'];
        }

        // Process profile image if uploaded
        if ($request->hasFile('profileImg')) {
            // Delete old profile image if exists
            if ($user->profileImg && Storage::exists($user->profileImg)) {
                Storage::delete($user->profileImg);
            }
            if ($user->profileImg) {
                $imagePath = public_path($user->profileImg);
        
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            } 
           $manager = new ImageManager(new Driver());
            $name_gen = uniqid() . '.' . $request->file('profileImg')->getClientOriginalExtension();
            $img = $manager->read($request->file('profileImg'));
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save(public_path('Upload/ProfileImg/' . $name_gen));
            $save_url = 'Upload/ProfileImg/' . $name_gen;
            $user->profileImg = $save_url;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    
    public function editPassword()
    {
        return view('auth.change-password');
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validate the form data
        $validated = $request->validate([            
            'current_password' => ['required', 'string'],
            'password' => ['nullable', 'string', Password::defaults(), 'confirmed'],
        ]);

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'The provided password does not match your current password.',
            ])->withInput();
        }
        $user->password = Hash::make($validated['password']);

        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}