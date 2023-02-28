<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    function checkout_view()
    {
        if (Auth::guard('customerAuth')->check()) {
            $cartItems = Cart::where('customer_id', Auth::guard('customerAuth')->id())->get();
            $countries = Country::all();
            if ($cartItems->count() > 0) {
                return view('frontend.checkout', [
                    'cartItems' => $cartItems,
                    'countries' => $countries,
                ]);
            } else {
                return back()->with('checkoutFailed', 'Add your desired products to your cart first.');
            }
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
        $request->validate(
            [
                'name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|email:rfc,dns',
                'mobile_number' => 'required',
                'address' => 'required',
                'city' => 'required',
                'country' => 'required',
                'payment_method' => 'required',
                'charge' => 'required',
            ],
            [
                'name.regex' => "Name can't contain numbers or symbols!",
                'country.required' => "Please select your country.",
                'city.required' => "Please select your city.",
                'charge.required' => "Please select your delivery location.",
                'payment_method.required' => "Please select your payment method.",
            ]
        );

        $city_name = City::find($request->city)->name;
        $subStr = substr($city_name, 0, 3);
        $order_id = '#' . Str::upper($subStr) . '-' . rand(1000000, 9999999);

        $cartItems = Cart::where('customer_id', Auth::guard('customerAuth')->id())->get();
        $total = $request->total + $request->charge;

        if ($request->payment_method === '1') {
            Order::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customerAuth')->id(),
                'sub_total' => $request->sub_total,
                'discount' => $request->discount,
                'charge' => $request->charge,
                'total' =>  $total,
                'payment_method' => $request->payment_method,
                'created_at' => Carbon::now(),
            ]);

            BillingDetails::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customerAuth')->id(),
                'name' => $request->name,
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'company' => $request->company,
                'address' => $request->address,
                'city_id' => $request->city,
                'country_id' => $request->country,
                'zip' => $request->zip,
                'note' => $request->note,
                'created_at' => Carbon::now(),
            ]);

            foreach ($cartItems as $item) {
                OrderProduct::insert([
                    'order_id' => $order_id,
                    'customer_id' => Auth::guard('customerAuth')->id(),
                    'product_id' => $item->product_id,
                    'price' => $item->rel_to_product->after_discount,
                    'color_id' => $item->color_id,
                    'size_id' => $item->size_id,
                    'quantity' => $item->quantity,
                    'created_at' => Carbon::now(),
                ]);

                // Inventory::where('product_id', $item->product_id)->where('color_id', $item->color_id)->where('size_id', $item->size_id)->decrement('quantity', $item->quantity);
            }
            // Cart::where('customer_id', Auth::guard('customerAuth')->id())->delete();

            // mail sending
            // Mail::to($request->email)->send(new InvoiceMail($order_id));

            //sms sending api
            // $url = "http://bulksmsbd.net/api/smsapi";
            // $api_key = "Pojzn1smeSdqqmAnOfrD";
            // $senderid = "nafisweb22";
            // $number = $request->mobile_number;
            // $message = "Dear customer, your order has been placed successfully. The order ID is - " . $order_id . " and you have to pay BDT " .  $total . " only. Thank you for being with us.";

            // $data = [
            //     "api_key" => $api_key,
            //     "senderid" => $senderid,
            //     "number" => $number,
            //     "message" => $message
            // ];
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_POST, 1);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // $response = curl_exec($ch);
            // curl_close($ch);

            return redirect()->route('order.success')->with('orderSuccess', 'Order placed successfully!');
        } elseif ($request->payment_method === '2') {
            $checkout_info = $request->all();
            return redirect('/pay')->with('checkout_info', $checkout_info);
        } else {
            echo 'str';
        }
    }

    function order_success()
    {
        return view('frontend.orderSuccess');
    }
}
