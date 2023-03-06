<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPassReset;
use App\Notifications\PassResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

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

    function customer_password_reset()
    {
        return view('frontend.password_reset');
    }

    function password_reset(Request $request)
    {
        $email = $request->email;
        $customer_info = Customer::where('email', $email)->first();

        if ($customer_info) {
            CustomerPassReset::where('customer_id', $customer_info->id)->delete();

            $info = CustomerPassReset::create([
                'customer_id' => $customer_info->id,
                'token' => Str::random(60),
                // 'token' => uniqid('KUMO-'),
            ]);

            // $customer_info->notify(new PassResetNotification($info)); // Using The Notifiable Trait
            Notification::send($customer_info, new PassResetNotification($info)); // Using The Notification Facade

            return back()->with('success', 'Reset link sent! Please check your email. N.B. The sent link will be expired after 15 minutes.');;
        } else {
            return back()->with('emailError', 'User not found! Please check your email address.');
        }
    }

    function password_reset_form($token)
    {
        $customer_info = CustomerPassReset::where('token', $token)->first();
        if ($customer_info) {
            return view('frontend.password_reset_form', [
                'resetToken' => $token,
            ]);
        } else {
            return redirect()->route('customer.reg')->with('tokenError', 'Security token not found! Kindly send reset request again.');
        }
    }

    function password_reset_form_handle(Request $request, $token)
    {
        $customer_info = CustomerPassReset::where('token', $token)->first();
        $validity = $customer_info->created_at->addMinutes(15); // add 15 minutes time limit

        if ($customer_info) {
            if ($validity > Carbon::now()) {
                if (!$customer_info->is_used) {
                    $request->validate(
                        [
                            'password' => [Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
                            'password_confirmation' => 'required',
                        ],
                        [
                            'password.confirmed' => "You have to confirm your new password correctly!",
                        ]
                    );

                    Customer::find($customer_info->customer_id)->update([
                        'password' => Hash::make($request->password)
                        // 'password' => bcrypt($request->password)
                    ]);

                    // CustomerPassReset::where('customer_id', $customer_info->customer_id)->delete(); // delete the reset info from reset table after reset
                    $customer_info->update([
                        'is_used' => 1
                    ]);

                    return redirect()->route('customer.reg')->with('resetSuccess', 'Password has been reset successfully!');
                } else {
                    return redirect()->route('customer.reg')->with('usedLink', 'The reset link has already been used once! So you have to send the reset request again & get a new link.');
                }
            } else {
                return redirect()->route('customer.reg')->with('validityOver', 'The reset link is expired! Kindly send reset request again.');
            }
        } else {
            return redirect()->route('customer.reg')->with('tokenError', 'Security token not found! Kindly send reset request again.');
        }
    }
}
