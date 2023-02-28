<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    function orders_view(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = Order::select('id', 'order_id', 'customer_id', 'sub_total', 'discount', 'charge', 'total', 'payment_method', 'order_status')->get();
        //     return DataTables::of($data)->addIndexColumn()
        //         ->addColumn('action', function ($row) {
        //             $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
        //             return $btn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }
        $orders = Order::all();
        $completed_orders = Order::where('order_status', 6)->get();
        $canceled_orders = Order::where('order_status', 7)->get();

        return view('admin.orders.orders', [
            'orders' => $orders,
            'completed_orders' => $completed_orders,
            'canceled_orders' => $canceled_orders,
        ]);
    }


    function order_status_update(Request $request, $order_id){
        Order::find($order_id)->update([
            'order_status' => $request->status,

        ]);
        return back()->with('updateSuccess', 'Order status updated successfully!');

    }
}
