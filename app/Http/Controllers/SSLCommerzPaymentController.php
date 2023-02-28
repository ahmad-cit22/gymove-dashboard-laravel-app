<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Ssl_order;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;


class SslCommerzPaymentController extends Controller
{

    // public function exampleEasyCheckout()
    // {
    //     return view('exampleEasycheckout');
    // }
    // public function exampleHostedCheckout()
    // {
    //     return view('exampleHosted');
    // }

    public function index(Request $request)
    {

        $customer_id = Auth::guard('customerAuth')->id();
        $checkout_info = session('checkout_info');
        $total = $checkout_info['sub_total'] + $checkout_info['charge'] - ($checkout_info['discount']);
        $city_name = City::find($checkout_info['city']);
        $rand_string = substr($city_name->name, 0, 3);
        $order_id =  '#' . Str::upper($rand_string) . '-' . random_int(10000999, 99999999);

        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "sslorders"
        # In "sslorders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('ssl_orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $checkout_info['name'],
                'email' => $checkout_info['email'],
                'mobile_number' => $checkout_info['mobile_number'],
                'address' => $checkout_info['address'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'order_id' => $order_id,
                'customer_id' => $customer_id,
                'discount' => $checkout_info['discount'],
                'sub_total' => $checkout_info['sub_total'],
                'charge' => $checkout_info['charge'],
                'total' => $total,
                'status' => 'Pending',
                'company' => $checkout_info['company'],
                'country_id' => $checkout_info['country'],
                'city_id' => $checkout_info['city'],
                'zip' => $checkout_info['zip'],
                'note' => $checkout_info['note'],
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
        // echo 'asd';

    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "ssl_orders"
        # In ssl_orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('ssl_orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        // echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $order_info = Ssl_order::where('transaction_id', $tran_id)->first();
        $order_id = $order_info->order_id;

        Ssl_order::where('transaction_id', $tran_id)->update([
            'status' => 'completed'
        ]);

        Order::insert([
            'order_id' => $order_id,
            'customer_id' => Auth::guard('customerAuth')->id(),
            'sub_total' => $order_info->sub_total,
            'discount' => $order_info->discount,
            'charge' => $order_info->charge,
            'total' =>  $order_info->total,
            'payment_method' => 2,
            'order_status' => 2,
            'created_at' => Carbon::now(),
        ]);

        BillingDetails::insert([
            'order_id' => $order_id,
            'customer_id' => Auth::guard('customerAuth')->id(),
            'name' => $order_info->name,
            'email' => $order_info->email,
            'mobile_number' => $order_info->mobile_number,
            'company' => $order_info->company,
            'address' => $order_info->address,
            'city_id' => $order_info->city_id,
            'country_id' => $order_info->country_id,
            'zip' => $order_info->zip,
            'note' => $order_info->note,
            'created_at' => Carbon::now(),
        ]);

        $cartItems = Cart::where('customer_id', Auth::guard('customerAuth')->id())->get();

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
        // Mail::to($order_info->email)->send(new InvoiceMail($order_id));

        //sms sending api
        // $url = "http://bulksmsbd.net/api/smsapi";
        // $api_key = "Pojzn1smeSdqqmAnOfrD";
        // $senderid = "nafisweb22";
        // $number = $order_info->mobile_number;
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
        // =======================
    }

    public function fail(Request $request)
    {
        abort('500');
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('ssl_orders')
            ->where('transaction_id', $tran_id)
            ->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('ssl_orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('ssl_orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('ssl_orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('ssl_orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('ssl_orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
