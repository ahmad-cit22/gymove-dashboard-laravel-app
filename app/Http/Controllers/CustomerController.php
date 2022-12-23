<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            'password' => $request->password,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('regSuccess', 'Registration completed successfully!');
    }
}
