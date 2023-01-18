<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    function checkout_view()
    {
        if (Auth::guard('customerAuth')->check()) {
            $cartItems = Cart::where('customer_id', Auth::guard('customerAuth')->id())->get();
            $countries = Country::all();

            return view('frontend.checkout', [
                'cartItems' => $cartItems,
                'countries' => $countries,
            ]);
        } else {
            return redirect()->route('customer.reg')->with('customer_reg', 'You have to login first in order to proceed.');
        }
    }

    function getCity(Request $request)
    {
        $country_id = $request->country_id;
        $cities = City::where('country_id', $country_id)->get();
        $str = '<option value="">-- Select City --</option>';

        foreach ($cities as $city) {
            $str .= '<option value=' . $city->id . '>' . $city->name . '</option>';
        }
        echo $str;
    }

    function order_store(Request $request)
    {
    }
}
