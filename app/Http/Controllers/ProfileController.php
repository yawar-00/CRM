<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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
            'current_password' => ['required', 'string'],
            'password' => ['nullable', 'string', Password::defaults(), 'confirmed'],
        ]);
        
        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'The provided password does not match your current password.',
            ])->withInput();
        }
        
        // Update name if provided
        if ($request->filled('name')) {
            $user->name = $validated['name'];
        }
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();
        
        return back()->with('success', 'Profile updated successfully!');
    }
}