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
        $trashedCoupons = Coupon::onlyTrashed()->get();
        return view('admin.coupon.coupon', [
            'coupons' => $coupons,
            'trashedCoupons' => $trashedCoupons,
        ]);
    }

    function coupon_store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|max:15|unique:coupons',
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

    function coupon_edit_view($coupon_id)
    {
        $coupon = Coupon::find($coupon_id);

        return view('admin.coupon.edit', [
            'coupon' => $coupon,
        ]);
    }

    function coupon_update(Request $request, $coupon_id)
    {
        if (Coupon::find($coupon_id)->coupon_code === $request->coupon_code && Coupon::find($coupon_id)->type == $request->type && Coupon::find($coupon_id)->amount == $request->amount && Coupon::find($coupon_id)->limit == $request->limit && Coupon::find($coupon_id)->validity == $request->validity) {
            return back()->with('updateErr', "You didn't update anything!");
        } else {
            if (Coupon::find($coupon_id)->coupon_code === $request->coupon_code) {
                $request->validate([
                    'coupon_code' => 'required|max:15',
                    'type' => 'required',
                    'amount' => 'required|numeric',
                    'validity' => 'required',
                ]);
            } else {
                $request->validate([
                    'coupon_code' => 'required|max:15|unique:coupons',
                    'type' => 'required',
                    'amount' => 'required|numeric',
                    'validity' => 'required',
                ]);
            }

            Coupon::find($coupon_id)->update([
                'coupon_code' => $request->coupon_code,
                'type' => $request->type,
                'amount' => $request->amount,
                'limit' => $request->limit,
                'validity' => $request->validity,
                'updated_at' => Carbon::now(),
            ]);

            return redirect()->route('coupon.view')->with('updateSuccess', 'Coupon updated successfully!');
        }
    }

    function coupon_delete($coupon_id)
    {
        Coupon::find($coupon_id)->delete();
        return back()->with('softDelSuccess', 'Coupon moved to trash successfully!');
    }

    function coupon_delete_force($coupon_id)
    {
        Coupon::onlyTrashed()->find($coupon_id)->forceDelete();
        return back()->with('forceDelSuccess', 'Coupon deleted permanently!');
    }

    function coupon_restore($coupon_id)
    {
        Coupon::onlyTrashed()->find($coupon_id)->restore();
        return back()->with('restoreSuccess', 'Coupon restored successfully!');
    }
}
