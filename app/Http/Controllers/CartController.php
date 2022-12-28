<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_wishlist_store(Request $request, $product_id){
        print_r($request->all());
        // if (Auth::guard('customerAuth')->check()) {
        //     echo 'good';
        // } else {
        //     return redirect()->route('customer.reg')->with('customer_reg', 'Please sign in or register in order to add to cart.');
        // }
        
    }
}
