<?php

namespace App\Http\Controllers;

use App\GigOrder;
use App\Http\Traits\PaytmTrait;
use App\Mail\PaymentSuccess;
use App\Order;
use App\PaymentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use KingFlamez\Rave\Facades\Rave;
use Mollie\Laravel\Facades\Mollie;
use Razorpay\Api\Api;
use Stripe\Charge;
use Stripe\Stripe;
use function App\Http\Traits\getChecksumFromArray;

class GigOrderController extends Controller
{
    use PaytmTrait;
    public function __construct()
    {
        $this->middleware('auth')->except(['paypal_ipn','paytm_ipn']);
    }

    public function gig_new_order(Request  $request){
        $this->validate($request,[
            'full_name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'message' => 'required',
            'additional_note' => 'nullable',
            'selected_payment_gateway' => 'required|string|max:191',
            'file' => 'nullable|mimes:zip|max:252000',
        ]);

        $payment_track = Str::random(32);
        $payment_gateway = $request->selected_payment_gateway;
        $gig_details = GigOrder::find($request->gig_order_id);
        if (empty($gig_details)){
            $gig_details = GigOrder::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'message' => $request->message,
                'additional_note' => $request->additional_note,
                'selected_payment_gateway' => $request->selected_payment_gateway,
                'gig_id' => $request->gig_id,
                'selected_plan_index' => $request->selected_plan_index,
                'selected_plan_revisions' => $request->selected_plan_revisions,
                'selected_plan_delivery_days' => $request->selected_plan_delivery_days,
                'selected_plan_price' => $request->selected_plan_price,
                'selected_plan_title' => $request->selected_plan_title,
                'payment_track' => $payment_track,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'seen' => 0,
                'user_id' => auth()->guard('web')->user()->id,
            ]);
        }

        //add file name to database;
        if ($request->hasFile('file')){
            $file = $request->file('file');
            $file_name = Str::slug($file->getClientOriginalName());
            $file_ext = strtolower($file->getClientOriginalExtension());
            if ($file_ext == 'zip'){
                $db_file_name = 'order-file'.$gig_details->id.$file_name.'.'.$file_ext;
                $file->move('assets/uploads/gig-files',$db_file_name);
                $gig_details->file = $db_file_name;
                $gig_details->save();
            }
        }


        if ($payment_gateway == 'paypal'){
            $payable_amount = $gig_details->selected_plan_price;
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
            $paypal_details['item_name'] = 'Payment For Gig Order Id: #'.$gig_details->id.' Gig Plan Name: '.$gig_details->selected_plan_title.' Payer Name: '.$gig_details->full_name.' Payer Email:'.$gig_details->email;
            $paypal_details['custom'] = $gig_details->payment_track;
            $paypal_details['currency_code'] = $currency_code;
            $paypal_details['amount'] = $payable_amount;
            $paypal_details['return'] = route('frontend.gig.order.payment.success',$gig_details->id);
            $paypal_details['cancel_return'] = route('frontend.gig.order.payment.cancel',$gig_details->id);
            $paypal_details['notify_url'] = route('frontend.gig.paypal.ipn');

            return view('frontend.payment.paypal')->with(['paypal_details' => $paypal_details]);

        }elseif($payment_gateway == 'paytm'){
            $amount = $gig_details->selected_plan_price;
            if (!is_paytm_supported_currency() ){
                $amount = get_amount_in_inr($amount,get_static_option('site_global_currency'));
            }
            $data_for_request = $this->handlePaytmRequest( $gig_details->payment_track, $amount );

            $paytm_txn_url = PAYTM_TXN_URL;
            $paramList = $data_for_request['paramList'];
            $checkSum = $data_for_request['checkSum'];

            return view('frontend.payment.paytm')->with([
                'paytm_txn_url' => $paytm_txn_url,
                'paramList' => $paramList,
                'checkSum' => $checkSum,
            ]);
        }elseif($payment_gateway == 'razorpay'){

            $payable_amount =  $gig_details->selected_plan_price;
            $currency_code = get_static_option('site_global_currency');

            if (!is_razorpay_supported_currency()){
                $payable_amount = get_amount_in_inr($payable_amount,get_static_option('site_global_currency'));
                $currency_code = 'INR';
            }

            $razorpay_data['currency_symbol'] = $currency_code;
            $razorpay_data['currency'] = $currency_code;
            $razorpay_data['price'] = $payable_amount;
            $razorpay_data['package_name'] = $gig_details->selected_plan_title;
            $razorpay_data['route'] = route('frontend.gig.razorpay.ipn');
            $razorpay_data['order_id'] = $gig_details->id;

            return view('frontend.payment.razorpay')->with('razorpay_data' ,$razorpay_data);

        }elseif($payment_gateway == 'stripe'){

            $stripe_data['title'] = __('Payment of order:').' '.$gig_details->selected_plan_title;
            $stripe_data['order_id'] = $gig_details->id;
            $stripe_data['price'] = $gig_details->selected_plan_price;
            $stripe_data['route'] = route('frontend.gig.stripe.ipn');

            return view('frontend.payment.stripe')->with('stripe_data' ,$stripe_data);

        }elseif($payment_gateway == 'mollie'){
            $payable_amount = $gig_details->selected_plan_price;
            $currency_code = get_static_option('site_global_currency');

            if (!is_mollie_supported_currency() ){
                $payable_amount = get_amount_in_usd($payable_amount,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }

            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => $currency_code,
                    "value" => number_format((float)$payable_amount, 2, '.', ''),//"10.00" // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                "description" => 'Payment For Gig Order Id: #'.$gig_details->id.' Package Name: '.$gig_details->selected_plan_title.' Payer Name: '.$gig_details->full_name.' Payer Email:'.$gig_details->email,
                "redirectUrl" => route('frontend.gig.mollie.webhook'),
                "metadata" => [
                    "order_id" => $gig_details->id,
                    "track" => $gig_details->payment_track,
                ],
            ]);

            $payment = Mollie::api()->payments->get($payment->id);

            session()->put('mollie_payment_id',$payment->id);

            // redirect customer to Mollie checkout page
            return redirect($payment->getCheckoutUrl(), 303);
        }elseif($payment_gateway == 'paystack'){

            $payable_amount = $gig_details->selected_plan_price;
            $currency_code = get_static_option('site_global_currency');

            if (!is_paystack_supported_currency()){
                $payable_amount = get_amount_in_ngn($payable_amount,get_static_option('site_global_currency'));
                $currency_code = 'NGN';
            }

            $paystack_data['currency'] = $currency_code;
            $paystack_data['price'] = $payable_amount;
            $paystack_data['package_name'] =  $gig_details->selected_plan_title;
            $paystack_data['name'] = $gig_details->full_name;
            $paystack_data['email'] = $gig_details->email;
            $paystack_data['order_id'] = $gig_details->id;
            $paystack_data['track'] = $gig_details->payment_track;
            $paystack_data['route'] = route('frontend.paystack.pay');
            $paystack_data['type'] = 'gig';

            return view('frontend.payment.paystack')->with(['paystack_data' => $paystack_data]);

        }elseif($payment_gateway == 'flutterwave'){

            $payable_amount = $gig_details->selected_plan_price;
            $currency_code = get_static_option('site_global_currency');

            if (!is_flutterwave_supported_currency()){
                $payable_amount = get_amount_in_usd($payable_amount,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }

            $flutterwave_data['currency'] = $currency_code;
            $flutterwave_data['name'] = $gig_details->full_name;
            $flutterwave_data['form_action'] = route('frontend.gig.flutterwave.pay');
            $flutterwave_data['amount'] = $payable_amount;
            $flutterwave_data['description'] = 'Payment For Order Id: #'.$gig_details->id.' Package Name: '.$gig_details->selected_plan_title.' Payer Name: '.$gig_details->full_name.' Payer Email:'.$gig_details->email;
            $flutterwave_data['email'] = $gig_details->email;
            $flutterwave_data['country'] = get_visitor_country() ? get_visitor_country() : 'NG';
            $flutterwave_data['metadata'] = [
                ['metaname' => 'order_id', 'metavalue' => $gig_details->id],
                ['metaname' => 'track', 'metavalue' => $gig_details->payment_track],
            ];
            return view('frontend.payment.flutterwave')->with('flutterwave_data' ,$flutterwave_data);

        }elseif($payment_gateway == 'manual_payment'){
            $this->validate($request,[
                'transaction_id' => 'required'
            ],[
                'transaction_id.required' => __('you must have to provide transaction id for verify your payment')
            ]);
            $gig_details->transaction_id = $request->transaction_id;
            $gig_details->save();
            $this->send_order_mail($gig_details->id);
            return redirect()->route('frontend.gig.order.payment.success',$gig_details->id);
        }

        return redirect()->route('homepage');
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
        $paypalURL = get_paypal_form_url();
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
            $payment_logs = GigOrder::where('payment_track', $track)->first();
            $paypal_business_email = get_static_option('paypal_business_email');

            if ($receiver_email == $paypal_business_email && $payment_logs->status == 'pending') {
                //send success mail to user and admin
                $payment_logs = GigOrder::where('payment_track', $track)->first();
                $payment_logs->payment_status = 'complete';
                $payment_logs->transaction_id = $_POST['txn_id'];
                $payment_logs->save();

                self::send_order_mail($payment_logs->id);

            }
        }
    }

    public function flutterwave_pay(Request $request){
        Rave::initialize(route('frontend.gig.flutterwave.callback'));
    }
    /**
     * Obtain Rave callback information
     * @return void
     */
    public function flutterwave_callback(Request $request)
    {
        $response = json_decode(request()->resp);
        $txRef =$response->data->data->txRef;
        $data = Rave::verifyTransaction($txRef);
        $chargeResponsecode = $data->data->chargecode;
        $track = $data->data->meta[1]->metavalue;

        $payment_logs = GigOrder::where( 'payment_track', $track )->first();
        if (($chargeResponsecode == "00" || $chargeResponsecode == "0")){


            $transaction_id = $txRef;
            $payment_logs->payment_status = 'complete';
            $payment_logs->transaction_id = $transaction_id;
            $payment_logs->save();

            //send success mail to user and admin
            self::send_order_mail($payment_logs->id);

            return redirect()->route('frontend.gig.order.payment.success',$payment_logs->id);

        }else{
            return redirect()->route('frontend.gig.order.payment.cancel',$payment_logs->id);
        }

    }
    public function paytm_ipn(Request $request){
        $payment_track = $request['ORDERID'];
        $payment_logs = GigOrder::where( 'payment_track', $payment_track )->first();

        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {
            $transaction_id = $request['TXNID'];
            $payment_logs->payment_status = 'complete';
            $payment_logs->transaction_id = $transaction_id;
            $payment_logs->save();

            //send success mail to user and admin
            self::send_order_mail($payment_logs->id);
            return redirect()->route('frontend.gig.order.payment.success',$payment_logs->id);

        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
            return redirect()->route('frontend.gig.order.payment.cancel',$payment_logs->id);
        }
    }

    public function mollie_webhook(){
        $payment_id = session()->get('mollie_payment_id');
        $payment = Mollie::api()->payments->get($payment_id);
        session()->forget('mollie_payment_id');

        $order_details = GigOrder::find($payment->metadata->order_id);
        if ($payment->isPaid()){
            $order_details->payment_status = 'complete';
            $order_details->transaction_id = $payment->id;
            $order_details->save();

            //send mail to user
            self::send_order_mail($order_details->id);
            return redirect()->route('frontend.gig.order.payment.success',$payment->metadata->order_id);
        }

        return redirect()->route('frontend.gig.order.payment.cancel',$payment->metadata->order_id);
    }

    public function razorpay_ipn(Request $request){

        $order_details = GigOrder::find($request->order_id);

        //get API Configuration
        $api = new Api(get_static_option('razorpay_key'), get_static_option('razorpay_secret'));
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if(!empty($request->razorpay_payment_id)) {
            try {
                $response = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount'=> $payment['amount']));
            } catch (\Exception $e) {
                return redirect()->route('frontend.gig.order.payment.cancel',$request->order_id);
            }
            // Do something here for store payment details in database...
            $order_details->payment_status = 'complete';
            $order_details->transaction_id = $payment->id;
            $order_details->save();
            //send mail to user
            self::send_order_mail($order_details->id);
        }

        return redirect()->route('frontend.gig.order.payment.success',$request->order_id);

    }

    public function stripe_ipn(Request $request)
    {
        // stripe customer payment token
        $stripe_token = $request->stripe_token;
        $order_details = GigOrder::find($request->order_id);
        Stripe::setApiKey( get_static_option('stripe_secret_key') );

        if (!empty($stripe_token)){
            // charge customer with your amount
            $result = Charge::create(array(
                "currency" => get_static_option('site_global_currency'),
                "amount"   => $order_details->selected_plan_price * 100, // amount in cents,
                'source' => $stripe_token,
                'description' => 'Payment From '. get_static_option('site_'.get_default_language().'_title').'. Gig Order ID '.$order_details->id .', Payer Name: '.$order_details->full_name.', Payer Email: '.$order_details->email,
            ));
        }

        if ($result->status == 'succeeded'){
            $order_details->transaction_id = $result->balance_transaction;
            $order_details->payment_status = 'complete';
            $order_details->save();
            //send mail to user

            self::send_order_mail($order_details->id);
            return redirect()->route('frontend.gig.order.payment.success',$request->order_id);
        }
        return redirect()->route('frontend.gig.order.payment.cancel',$request->order_id);

    }
    public function send_order_mail($order_id){
        $gig_details = GigOrder::find($order_id);
        $default_lang = get_default_language();
        $admin_email = !empty(get_static_option('gig_page_notify_email')) ? get_static_option('gig_page_notify_email') : get_static_option('site_global_email');
        Mail::to($gig_details->email)->send(new \App\Mail\GigOrder($gig_details,'customer',__('Your order has been placed in ').get_static_option('site_'.$default_lang.'_title')));
        Mail::to($admin_email)->send(new \App\Mail\GigOrder($gig_details,'owner',__('Your have a new gig order in ').get_static_option('site_'.$default_lang.'_title')));
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
        $paramList["CALLBACK_URL"] = route('frontend.gig.paytm.ipn');
        $paytm_merchant_key = get_static_option('paytm_merchant_key');

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );

        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }
}
