<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe;
use Illuminate\Support\Str;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe.stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $customer_id = Auth::guard('customerAuth')->id();
        $checkout_info = session('info');
        $total = $checkout_info['sub_total'] + $checkout_info['charge'] - ($checkout_info['discount']);
        $city_name = City::find($checkout_info['city']);
        $rand_string = substr($city_name->name, 0, 3);
        $order_id =  '#' . Str::upper($rand_string) . '-' . random_int(10000999, 99999999);

        // echo $request->stripeToken; //can be stored as a unique identifier
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));


        $customer = Stripe\Customer::create(array(

            "address" => [
                "line1" => $checkout_info['address'],
                "postal_code" => $checkout_info['zip'],
                "city" => $checkout_info['city'],
                "country" => $checkout_info['country'],
            ],
            "email" => $checkout_info['email'],
            "name" => $checkout_info['name'],
            "source" => $request->stripeToken
        ));

        Stripe\Charge::create([

            "amount" => 100 * $total,
            "currency" => "bdt",
            "customer" => $customer->id,
            "description" => "Test payment from kumo-ecommerce.com.",
            "shipping" => [
                "name" => $checkout_info['name'],
                "address" => [
                    "line1" => $checkout_info['address'],
                    "postal_code" => $checkout_info['zip'],
                    "city" => $checkout_info['city'],
                    "country" => $checkout_info['country'],
                ],
            ]
        ]);

        Order::insert([
            'order_id' => $order_id,
            'stripe_token' => $request->stripeToken,
            'customer_id' => Auth::guard('customerAuth')->id(),
            'sub_total' => $checkout_info['sub_total'],
            'discount' => $checkout_info['discount'],
            'charge' => $checkout_info['charge'],
            'total' => $total,
            'payment_method' => 3,
            'created_at' => Carbon::now(),
        ]);

        BillingDetails::insert([
            'order_id' => $order_id,
            'customer_id' => Auth::guard('customerAuth')->id(),
            'name' => $checkout_info['name'],
            'email' => $checkout_info['email'],
            'company' => $checkout_info['company'],
            'mobile_number' => $checkout_info['mobile_number'],
            'address' => $checkout_info['address'],
            'country_id' => $checkout_info['country'],
            'city_id' => $checkout_info['city'],
            'zip' => $checkout_info['zip'],
            'note' => $checkout_info['note'],
            'created_at' => Carbon::now(),
        ]);

        $carts = Cart::where('customer_id', Auth::guard('customerAuth')->id())->get();

        foreach ($carts as $cart) {
            OrderProduct::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customerAuth')->id(),
                'product_id' => $cart->product_id,
                'price' => $cart->rel_to_product->after_discount,
                'color_id' => $cart->color_id,
                'size_id' => $cart->size_id,
                'quantity' => $cart->quantity,
                'created_at' => Carbon::now(),
            ]);

            // Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
        }


        // Cart::where('customer_id', Auth::guard('customerAuth')->id())->delete();

        // Mail::to($checkout_info['email'])->send(new InvoiceMail($order_id));

        //sms
        // $total_pay = $request->sub_total+$request->charge - ($request->discount);
        // $url = "http://bulksmsbd.net/api/smsapi";
        // $api_key = "KooLM18wNAssXp8C7Wer";
        // $senderid = "nafis";
        // $number = $checkout_info['mobile'];
        // $message = "Congratulations! your order has been successfully placed! please ready taka ".$total_pay;

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

        // $total_pay = $request->sub_total+$request->charge - ($request->discount);
        // $url = "http://bulksmsbd.net/api/smsapi";
        // $api_key = "uhbVpMBKVDrdl6OOQjXw";
        // $senderid = "nafis22";
        // $number = $request->mobile;
        // $message = "Congratulations! your order has been successfully placed! please ready taka ".$total_pay;

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


        // $stripe_info = Stripe\Charge::create([
        //     "amount" => 100 * $total,
        //     "currency" => "bdt",
        //     "source" => $request->stripeToken,
        //     "description" => "Test payment from kumo-ecommerce.com.",
        //     // "name" => "Jenny Rosen",
        //     // "address" => [
        //     //     "line1" => "510 Townsend St",
        //     //     "postal_code" => "98140",
        //     //     "city" => "San Francisco",
        //     //     "state" => "CA",
        //     //     "country" => "US",
        //     // ],
        // ]);

        // echo $stripe_info;
        // die();

        Session::flash('success', 'Payment successful!');

        return redirect()->route('order.success')->with('orderSuccess', 'Order placed successfully!');
    }
}
