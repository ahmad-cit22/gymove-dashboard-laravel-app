<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_wishlist_store(Request $request, $product_id)
    {
        if (Auth::guard('customerAuth')->check()) {
            if ($request->submitBtn === '1') {
                $request->validate([
                    'color' => 'required',
                    'size' => 'required',
                    'quantity' => 'required',
                ], [
                    'color.required' => 'Please select a color!',
                    'size.required' => 'Please select a size!',
                    'quantity.required' => 'Please select quantity!'
                ]);

                Cart::insert([
                    'customer_id' => Auth::guard('customerAuth')->id(),
                    'product_id' => $product_id,
                    'color_id' => $request->color,
                    'size_id' => $request->size,
                    'quantity' => $request->quantity,
                    'created_at' => Carbon::now(),
                ]);

                return back()->with('cartSuccess', 'Added to cart successfully!');
            } else {

                Wishlist::insert([
                    'customer_id' => Auth::guard('customerAuth')->id(),
                    'product_id' => $product_id,
                    'created_at' => Carbon::now(),
                ]);

                return back()->with('wishSuccess', 'Added to wishlist successfully!');
            }
        } else {
            return redirect()->route('customer.reg')->with('customer_reg', 'You have to login first in order to add to cart.');
        }
    }

    function cart_remove($cart_id)
    {
        Cart::find($cart_id)->delete();

        return back()->with('removeSuccess', 'Removed an item from cart successfully.');
    }
  
    function wish_remove($wish_id)
    {
        Wishlist::find($wish_id)->delete();

        return back()->with('removeWishSuccess', 'Removed an item from wishlist successfully.');
    }
}
