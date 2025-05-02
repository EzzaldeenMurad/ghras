<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'region' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // dd($validated);
        // Update user data
        $user->name = $validated['name'];
        $user->region = $validated['region'];


        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $image = $request->file('image');
            $imageName =  time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/users/' . $imageName;

            // Make sure the directory exists
            if (!file_exists(public_path('images/users'))) {
                mkdir(public_path('images/users'), 0755, true);
            }

            $image->move(public_path('images/users'), $imageName);
            $user->image = $imagePath;
        }
        if ($user->role === 'consultant') {
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
}
