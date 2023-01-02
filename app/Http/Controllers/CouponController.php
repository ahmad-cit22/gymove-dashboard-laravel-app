<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon_view()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.coupon', [
            'coupons' => $coupons,
        ]);
    }

    function coupon_store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|max:15',
            'type' => 'required',
            'amount' => 'required|numeric',
            'validity' => 'required',
        ]);

        Coupon::insert([
            'coupon_code' => $request->coupon_code,
            'type' => $request->type,
            'amount' => $request->amount,
            'limit' => $request->limit,
            'validity' => $request->validity,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('addSuccess', 'Coupon added successfully!');
    }
}
