<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    function customer_reg_view()
    {
        return view('frontend.login_reg');
    }

    function customer_signup(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|min:3',
            'email' => 'required|email:rfc,dns|unique:customers',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->symbols()->numbers(), 'confirmed'],
            'password_confirmation' => 'required',
        ], [
            'name.required' => 'You must enter your name!',
            'name.regex' => "Name can't contain numbers!",
        ]);

        Customer::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => Carbon::now(),
        ]);
        return back()->with('regSuccess', 'Registration completed successfully!');
    }

    function customer_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ], [
            'email.required' => 'You must enter your email!',
            'email.email' => 'Invalid email format!',
            'password.required' => 'You must enter your password!',
        ]);

        if (Auth::guard('customerAuth')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/')->with('loginSuccess', 'Logged in successfully!');
        } else {
            return back()->with('loginFailed', 'Wrong credentials given! Try again pls.');
        }
    }

    function customer_logout()
    {
        Auth::guard('customerAuth')->logout();
        return redirect()->route('customer.reg')->with('logoutSuccess', 'Logged out successfully!');
    }

    function customer_update(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|regex:/^[a-zA-Z\s]+$/|min:3',
        //     'email' => 'required|email:rfc,dns|unique:customers',
        //     'password' => ['required', Password::min(8)->letters()->mixedCase()->symbols()->numbers(), 'confirmed'],
        //     'password_confirmation' => 'required',
        // ], [
        //     'name.required' => 'You must enter your name!',
        //     'name.regex' => "Name can't contain numbers!",
        // ]);

        // Customer::find()([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        //     'created_at' => Carbon::now(),
        // ]);
        // return back()->with('regSuccess', 'Registration completed successfully!');
    }
}
