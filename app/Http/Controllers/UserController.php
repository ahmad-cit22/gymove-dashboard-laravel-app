<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    function users()
    {
        $users = User::all();
        return view('admin.users.users', compact('users'));
    }

    function user_delete($user_id)
    {
        User::find($user_id)->delete();
        return back()->with('delSuccess', 'User Deleted Successfully!');
    }

    function profile()
    {
        return view('admin.users.profile');
    }

    function profile_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns'
        ], [
            'name.required' => "You can't leave your name field empty!"
        ]);

        User::find(Auth::id())->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        return back()->with('updateInfoSuccess', 'Profile Info Updated Successfully!');
    }

    function password_update(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
            'password_confirmation' => 'required',
        ]);
        if (Hash::check($request->old_password, Auth::user()->password)) {
            User::find(Auth::id())->update([
                'password' => bcrypt($request->password),
            ]);
            return back()->with('updatePassSuccess', 'Password Updated Successfully!');
        } else {
            return back()->with('updatePassErr', 'Wrong Old Password!');
        }
    }

    function picture_update(Request $request)
    {
        $request->validate([
            'profile_picture' => ['required', 'mimes:jpg,jpeg,png,gif,webp', 'max:1024'],
        ]);

        $uploaded_image = $request->profile_picture;
        $image_extension = $uploaded_image->getClientOriginalExtension();
        $image_name = Auth::id() . '.' . $image_extension;
        Image::make($uploaded_image)->resize(300, 200)->save(public_path('uploads/user/' . $image_name));

        User::find(Auth::id())->update([
            'image' => $image_name,
        ]);
        return back()->with('updateDPSuccess', 'Profile Picture Updated Successfully!');
    }

    function cover_photo_update(Request $request)
    {
        $request->validate([
            'cover_photo' => ['required', 'mimes:png,jpg,jpeg,gif,webp', 'max:1024'],
        ]);

        $uploaded_cover = $request->cover_photo;
        $cover_extension = $uploaded_cover->getClientOriginalExtension();
        $cover_name = Auth::id() . '.cover.' . $cover_extension;
        Image::make($uploaded_cover)->resize(1600, 450)->save(public_path('uploads/user/' . $cover_name));

        User::find(Auth::id())->update([
            'cover_photo' => $cover_name,
        ]);
        return back()->with('updateCoverSuccess', 'Cover Photo Updated Successfully!');
    }
}
