<?php

namespace App\Http\Controllers;

use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\EventPaymentLogs;
use App\Events;
use App\GigOrder;
use App\Http\Traits\PaytmTrait;
use App\Mail\DonationMessage;
use App\Mail\PaymentSuccess;
use App\Mail\PlaceOrder;
use App\Order;
use App\PaymentLogs;
use App\PricePlan;
use App\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use KingFlamez\Rave\Facades\Rave;
use Mollie\Laravel\Facades\Mollie;
use Razorpay\Api\Api;
use Stripe\Charge;
use Stripe\Stripe;
use Unicodeveloper\Paystack\Facades\Paystack;
use function App\Http\Traits\getChecksumFromArray;

class PaymentLogController extends Controller
{
use PaytmTrait;
    public function order_payment_form(Request $request){

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'order_id' => 'required|string',
            'payment_gateway' => 'required|string',
        ]);
        $order_details = Order::find($request->order_id);
        $payment_log_id = PaymentLogs::create([
            'email' =>  $request->email,
            'name' =>  $request->name,
            'package_name' =>  $order_details->package_name,
            'package_price' =>  $order_details->package_price,
            'package_gateway' =>  $request->payment_gateway,
            'order_id' =>  $request->order_id,
            'status' =>  'pending',
            'track' =>  Str::random(10). Str::random(10),
        ])->id;
        $payment_details = PaymentLogs::find($payment_log_id);

        if ($request->payment_gateway == 'paypal'){

            $payable_amount = $payment_details->package_price;
            $currency_code = get_static_option('site_global_currency');
            if (!is_paypal_supported_currency()){
                $payable_amount = get_amount_in_usd($order_details->package_price,get_static_option('site_global_currency'));
                if ($payable_amount < 1){
                    return $payable_amount.__('USD amount is not supported by paypal');
                }
                $currency_code = 'USD';
            }

            $paypal_details['business'] = get_static_option('paypal_business_email');
            $paypal_details['cbt'] = get_static_option('site_'.get_default_language().'_title');
            $paypal_details['item_name'] = 'Payment For Order Id: #'.$request->order_id.' Package Name: '.$payment_details->package_name.' Payer Name: '.$request->name.' Payer Email:'.$request->email;
            $paypal_details['custom'] = $payment_details->track;
            $paypal_details['currency_code'] = $currency_code;
            $paypal_details['amount'] = $payable_amount;
            $paypal_details['return'] = route('frontend.order.payment.success',$request->order_id);
            $paypal_details['cancel_return'] = route('frontend.order.payment.cancel',$request->order_id);
            $paypal_details['notify_url'] = route('frontend.paypal.ipn');

            return view('frontend.payment.paypal')->with(['paypal_details' => $paypal_details]);
        }
        elseif ($request->payment_gateway == 'paytm'){

            $amount = $payment_details->package_price;
            if (!is_paytm_supported_currency() ){
                $amount = get_amount_in_inr($payment_details->package_price,get_static_option('site_global_currency'));
            }
            $data_for_request = $this->handlePaytmRequest( $payment_details->track, $amount );

            $paytm_txn_url = PAYTM_TXN_URL;
            $paramList = $data_for_request['paramList'];
            $checkSum = $data_for_request['checkSum'];

            return view('frontend.payment.paytm')->with([
                'paytm_txn_url' => $paytm_txn_url,
                'paramList' => $paramList,
                'checkSum' => $checkSum,
            ]);
        }
        elseif ($request->payment_gateway == 'mollie'){

            $payable_amount = $payment_details->package_price;
            $currency_code = get_static_option('site_global_currency');

            if (!is_mollie_supported_currency() ){
                $payable_amount = get_amount_in_usd($payment_details->package_price,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }

            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => $currency_code,
                    "value" => number_format((float)$payable_amount, 2, '.', ''),//"10.00" // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                "description" => 'Payment For Order Id: #'.$request->order_id.' Package Name: '.$payment_details->package_name.' Payer Name: '.$request->name.' Payer Email:'.$request->email,
                "redirectUrl" => route('frontend.mollie.webhook'),
                "metadata" => [
                    "order_id" => $request->order_id,
                    "track" => $payment_details->track,
                ],
            ]);

            $payment = Mollie::api()->payments->get($payment->id);

            session()->put('mollie_payment_id',$payment->id);

            // redirect customer to Mollie checkout page
            return redirect($payment->getCheckoutUrl(), 303);

        }
        elseif ($request->payment_gateway == 'stripe'){

            $order = Order::where( 'id', $request->order_id )->first();
            $payable_amount = $order->package_price;

            $stripe_data['title'] = __('Payment of order:').' '.$order->package_name;
            $stripe_data['order_id'] = $order->id;
            $stripe_data['price'] = number_format((float)$payable_amount, 2, '.', '');
            $stripe_data['route'] = route('frontend.stripe.ipn');

            return view('frontend.payment.stripe')->with('stripe_data' ,$stripe_data);
        }
        elseif ($request->payment_gateway == 'razorpay'){

            $order = Order::where( 'id', $request->order_id )->first();

            $payable_amount = $payment_details->package_price;
            $currency_code = get_static_option('site_global_currency');

            if (!is_razorpay_supported_currency()){
                $payable_amount = get_amount_in_inr($payment_details->package_price,get_static_option('site_global_currency'));
                $currency_code = 'INR';
            }

            $razorpay_data['currency_symbol'] = $currency_code;
            $razorpay_data['currency'] = $currency_code;
            $razorpay_data['price'] = number_format((float)$payable_amount, 2, '.', '');
            $razorpay_data['package_name'] = $order->package_name;
            $razorpay_data['route'] = route('frontend.razorpay.ipn');
            $razorpay_data['order_id'] = $order->id;

            return view('frontend.payment.razorpay')->with('razorpay_data' ,$razorpay_data);
        }
        elseif ($request->payment_gateway == 'flutterwave'){

            $order = Order::where( 'id', $request->order_id )->first();
            $package_details = PaymentLogs::where('order_id',$order->id)->first();


            $payable_amount = $payment_details->package_price;
            $currency_code = get_static_option('site_global_currency');

            if (!is_flutterwave_supported_currency()){
                $payable_amount = get_amount_in_usd($payment_details->package_price,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }

            $flutterwave_data['currency'] = $currency_code;
            $flutterwave_data['name'] = $request->name;
            $flutterwave_data['form_action'] = route('frontend.flutterwave.pay');
            $flutterwave_data['amount'] = number_format((float)$payable_amount, 2, '.', '');
            $flutterwave_data['description'] = 'Payment For Order Id: #'.$request->order_id.' Package Name: '.$payment_details->package_name.' Payer Name: '.$request->name.' Payer Email:'.$request->email;
            $flutterwave_data['email'] = $package_details->email;
            $flutterwave_data['country'] = get_visitor_country() ? get_visitor_country() : 'NG';
            $flutterwave_data['metadata'] = [
                ['metaname' => 'order_id', 'metavalue' => $order->id],
                ['metaname' => 'track', 'metavalue' => $package_details->track],
            ];
            return view('frontend.payment.flutterwave')->with('flutterwave_data' ,$flutterwave_data);
        }
        elseif ($request->payment_gateway == 'paystack'){

            $order = Order::where( 'id', $request->order_id )->first();
            $package_details = PaymentLogs::where('order_id',$order->id)->first();

            $payable_amount = $payment_details->package_price;
            $currency_code = get_static_option('site_global_currency');

            if (!is_paystack_supported_currency()){
                $payable_amount = get_amount_in_ngn($payment_details->package_price,get_static_option('site_global_currency'));
                $currency_code = 'NGN';
            }

            $paystack_data['currency'] = $currency_code;
            $paystack_data['price'] = $payable_amount;
            $paystack_data['package_name'] =  $order->package_name;
            $paystack_data['name'] = $package_details->name;
            $paystack_data['email'] = $package_details->email;
            $paystack_data['order_id'] = $order->id;
            $paystack_data['track'] = $package_details->track;
            $paystack_data['route'] = route('frontend.paystack.pay');
            $paystack_data['type'] = 'order';

            return view('frontend.payment.paystack')->with(['paystack_data' => $paystack_data]);

        }
        elseif ($request->payment_gateway == 'manual_payment'){
            $order = Order::where( 'id', $request->order_id )->first();
            $order->status = 'pending';
            $order->save();
            PaymentLogs::where('order_id',$request->order_id)->update(['transaction_id' => $request->trasaction_id]);
            return redirect()->route('frontend.order.payment.success',$request->order_id);
        }elseif ($request->payment_gateway == 'midtrans'){
            $payable_amount = $payment_details->package_price;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000;
            }
            $title = 'Payment For Order: '.$payment_details->package_name;
            $redirect_url = MidtransController::getRedirectUrl(
                'order', 
                $payment_details->track, 
                $payable_amount, 
                $request->name, 
                $request->email, 
                null, 
                $title
            );
            if ($redirect_url) {
                return redirect($redirect_url);
            }
            return redirect()->back()->with(['msg' => __('Midtrans Error. Please contact support.'), 'type' => 'danger']);
        }elseif ($request->payment_gateway == 'xendit'){
            $payable_amount = $payment_details->package_price;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000;
            }
            $title = 'Payment For Order: '.$payment_details->package_name;
            $redirect_url = XenditController::getRedirectUrl(
                'service',
                $payment_details->track,
                $payable_amount,
                $request->name,
                $request->email,
                $title
            );
            if ($redirect_url) {
                return redirect($redirect_url);
            }
            return redirect()->back()->with(['msg' => __('Xendit Error. Please contact support.'), 'type' => 'danger']);
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
            $payment_logs = PaymentLogs::where('track', $track)->first();
            $paypal_business_email = get_static_option('paypal_business_email');

            if ($receiver_email == $paypal_business_email && $payment_logs->status == 'pending') {
                //send success mail to user and admin
                $payment_logs = PaymentLogs::where('track', $track)->first();
                PaymentLogs::where('track',$track)->update([
                    'transaction_id' =>$_POST['txn_id'],
                    'status' => 'complete'
                ]);

                self::send_order_mail($payment_logs->order_id);

                Order::find( $payment_logs->order_id)->update(['payment_status' => 'complete']);

                Mail::to($payment_logs->email)->send(new PaymentSuccess($payment_logs));
            }
        }
    }

    public function razorpay_ipn(Request $request){

        $order_details = Order::find($request->order_id);
        $payment_log_details = PaymentLogs::where('order_id',$request->order_id)->first();

        //get API Configuration
        $api = new Api(get_static_option('razorpay_key'), get_static_option('razorpay_secret'));
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if(!empty($request->razorpay_payment_id)) {
            try {
                $response = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount'=> $payment['amount']));
            } catch (\Exception $e) {
                return redirect()->route('frontend.order.payment.cancel',$request->order_id);
            }
            // Do something here for store payment details in database...
            $order_details->payment_status = 'complete';
            $order_details->save();
            
            PaymentLogs::where('order_id',$request->order_id)->update([
                'transaction_id' => $payment->id,
                'status' => 'complete'
            ]);
            //send mail to user
            self::send_order_mail($order_details->id);
            Mail::to($payment_log_details->email)->send(New PaymentSuccess($payment_log_details));
        }

        return redirect()->route('frontend.order.payment.success',$request->order_id);

    }

    public function paytm_ipn(Request $request){
        $payment_track = $request['ORDERID'];
        $payment_logs = PaymentLogs::where( 'track', $payment_track )->first();
        $order_id = $payment_logs->order_id;

        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {
            Order::where('id',$order_id)->update(['payment_status' => 'complete']);

            $transaction_id = $request['TXNID'];
             PaymentLogs::where('track',$payment_track)->update([
                'transaction_id' => $transaction_id,
                'status' => 'complete'
            ]);
            //send success mail to user and admin
            self::send_order_mail($payment_logs->order_id);
            Mail::to($payment_logs->email)->send(new PaymentSuccess($payment_logs));

            return redirect()->route('frontend.order.payment.success',$order_id);

        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
            return redirect()->route('frontend.order.payment.cancel',$order_id);
        }
    }

    public function mollie_webhook(){
        $payment_id = session()->get('mollie_payment_id');
        $payment = Mollie::api()->payments->get($payment_id);
        session()->forget('mollie_payment_id');

        
        $payment_log_details = PaymentLogs::where('track',$payment->metadata->track)->first();
        $order_details = Order::find($payment_log_details->order_id);

        if ($payment->isPaid()){
            $order_details->payment_status = 'complete';
            $order_details->save();
            PaymentLogs::where('track',$payment->metadata->track)->update([
                'transaction_id' => $payment_log_details->transaction_id,
                'status' => 'complete'
            ]);

            //send mail to user
            self::send_order_mail($order_details->id);
            Mail::to($payment_log_details->email)->send(New PaymentSuccess($payment_log_details));
            return redirect()->route('frontend.order.payment.success',$payment->metadata->order_id);
        }

        return redirect()->route('frontend.order.payment.cancel',$payment->metadata->order_id);
    }

    public function stripe_ipn(Request $request)
    {
        // stripe customer payment token
        $stripe_token = $request->stripe_token;
        $order_details = Order::find($request->order_id);
        $payment_log_details = PaymentLogs::where('order_id',$request->order_id)->first();
        Stripe::setApiKey( get_static_option('stripe_secret_key') );

        if (!empty($stripe_token)){
            // charge customer with your amount
            $result = Charge::create(array(
                "currency" => get_static_option('site_global_currency'),
                "amount"   => $order_details->package_price * 100, // amount in cents,
                'source' => $stripe_token,
                'description' => 'Payment From '. get_static_option('site_'.get_default_language().'_title').'. Order ID '.$order_details->id .', Payer Name: '.$payment_log_details->name.', Payer Email: '.$payment_log_details->email,
            ));
        }

        if ($result->status == 'succeeded'){
            $order_details->payment_status = 'complete';
            $order_details->save();
            
            PaymentLogs::where('order_id',$request->order_id)->update([
                'transaction_id' => $result->balance_transaction,
                'status' => 'complete'
            ]);
            //send mail to user
            Mail::to($payment_log_details->email)->send(New PaymentSuccess($payment_log_details));
            self::send_order_mail($order_details->id);
            return redirect()->route('frontend.order.payment.success',$request->order_id);
        }
        return redirect()->route('frontend.order.payment.cancel',$request->order_id);

    }

    public function flutterwave_pay(Request $request){
        Rave::initialize(route('frontend.flutterwave.callback'));
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

        $payment_logs = PaymentLogs::where( 'track', $track )->first();
        if (($chargeResponsecode == "00" || $chargeResponsecode == "0")){


            $transaction_id = $txRef;
            
             PaymentLogs::where('track',$track)->update([
                'transaction_id' => $transaction_id,
                'status' => 'complete'
            ]);

            Order::where('id',$payment_logs->order_id)->update(['payment_status' => 'complete']);
            //send success mail to user and admin
            self::send_order_mail($payment_logs->order_id);
            Mail::to($payment_logs->email)->send(new PaymentSuccess($payment_logs));

            return redirect()->route('frontend.order.payment.success',$payment_logs->order_id);

        }else{
            return redirect()->route('frontend.order.payment.cancel',$payment_logs->order_id);
        }

    }

    public function paystack_pay(){
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function paystack_callback(Request $request){
        $paymentDetails = Paystack::getPaymentData();

        if ($paymentDetails['status']){
            $meta_data = $paymentDetails['data']['metadata'];
            
            if (empty($meta_data['track'])){return redirect(route('homepage'));}
            
            if ($meta_data['type'] == 'order'){
                $payment_log_details = PaymentLogs::where('track',$meta_data['track'])->first();
                $order_details = Order::find($payment_log_details->order_id);
                // Do something here for store payment details in database...
                $order_details->payment_status = 'complete';
                $order_details->save();
                
                PaymentLogs::where('track',$meta_data['track'])->update([
                    'transaction_id' => $paymentDetails['data']['reference'],
                    'status' => 'complete'
                ]);
            
                //send mail to user
                self::send_order_mail($order_details->id);
                Mail::to($payment_log_details->email)->send(New PaymentSuccess($payment_log_details));
                return redirect()->route('frontend.order.payment.success',$payment_log_details->order_id);

            }elseif ($meta_data['type'] == 'event'){
                $payment_log_details = EventPaymentLogs::where('track',$meta_data['track'])->first();
                $order_details = EventAttendance::find($payment_log_details->attendance_id);
                //update event attendance status
                $order_details->payment_status = 'complete';
                $order_details->status = 'complete';
                $order_details->save();
                //update event payment log
                $payment_log_details->transaction_id = $paymentDetails['data']['reference'];
                $payment_log_details->status = 'complete';
                $payment_log_details->save();

                //update event available tickets
                $event_details = Events::find($order_details->event_id);
                $event_details->available_tickets = intval($event_details->available_tickets) - $order_details->quantity;
                $event_details->save();

                //send mail to user
                Mail::to($payment_log_details->email)->send(New PaymentSuccess($payment_log_details,'event'));
                return redirect()->route('frontend.event.payment.success',$payment_log_details->attendance_id);

            }elseif ($meta_data['type'] == 'donation'){

                $payment_log_details = DonationLogs::where('track',$meta_data['track'])->first();
                //update event attendance status

                $payment_log_details->transaction_id = $paymentDetails['data']['reference'];
                $payment_log_details->status = 'complete';
                $payment_log_details->save();

                //update donation raised amount
                $event_details = Donation::find($payment_log_details->donation_id);
                $event_details->raised = intval($event_details->raised) + intval($payment_log_details->amount);
                $event_details->save();

                $donation_details = DonationLogs::find($payment_log_details->id);
                Mail::to(get_static_option('site_global_email'))->send(new DonationMessage($donation_details,__('You have a new donation payment from '.get_static_option('site_'.get_default_language().'_title')),'owner'));
                Mail::to(get_static_option('donation_notify_mail'))->send(new DonationMessage($donation_details,__('You donation payment success for '.get_static_option('site_'.get_default_language().'_title')),'customer'));

                return redirect()->route('frontend.donation.payment.success',$payment_log_details->id);

            }elseif ($meta_data['type'] == 'product'){

                $product_order_details = ProductOrder::where('payment_track',$meta_data['track'])->first();
                $product_order_details->transaction_id = $paymentDetails['data']['reference'];
                $product_order_details->payment_status = 'complete';
                $product_order_details->save();
                rest_cart_session();

                Mail::to(get_static_option('site_global_email'))->send(new \App\Mail\ProductOrder($product_order_details,'owner',__('You Have A New Product Order From ').get_static_option('site_'.get_default_language().'_title')));
                Mail::to($product_order_details->billing_email)->send(new \App\Mail\ProductOrder($product_order_details,'customer',__('You order has been placed in ').get_static_option('site_'.get_default_language().'_title')));

                return redirect()->route('frontend.product.payment.success',$product_order_details->id);

            }elseif ($meta_data['type'] == 'gig'){

                $product_order_details = GigOrder::where('payment_track',$meta_data['track'])->first();
                $product_order_details->transaction_id = $paymentDetails['data']['reference'];
                $product_order_details->payment_status = 'complete';
                $product_order_details->save();

                $default_lang = get_default_language();
                Mail::to($product_order_details->email)->send(new \App\Mail\GigOrder($product_order_details,'customer',__('Your order has been placed in ').get_static_option('site_'.$default_lang.'_title')));
                Mail::to(get_static_option('site_global_email'))->send(new \App\Mail\GigOrder($product_order_details,'owner',__('Your have a new gig order in ').get_static_option('site_'.$default_lang.'_title')));

                return redirect()->route('frontend.gig.order.payment.success',$product_order_details->id);
            }
            else{
                return redirect()->route('homepage');
            }
        }else{
            return redirect()->route('homepage');
        }
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
        $paramList["CALLBACK_URL"] = route('frontend.paytm.ipn');
        $paytm_merchant_key = get_static_option('paytm_merchant_key');

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );

        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }

    public function send_order_mail($order_id){

        $order_details = Order::find($order_id);
        $package_details = PricePlan::where('id',$order_details->package_id)->first();
        $all_fields = unserialize($order_details->custom_fields);
        unset($all_fields['package']);

        $all_attachment = unserialize($order_details->attachment);
        $order_mail = get_static_option('order_page_form_mail') ? get_static_option('order_page_form_mail') : get_static_option('site_global_email');

        Mail::to($order_mail)->send(new PlaceOrder($all_fields, $all_attachment, $package_details));
    }

}
