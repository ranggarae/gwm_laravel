<?php

namespace App\Http\Controllers;

use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\EventPaymentLogs;
use App\Events;
use App\Http\Traits\PaytmTrait;
use App\Mail\PaymentSuccess;
use App\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use KingFlamez\Rave\Facades\Rave;
use Razorpay\Api\Api;
use Stripe\Charge;
use Mollie\Laravel\Facades\Mollie;
use Stripe\Stripe;
use Unicodeveloper\Paystack\Facades\Paystack;
use function App\Http\Traits\getChecksumFromArray;

class ProductOrderController extends Controller
{
    use PaytmTrait;
    public function product_checkout(Request $request){
        $this->validate($request,[
            'payment_gateway' => 'nullable|string',
            'subtotal' => 'required|string',
            'coupon_discount' => 'nullable|string',
            'shipping_cost' => 'nullable|string',
            'product_shippings_id' => 'nullable|string',
            'total' => 'required|string',
            'billing_name' => 'required|string',
            'billing_email' => 'required|string',
            'billing_phone' => 'required|string',
            'billing_country' => 'required|string',
            'billing_street_address' => 'required|string',
            'billing_town' => 'required|string',
            'billing_district' => 'required|string',
            'different_shipping_address' => 'nullable|string',
            'shipping_name' => 'nullable|string',
            'shipping_email' => 'nullable|string',
            'shipping_phone' => 'nullable|string',
            'shipping_country' => 'nullable|string',
            'shipping_street_address' => 'nullable|string',
            'shipping_town' => 'nullable|string',
            'shipping_district' => 'nullable|string'
        ],
        [
            'billing_name.required' => __('The billing name field is required.'),
            'billing_email.required' => __('The billing email field is required.'),
            'billing_phone.required' => __('The billing phone field is required.'),
            'billing_country.required' => __('The billing country field is required.'),
            'billing_street_address.required' => __('The billing street address field is required.'),
            'billing_town.required' => __('The billing town field is required.'),
            'billing_district.required' => __('The billing district field is required.')
        ]);
            $order_details = ProductOrder::find($request->order_id);
            if (empty($order_details)){
                $order_details = ProductOrder::create([
                    'payment_gateway' => $request->selected_payment_gateway,
                    'payment_status' => 'pending',
                    'payment_track' => Str::random(10). Str::random(10),
                    'user_id' => auth()->check() ? auth()->user()->id : null,
                    'subtotal' => $request->subtotal,
                    'coupon_discount' => $request->coupon_discount,
                    'coupon_code' => session()->get('coupon_discount'),
                    'shipping_cost' => $request->shipping_cost,
                    'product_shippings_id' => $request->product_shippings_id,
                    'total' => $request->total,
                    'billing_name'  => $request->billing_name,
                    'billing_email'  => $request->billing_email,
                    'billing_phone'  => $request->billing_phone,
                    'billing_country' => $request->billing_country,
                    'billing_street_address' => $request->billing_street_address,
                    'billing_town' => $request->billing_town,
                    'billing_district' => $request->billing_district,
                    'different_shipping_address' => $request->different_shipping_address ? 'yes' : 'no',
                    'shipping_name' => $request->shipping_name,
                    'shipping_email' => $request->shipping_email,
                    'shipping_phone' => $request->shipping_phone,
                    'shipping_country' => $request->shipping_country,
                    'shipping_street_address' => $request->shipping_street_address,
                    'shipping_town' => $request->shipping_town,
                    'shipping_district' => $request->shipping_district,
                    'cart_items' => !empty(session()->get('cart_item')) ? serialize(session()->get('cart_item')) : '',
                    'status' =>  'pending',
                ]);
            }

        if (empty(get_static_option('site_payment_gateway'))){
            rest_cart_session();
            return redirect()->route('frontend.product.payment.success',$order_details->id);
        }

        //have to work on below code
        if ($request->selected_payment_gateway == 'cash_on_delivery'){
            self::send_mail($order_details);
            rest_cart_session();
            return redirect()->route('frontend.product.payment.success',$order_details->id);

        }elseif ($request->selected_payment_gateway == 'paypal'){

            $payable_amount = $order_details->total;
            $currency_code = get_static_option('site_global_currency');
            if (!is_paypal_supported_currency()){
                $payable_amount = get_amount_in_usd($payable_amount,get_static_option('site_global_currency'));
                if ($payable_amount < 1){
                    return $payable_amount.__('USD amount is not supported by paypal');
                }
                $currency_code = 'USD';
            }

            $paypal_details['business'] = get_static_option('paypal_business_email');
            $paypal_details['cbt'] = get_static_option('site_'.get_default_language().'_title');
            $paypal_details['item_name'] = 'Payment For Product Order Id: #'.$order_details->id.' Payer Name: '.$order_details->billing_name.' Payer Email:'.$order_details->billing_email;
            $paypal_details['custom'] = $order_details->payment_track;
            $paypal_details['currency_code'] = $currency_code;
            $paypal_details['amount'] = number_format($payable_amount,2);
            $paypal_details['return'] = route('frontend.product.payment.success',$order_details->id);
            $paypal_details['cancel_return'] = route('frontend.product.payment.cancel',$order_details->id);
            $paypal_details['notify_url'] = route('frontend.product.paypal.ipn');

            return view('frontend.payment.paypal')->with(['paypal_details' => $paypal_details]);

        }elseif ($request->selected_payment_gateway == 'paytm'){

            $amount = $order_details->total;
            if (!is_paytm_supported_currency() ){
                $amount = get_amount_in_inr($amount,get_static_option('site_global_currency'));
            }


            $data_for_request = $this->handlePaytmRequest( $order_details->payment_track, $amount );

            $paytm_txn_url = PAYTM_TXN_URL;
            $paramList = $data_for_request['paramList'];
            $checkSum = $data_for_request['checkSum'];

            return view('frontend.payment.paytm')->with([
                'paytm_txn_url' => $paytm_txn_url,
                'paramList' => $paramList,
                'checkSum' => $checkSum,
            ]);

        }elseif ($request->selected_payment_gateway == 'manual_payment'){
            rest_cart_session();
            $this->validate($request,[
               'transaction_id_val' => 'required'
            ],[
                'transaction_id_val' => __('Transaction ID is required')
            ]);

            $order_details->transaction_id = $request->transaction_id_val;
            $order_details->save();

            self::send_mail($order_details);

            return redirect()->route('frontend.product.payment.success',$order_details->id);

        }elseif ($request->selected_payment_gateway == 'stripe'){

            $payable_amount = $order_details->total;

            $stripe_data['title'] = __('Payment of Your Order');
            $stripe_data['order_id'] = $order_details->id;
            $stripe_data['price'] = $payable_amount;
            $stripe_data['route'] = route('frontend.product.stripe.ipn');

            return view('frontend.payment.stripe')->with('stripe_data' ,$stripe_data);
        }
        elseif ($request->selected_payment_gateway == 'razorpay'){

            $payable_amount = $order_details->total;
            $currency_code = get_static_option('site_global_currency');

            if (!is_razorpay_supported_currency()){
                $payable_amount = get_amount_in_inr($order_details->total,get_static_option('site_global_currency'));
                $currency_code = 'INR';
            }

            $razorpay_data['currency_symbol'] = $currency_code;
            $razorpay_data['currency'] = $currency_code;
            $razorpay_data['price'] = number_format((float)$payable_amount, 2, '.', '');
            $razorpay_data['package_name'] = $order_details->billing_name;
            $razorpay_data['order_id'] = $order_details->id;
            $razorpay_data['route'] = route('frontend.product.razorpay.ipn');

            return view('frontend.payment.razorpay')->with('razorpay_data' ,$razorpay_data);
        }
        elseif ($request->selected_payment_gateway == 'paystack'){

            $payable_amount = $order_details->total;

            $currency_code = get_static_option('site_global_currency');

            if (!is_paystack_supported_currency()){
                $payable_amount = get_amount_in_ngn($order_details->total,get_static_option('site_global_currency'));
                $currency_code = 'NGN';
            }

            $paystack_data['currency'] = $currency_code;
            $paystack_data['price'] = $payable_amount;
            $paystack_data['package_name'] =  __('Product Order');
            $paystack_data['name'] = $order_details->billing_name;
            $paystack_data['email'] = $order_details->billing_email;
            $paystack_data['order_id'] = $order_details->id;
            $paystack_data['track'] = $order_details->payment_track;
            $paystack_data['route'] = route('frontend.product.paystack.pay');
            $paystack_data['type'] = 'product';

            return view('frontend.payment.paystack')->with(['paystack_data' => $paystack_data]);

        }elseif ($request->selected_payment_gateway == 'mollie'){

            $payable_amount =  $order_details->total;
            $currency_code = get_static_option('site_global_currency');

            if (!is_mollie_supported_currency() ){
                $payable_amount = get_amount_in_usd($order_details->total,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }

            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => $currency_code,
                    "value" => number_format((float)$payable_amount, 2, '.', ''),//"10.00" // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                "description" => "Product Order ID #".$order_details->id .' Name: '.$order_details->billing_name.' Email: '.$order_details->billing_email,
                "redirectUrl" => route('frontend.product.mollie.webhook'),
                "metadata" => [
                    "order_id" => $order_details->id,
                    "track" => $order_details->payment_track,
                ],
            ]);

            $payment = Mollie::api()->payments->get($payment->id);

            session()->put('mollie_payment_id',$payment->id);

            // redirect customer to Mollie checkout page
            return redirect($payment->getCheckoutUrl(), 303);
        }elseif ($request->selected_payment_gateway == 'flutterwave'){

            $payable_amount = $order_details->total;
            $currency_code = get_static_option('site_global_currency');

            if (!is_flutterwave_supported_currency()){
                $payable_amount = get_amount_in_usd($order_details->total,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }
            $flutterwave_data['currency'] = $currency_code;
            $flutterwave_data['name'] = $order_details->billing_name;
            $flutterwave_data['form_action'] = route('frontend.product.flutterwave.pay');
            $flutterwave_data['amount'] = $payable_amount;
            $flutterwave_data['description'] = "Order ID #".$order_details->id .' Name: '.$order_details->billing_name.' Email: '.$order_details->billing_email;
            $flutterwave_data['email'] = $order_details->billing_email;
            $flutterwave_data['country'] = get_visitor_country() ? get_visitor_country() : 'NG';
            $flutterwave_data['metadata'] = [
                ['metaname' => 'order_id', 'metavalue' => $order_details->id],
                ['metaname' => 'track', 'metavalue' => $order_details->payment_track],
            ];
            return view('frontend.payment.flutterwave')->with('flutterwave_data' ,$flutterwave_data);
        }elseif ($request->selected_payment_gateway == 'midtrans'){
            $payable_amount = $order_details->total;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000; // approximate conversion if not IDR
            }
            $title = 'Payment For Product Order Id: #'.$order_details->id;
            $redirect_url = MidtransController::getRedirectUrl(
                'product', 
                $order_details->payment_track, 
                $payable_amount, 
                $order_details->billing_name, 
                $order_details->billing_email, 
                $order_details->billing_phone, 
                $title
            );
            
            if ($redirect_url) {
                return redirect($redirect_url);
            }
            return redirect()->back()->with(['msg' => __('Midtrans Error. Please contact support.'), 'type' => 'danger']);
        }elseif ($request->selected_payment_gateway == 'xendit'){
            $payable_amount = $order_details->total;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000;
            }
            $title = 'Payment For Product Order Id: #'.$order_details->id;
            $redirect_url = XenditController::getRedirectUrl(
                'product',
                $order_details->payment_track,
                $payable_amount,
                $order_details->billing_name,
                $order_details->billing_email,
                $title
            );
            if ($redirect_url) {
                return redirect($redirect_url);
            }
            return redirect()->back()->with(['msg' => __('Xendit Error. Please contact support.'), 'type' => 'danger']);
        }

        return redirect()->route('homepage');
    }
    public function flutterwave_pay(Request $request){
        Rave::initialize(route('frontend.product.flutterwave.callback'));
    }
    /**
     * Obtain Rave callback information
     * @return void
     */
    public function flutterwave_callback(Request $request)
    {
        
        $response = json_decode(request()->resp);
        if(empty($response)){ return redirect()->route('homepage'); }
        $txRef =$response->data->data->txRef;
        $data = Rave::verifyTransaction($txRef);
        $chargeResponsecode = $data->data->chargecode;
        $track = $data->data->meta[1]->metavalue;

        $payment_logs = ProductOrder::where('payment_track', $track)->first();
        if (($chargeResponsecode == "00" || $chargeResponsecode == "0")){
            //update event payment log
            $transaction_id = $txRef;

            $payment_logs->payment_status = 'complete';
            $payment_logs->transaction_id = $transaction_id;
            $payment_logs->save();
            rest_cart_session();
            self::send_mail($payment_logs);

            return redirect()->route('frontend.product.payment.success',$payment_logs->id);

        }else{
            return redirect()->route('frontend.product.payment.cancel',$payment_logs->id);
        }

    }

    public function mollie_webhook(){
        $payment_id = session()->get('mollie_payment_id');
        $payment = Mollie::api()->payments->get($payment_id);
        session()->forget('mollie_payment_id');

         $payment_logs = ProductOrder::where( 'payment_track', $payment->metadata->track )->first();
         if ($payment->isPaid()){
            //update event payment logs
            $transaction_id = $payment->id;

            $payment_logs->payment_status = 'complete';
            $payment_logs->transaction_id = $transaction_id;
            $payment_logs->save();
            rest_cart_session();
            self::send_mail($payment_logs);
            return redirect()->route('frontend.product.payment.success',$payment_logs->id);
        }

       return redirect()->route('frontend.product.payment.cancel',$payment_logs->id);
    }


    public function paypal_ipn(Request $request)
    {

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        // Read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        /*
         * Post IPN data back to PayPal to validate the IPN data is genuine
         * Without this step anyone can fake IPN data
         */
        $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
//        $paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr";

        $ch = curl_init($paypalURL);
        if ($ch == FALSE) {
            return FALSE;
        }
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

        // Set TCP timeout to 30 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
        $res = curl_exec($ch);

        /*
         * Inspect IPN validation result and act accordingly
         * Split response headers and payload, a better way for strcmp
         */
        $tokens = explode("\r\n\r\n", trim($res));
        $res = trim(end($tokens));
        if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {

            $receiver_email = $_POST['receiver_email'];
            $mc_currency = $_POST['mc_currency'];
            $mc_gross = $_POST['mc_gross'];
            $track = $_POST['custom'];

            //GRAB DATA FROM DATABASE!!
            $order_details = ProductOrder::where('payment_track', $track)->first();
            $paypal_business_email = get_static_option('paypal_business_email');

            if ($receiver_email == $paypal_business_email && $order_details->payment_status == 'pending') {

                //update product order
                $order_details->payment_status = 'complete';
                $order_details->transaction_id = $_POST['txn_id'];
                $order_details->save();
                rest_cart_session();
                self::send_mail($order_details);

                return redirect()->route('frontend.product.payment.success',$order_details->id);
            }
        }
    }

    public function paytm_ipn(Request $request){
        $order_id = $request['ORDERID'];

        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {

            //update event payment logs
            $transaction_id = $request['TXNID'];
            $payment_logs = ProductOrder::where( 'payment_track', $order_id )->first();
            $payment_logs->payment_status = 'complete';
            $payment_logs->transaction_id = $transaction_id;
            $payment_logs->save();
            rest_cart_session();
            self::send_mail($payment_logs);
            return redirect()->route('frontend.product.payment.success',$payment_logs->id);

        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
            $payment_logs = ProductOrder::where( 'payment_track', $order_id )->first();
            return redirect()->route('frontend.product.payment.cancel',$payment_logs->id);
        }
    }

    public function stripe_ipn(Request $request)
    {
        // stripe customer payment token
        $stripe_token = $request->stripe_token;
        $order_details = ProductOrder::find($request->order_id);
        Stripe::setApiKey( get_static_option('stripe_secret_key') );

        if (!empty($stripe_token)){
            // charge customer with your amount
            $result = Charge::create(array(
                "currency" => get_static_option('site_global_currency'),
                "amount"   => $order_details->total * 100, // amount in cents,
                'source' => $stripe_token,
                'description' => 'Payment for Order ID '.$order_details->id .', Payer Name: '.$order_details->billing_name.', Payer Email: '.$order_details->billing_email,
            ));
        }

        if ($result->status == 'succeeded'){
            //event attendance update
            $order_details->payment_status = 'complete';
            $order_details->transaction_id = $result->balance_transaction;
            $order_details->save();
            rest_cart_session();
            self::send_mail($order_details);
            return redirect()->route('frontend.product.payment.success',$request->order_id);
        }
        return redirect()->route('frontend.product.payment.cancel',$request->order_id);

    }


    public function razorpay_ipn(Request $request){

        $order_details = ProductOrder::find($request->order_id);

        //get API Configuration
        $api = new Api(get_static_option('razorpay_key'), get_static_option('razorpay_secret'));
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if(!empty($request->razorpay_payment_id)) {
            try {
                $response = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount'=> $payment['amount']));
            } catch (\Exception $e) {
                return redirect()->route('frontend.product.payment.cancel',$request->order_id);
            }
            // Do something here for store payment details in database...
            //update attendance status
            $order_details->payment_status = 'complete';
            $order_details->transaction_id = $payment->id;
            $order_details->save();
            self::send_mail( $order_details);
        }

        rest_cart_session();
        return redirect()->route('frontend.product.payment.success',$request->order_id);

    }


    public function paystack_pay(){
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public static function send_mail($order_details){
        Mail::to(get_static_option('site_global_email'))->send(new \App\Mail\ProductOrder($order_details,'owner',__('You Have A New Product Order From ').get_static_option('site_'.get_default_language().'_title')));
        Mail::to($order_details->billing_email)->send(new \App\Mail\ProductOrder($order_details,'customer',__('You order has been placed in ').get_static_option('site_'.get_default_language().'_title')));
    }

    public function handlePaytmRequest( $order_id, $amount ) {
        // Load all functions of encdec_paytm.php and config-paytm.php
        $this->getAllEncdecFunc();
        $this->getConfigPaytmSettings();

        $checkSum = "";
        $paramList = array();

        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = get_static_option('paytm_merchant_mid');
        $paramList["ORDER_ID"] = $order_id;
        $paramList["CUST_ID"] = $order_id;
        $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
        $paramList["CHANNEL_ID"] = 'WEB';
        $paramList["TXN_AMOUNT"] = $amount;
        $paramList["WEBSITE"] = get_static_option('paytm_merchant_website');
        $paramList["CALLBACK_URL"] = route('frontend.product.paytm.ipn');
        $paytm_merchant_key = get_static_option('paytm_merchant_key');

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );

        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }
}
