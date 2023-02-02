<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;

class CustomerProfileController extends Controller
{
    function customer_profile_view()
    {

        $countries = Country::all();
        $cities = City::where('country_id', Auth::guard('customerAuth')->user()->country)->get();

        return view('frontend.customer_profile', [
    
            'countries' => $countries,
            'cities' => $cities,
        ]);
    }

    function customer_orders_view()
    {
        $country_name = Country::find(Auth::guard('customerAuth')->user()->country)->name;
        $city_name = City::find(Auth::guard('customerAuth')->user()->city)->name;
        $orders = Order::where('customer_id', Auth::guard('customerAuth')->id())->get();
        // $order_products = OrderProduct::where('customer_id', Auth::guard('customerAuth')->id())->get();

        return view('frontend.my_orders', [
            'country_name' => $country_name,
            'city_name' => $city_name,
            'orders' => $orders,
        ]);
    }

    function customer_profile_update(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|email:rfc,dns',
                'city' => 'required',
                'country' => 'required',
                'address' => 'required',
                'zip_code' => 'required',
                'phone_code' => 'required',
                'phone_number' => 'required',
            ],
            [
                'name.regex' => "Name can't contain numbers or symbols!",
                'country.required' => "Please select your country.",
                'city.required' => "Please select your city.",
            ]
        );



        if ($request->old_password != '' || $request->password != '') {
            $request->validate(
                [
                    'password' => [Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
                    'password_confirmation' => 'required',
                ],
                [
                    'password.confirmed' => "Confirm your new password correctly!",
                ]
            );

            if (Hash::check($request->old_password, Auth::guard('customerAuth')->user()->password)) {
                Customer::find(Auth::guard('customerAuth')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'city' => $request->city,
                    'country' => $request->country,
                    'address' => $request->address,
                    'zip_code' => $request->zip_code,
                    'phone_code' => $request->phone_code,
                    'phone_number' => $request->phone_number,
                    'password' => bcrypt($request->password),
                ]);

                if ($request->profile_picture != '') {

                    $request->validate(
                        [
                            'profile_picture' => ['mimes:jpg,jpeg,png,gif,webp', 'max:2024'],
                        ]
                    );

                    $uploaded_image = $request->profile_picture;
                    $ext = $uploaded_image->getClientOriginalExtension();
                    $photo_name = Auth::guard('customerAuth')->id() . '.' . $ext;

                    Image::make($uploaded_image)->save(public_path('uploads/customer/' . $photo_name));
                    Customer::find(Auth::guard('customerAuth')->id())->update([
                        'profile_picture' => $photo_name,
                    ]);
                }
            } else {
                return back()->with('errPass', 'Wrong password entered!');
            }
        } else {
            Customer::find(Auth::guard('customerAuth')->id())->update([
                'name' => $request->name,
                'email' => $request->email,
                'city' => $request->city,
                'country' => $request->country,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'phone_code' => $request->phone_code,
                'phone_number' => $request->phone_number,
            ]);

            if ($request->profile_picture != '') {

                $request->validate(
                    [
                        'profile_picture' => ['mimes:jpg,jpeg,png,gif,webp', 'max:2024'],
                    ]
                );

                $uploaded_image = $request->profile_picture;
                $ext = $uploaded_image->getClientOriginalExtension();
                $photo_name = Auth::guard('customerAuth')->id() . '.' . $ext;

                Image::make($uploaded_image)->save(public_path('uploads/customer/' . $photo_name));
                Customer::find(Auth::guard('customerAuth')->id())->update([
                    'profile_picture' => $photo_name,
                ]);
            }
        }

        return back()->with('updateSuccess', 'Profile Updated Successfully!');
    }
}
