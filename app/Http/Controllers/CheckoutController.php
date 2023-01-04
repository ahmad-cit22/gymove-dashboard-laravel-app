<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    function checkout_view()
    {
        if (Auth::guard('customerAuth')->check()) {
            $cartItems = Cart::where('customer_id', Auth::guard('customerAuth')->id())->get();

            return view('frontend.checkout', [
                'cartItems' => $cartItems,
            ]);
        } else {
            return redirect()->route('customer.reg')->with('customer_reg', 'You have to login first in order to proceed.');
        }
    }
}
 