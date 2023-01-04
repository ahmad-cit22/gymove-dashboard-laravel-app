<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Inventory;
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
                if (Cart::where('customer_id', Auth::guard('customerAuth')->id())->where('product_id', $product_id)->where('color_id', $request->color)->where('size_id', $request->size)->exists()) {
                    Cart::where('customer_id', Auth::guard('customerAuth')->id())->where('product_id', $product_id)->where('color_id', $request->color)->where('size_id', $request->size)->increment('quantity', $request->quantity);
                } else {
                    Cart::insert([
                        'customer_id' => Auth::guard('customerAuth')->id(),
                        'product_id' => $product_id,
                        'color_id' => $request->color,
                        'size_id' => $request->size,
                        'quantity' => $request->quantity,
                        'created_at' => Carbon::now(),
                    ]);
                }


                return back()->with('cartSuccess', 'Added to cart successfully!');
            } else {

                if ((Wishlist::where('customer_id', Auth::guard('customerAuth')->id())->where('product_id', $product_id)->exists())) {
                    return back()->with('wishExists', 'This product already exists your wishlist!');
                } else {
                    Wishlist::insert([
                        'customer_id' => Auth::guard('customerAuth')->id(),
                        'product_id' => $product_id,
                        'created_at' => Carbon::now(),
                    ]);

                    return back()->with('wishSuccess', 'Added to wishlist successfully!');
                }
            }
        } else {
            return redirect()->route('customer.reg')->with('customer_reg', 'You have to login first in order to proceed.');
        }
    }

    function cart_remove($cart_id)
    {
        Cart::find($cart_id)->delete();

        return back()->with('removeSuccess', 'Removed an item from cart successfully.');
    }

    function cart_view(Request $request)
    {
        if (Auth::guard('customerAuth')->check()) {
            $cartItems = Cart::where('customer_id', Auth::guard('customerAuth')->id())->get();
            $coupon = $request->coupon_code;
            $message = '';
            $type = '';


            if ($coupon) {
                if (Coupon::where('coupon_code', $coupon)->exists()) {
                    if (Carbon::now()->format('Y-m-d') < Coupon::where('coupon_code', $coupon)->first()->validity) {
                        $discount = 100;
                    } else {
                        $discount = 0;
                        $message = 'This coupon code invalid';
                    }
                } else {
                    $discount = 0;
                    $message = 'This coupon code does not exist.';
                }
            } else {
                $discount = 0;
            }

            return view('frontend.cart', [
                'cartItems' => $cartItems,
                'discount' => $discount,
                'message' => $message,
            ]);
        } else {
            return redirect()->route('customer.reg')->with('customer_reg', 'You have to login first in order to proceed.');
        }
    }

    function cart_update(Request $request)
    {
        foreach ($request->quantity as $cart_id => $quantity) {
            Cart::find($cart_id)->update([
                'quantity' => $quantity,
            ]);
        }
        return back()->with('updateSuccess', 'Cart updated successfully!');
    }

    function wish_remove($wish_id)
    {
        Wishlist::find($wish_id)->delete();

        return back()->with('removeWishSuccess', 'Removed an item from wishlist successfully.');
    }

    function wish_view()
    {

        if (Auth::guard('customerAuth')->check()) {
            $wishItems = Wishlist::where('customer_id', Auth::guard('customerAuth')->id())->get();

            return view('frontend.wishlist', [
                'wishItems' => $wishItems,
            ]);
        } else {
            return redirect()->route('customer.reg')->with('customer_reg', 'You have to login first in order to proceed.');
        }
    }
}
