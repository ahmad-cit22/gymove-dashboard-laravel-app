<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_wishlist_store(Request $request, $product_id){
        if (Auth::guard('customerAuth')->check()) {
            $request->validate([
                'color' => 'required',
                'size' => 'required',
            ], [
                'color.required' => 'Please select a color!',
                'size.required' => 'Please select a size!'
            ]);

            Cart::insert([
                ''
            ])
        } else {
            return redirect()->route('customer.reg')->with('customer_reg', 'You have to login first in order to add to cart.');
        }
        
    }
}
