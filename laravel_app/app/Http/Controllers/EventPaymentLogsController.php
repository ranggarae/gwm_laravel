<?php

namespace App\Http\Controllers;

use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\EventPaymentLogs;
use App\Events;
use App\Http\Traits\PaytmTrait;
use App\Mail\ContactMessage;
use App\Mail\PaymentSuccess;
use App\Order;
use App\PaymentLogs;
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

class EventPaymentLogsController extends Controller
{
    use PaytmTrait;
    public function booking_payment_form(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'attendance_id' => 'required|string',
            'payment_gateway' => 'required|string',
        ],
        [
            'name.required' => __('Name field is required'),
            'email.required' => __('Email field is required')
        ]);
        $event_details = EventAttendance::find($request->attendance_id);
        $event_payment_details = EventPaymentLogs::where('attendance_id',$request->attendance_id)->first();
        if (empty($event_payment_details)){
            $payment_log_id = EventPaymentLogs::create([
                'email' =>  $request->email,
                'name' =>  $request->name,
                'event_name' =>  $event_details->event_name,
                'event_cost' =>  ($event_details->event_cost * $event_details->quantity),
                'package_gateway' =>  $request->payment_gateway,
                'attendance_id' =>  $request->attendance_id,
                'status' =>  'pending',
                'track' =>  Str::random(10). Str::random(10),
            ])->id;
            $event_payment_details = EventPaymentLogs::find($payment_log_id);
        }

        //have to work on below code
        if ($request->payment_gateway == 'paypal'){

            $payable_amount = $event_details->event_cost * $event_details->quantity;
            $currency_code = get_static_option('site_global_currency');
            if (!is_paypal_supported_currency()){
                $payable_amount = get_amount_in_usd($event_details->event_cost * $event_details->quantity,get_static_option('site_global_currency'));
                if ($payable_amount < 1){
                    return $payable_amount.__('USD amount is not supported by paypal');
                }
                $currency_code = 'USD';
            }
            $paypal_details['business'] = get_static_option('paypal_business_email');
            $paypal_details['currency_code'] = $currency_code;
            $paypal_details['cbt'] = get_static_option('site_'.get_default_language().'_title');
            $paypal_details['item_name'] = "Event Payment Details Attendance Id: #'.$request->attendance_id '".' Name: '.$event_payment_details->name.' Email: '.$event_payment_details->email;
            $paypal_details['custom'] = $event_payment_details->track;
            $paypal_details['amount'] = $payable_amount;
            $paypal_details['return'] = route('frontend.event.payment.success',$event_payment_details->attendance_id);
            $paypal_details['cancel_return'] = route('frontend.event.payment.cancel',$event_payment_details->attendance_id);
            $paypal_details['notify_url'] = route('frontend.event.paypal.ipn');

            return view('frontend.payment.paypal')->with(['paypal_details' => $paypal_details]);

        }elseif ($request->payment_gateway == 'paytm'){

            $amount = $event_details->event_cost * $event_details->quantity;
            if (!is_paytm_supported_currency() ){
                $amount = get_amount_in_inr($event_details->event_cost * $event_details->quantity,get_static_option('site_global_currency'));
            }

            $data_for_request = $this->handlePaytmRequest( $event_payment_details->track, $amount );

            $paytm_txn_url = PAYTM_TXN_URL;
            $paramList = $data_for_request['paramList'];
            $checkSum = $data_for_request['checkSum'];

            return view('frontend.payment.paytm')->with([
                'paytm_txn_url' => $paytm_txn_url,
                'paramList' => $paramList,
                'checkSum' => $checkSum,
            ]);
        }elseif ($request->payment_gateway == 'manual_payment'){
            $order = EventAttendance::where( 'id', $request->attendance_id )->first();
            $order->status = 'pending';
            $order->save();
            EventPaymentLogs::where('attendance_id',$request->attendance_id)->update(['transaction_id' => $request->transaction_id]);
            self::send_event_mail($request->attendance_id);
            return redirect()->route('frontend.event.payment.success',$event_payment_details->attendance_id);

        }elseif ($request->payment_gateway == 'stripe'){

            $order = EventAttendance::where( 'id', $request->attendance_id )->first();

            $payable_amount = $order->event_cost;

            $stripe_data['title'] = __('Payment of event:').' '.$order->event_name;
            $stripe_data['order_id'] = $order->id;
            $stripe_data['price'] = ($payable_amount * $order->quantity);
            $stripe_data['route'] = route('frontend.event.stripe.ipn');

            return view('frontend.payment.stripe')->with('stripe_data' ,$stripe_data);
        }
        elseif ($request->payment_gateway == 'razorpay'){
            
            $attendance_details = EventAttendance::where( 'id', $request->attendance_id )->first();
            $payable_amount =  $attendance_details->event_cost * $attendance_details->quantity;

            $currency_code = get_static_option('site_global_currency');
            if (!is_razorpay_supported_currency()){
                $payable_amount = get_amount_in_inr($attendance_details->event_cost * $attendance_details->quantity,get_static_option('site_global_currency'));
                $currency_code = 'INR';
            }

            $razorpay_data['currency_symbol'] = $currency_code;
            $razorpay_data['currency'] = $currency_code;
            $razorpay_data['price'] = number_format((float)$payable_amount, 2, '.', '');
            $razorpay_data['package_name'] = $attendance_details->event_name;
            $razorpay_data['order_id'] = $attendance_details->id;
            $razorpay_data['route'] = route('frontend.event.razorpay.ipn');
            return view('frontend.payment.razorpay')->with('razorpay_data' ,$razorpay_data);
        }
        elseif ($request->payment_gateway == 'paystack'){
            $attendance_details = EventAttendance::where( 'id', $request->attendance_id )->first();
            $event_payment_details = EventPaymentLogs::where('attendance_id',$attendance_details->id)->first();


            $payable_amount =$attendance_details->event_cost * $attendance_details->quantity;
            $currency_code = get_static_option('site_global_currency');

            if (!is_paystack_supported_currency()){
                $payable_amount = get_amount_in_ngn($attendance_details->event_cost * $attendance_details->quantity,get_static_option('site_global_currency'));
                $currency_code = 'NGN';
            }

            $paystack_data['currency'] = $currency_code;
            $paystack_data['price'] = $payable_amount;
            $paystack_data['package_name'] =  $attendance_details->event_name;
            $paystack_data['name'] = $event_payment_details->name;
            $paystack_data['email'] = $event_payment_details->email;
            $paystack_data['order_id'] = $attendance_details->id;
            $paystack_data['track'] = $event_payment_details->track;
            $paystack_data['route'] = route('frontend.event.paystack.pay');
            $paystack_data['type'] = 'event';
            return view('frontend.payment.paystack')->with(['paystack_data' => $paystack_data]);
        }
        elseif ($request->payment_gateway == 'mollie'){

            $attendance_details = EventAttendance::where( 'id', $request->attendance_id )->first();
            $event_payment_details = EventPaymentLogs::where('attendance_id',$attendance_details->id)->first();

            $payable_amount = $attendance_details->event_cost * $attendance_details->quantity;
            $currency_code = get_static_option('site_global_currency');

            if (!is_mollie_supported_currency() ){
                $payable_amount = get_amount_in_usd($attendance_details->event_cost * $attendance_details->quantity,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }


            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => $currency_code,
                    "value" => number_format((float)$payable_amount, 2, '.', ''),//"10.00" // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                "description" => "Event Payment Details Attendance Id: #'.$request->attendance_id '".' Name: '.$event_payment_details->name.' Email: '.$event_payment_details->email,
                "redirectUrl" => route('frontend.event.mollie.webhook'),
                "metadata" => [
                    "order_id" => $attendance_details->id,
                    "track" => $event_payment_details->track,
                ],
            ]);

            $payment = Mollie::api()->payments->get($payment->id);

            session()->put('mollie_payment_id',$payment->id);

            // redirect customer to Mollie checkout page
            return redirect($payment->getCheckoutUrl(), 303);
        }elseif ($request->payment_gateway == 'flutterwave'){

            $attendance_details = EventAttendance::where( 'id', $request->attendance_id )->first();
            $event_payment_details = EventPaymentLogs::where('attendance_id',$attendance_details->id)->first();

            $payable_amount = $attendance_details->event_cost * $attendance_details->quantity;
            $currency_code = get_static_option('site_global_currency');

            if (!is_flutterwave_supported_currency()){
                $payable_amount = get_amount_in_usd($attendance_details->event_cost * $attendance_details->quantity,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }

            $flutterwave_data['form_action'] = route('frontend.event.flutterwave.pay');
            $flutterwave_data['currency'] = $currency_code;
            $flutterwave_data['amount'] = $payable_amount;
            $flutterwave_data['description'] = "Event Payment Details ID #".$attendance_details->id .' Name: '.$event_payment_details->name;
            $flutterwave_data['email'] = $event_payment_details->email;
            $flutterwave_data['name'] = $event_payment_details->name;
            $flutterwave_data['country'] = get_visitor_country() ? get_visitor_country() : 'NG';
            $flutterwave_data['metadata'] = [
                ['metaname' => 'order_id', 'metavalue' => $attendance_details->id],
                ['metaname' => 'track', 'metavalue' => $event_payment_details->track],
            ];
            return view('frontend.payment.flutterwave')->with('flutterwave_data' ,$flutterwave_data);
        }elseif ($request->payment_gateway == 'midtrans'){
            $attendance_details = EventAttendance::where( 'id', $request->attendance_id )->first();
            $event_payment_details = EventPaymentLogs::where('attendance_id',$attendance_details->id)->first();
            $payable_amount = $attendance_details->event_cost * $attendance_details->quantity;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000;
            }
            $title = 'Event Payment: '.$attendance_details->event_name;
            $redirect_url = MidtransController::getRedirectUrl(
                'event', 
                $event_payment_details->track, 
                $payable_amount, 
                $event_payment_details->name, 
                $event_payment_details->email, 
                null, 
                $title
            );
            if ($redirect_url) {
                return redirect($redirect_url);
            }
            return redirect()->back()->with(['msg' => __('Midtrans Error. Please contact support.'), 'type' => 'danger']);
        }elseif ($request->payment_gateway == 'tripay'){
            $attendance_details = EventAttendance::where( 'id', $request->attendance_id )->first();
            $event_payment_details = EventPaymentLogs::where('attendance_id',$attendance_details->id)->first();
            $payable_amount = $attendance_details->event_cost * $attendance_details->quantity;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000;
            }
            $title = 'Event Payment: '.$attendance_details->event_name;
            return TripayController::getRedirectUrl(
                'event',
                $event_payment_details->track,
                $payable_amount,
                $attendance_details->name,
                $attendance_details->email,
                $attendance_details->phone,
                $title
            );
        }elseif ($request->payment_gateway == 'xendit'){
            $attendance_details = EventAttendance::where( 'id', $request->attendance_id )->first();
            $event_payment_details = EventPaymentLogs::where('attendance_id',$attendance_details->id)->first();
            $payable_amount = $attendance_details->event_cost * $attendance_details->quantity;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000;
            }
            $title = 'Event Payment: '.$attendance_details->event_name;
            $redirect_url = XenditController::getRedirectUrl(
                'event',
                $event_payment_details->track,
                $payable_amount,
                $event_payment_details->name,
                $event_payment_details->email,
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
        Rave::initialize(route('frontend.event.flutterwave.callback'));
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

        $payment_logs = EventPaymentLogs::where( 'track', $track )->first();
        if (($chargeResponsecode == "00" || $chargeResponsecode == "0")){
            //update event payment log
            $transaction_id = $txRef;

            $payment_logs->status = 'complete';
            $payment_logs->transaction_id = $transaction_id;
            $payment_logs->save();

            //update event attendance
            $event_attendance =  EventAttendance::find( $payment_logs->attendance_id);
            $event_attendance->payment_status ='complete';
            $event_attendance->status ='complete';
            $event_attendance->save();

            //update event available tickets
            $event_details = Events::find($event_attendance->event_id);
            $event_details->available_tickets = intval($event_details->available_tickets) - $event_attendance->quantity;
            $event_details->save();

            //send success mail to user and admin
            self::send_event_mail($payment_logs->attendance_id);
            Mail::to($payment_logs->email)->send(new PaymentSuccess($payment_logs,'event'));

            return redirect()->route('frontend.event.payment.success',$payment_logs->attendance_id);
        }else{
            return redirect()->route('frontend.event.payment.cancel',$payment_logs->attendance_id);
        }

    }

    public function mollie_webhook(){
        $payment_id = session()->get('mollie_payment_id');
        $payment = Mollie::api()->payments->get($payment_id);
        session()->forget('mollie_payment_id');

          $payment_logs = EventPaymentLogs::where( 'track', $payment->metadata->track )->first();

         if ($payment->isPaid()){
             //update event payment logs
            $transaction_id = $payment->id;

            $payment_logs->status = 'complete';
            $payment_logs->transaction_id = $transaction_id;
            $payment_logs->save();

            //update event attendance
            $event_attendance =  EventAttendance::find( $payment_logs->attendance_id);
            $event_attendance->payment_status ='complete';
            $event_attendance->status ='complete';
            $event_attendance->save();

            //update event available tickets
            $event_details = Events::find($event_attendance->event_id);
            $event_details->available_tickets = intval($event_details->available_tickets) - $event_attendance->quantity;
            $event_details->save();

            //send success mail to user and admin
             self::send_event_mail($payment_logs->attendance_id);
            Mail::to($payment_logs->email)->send(new PaymentSuccess($payment_logs,'event'));

            return redirect()->route('frontend.event.payment.success',$payment_logs->attendance_id);

        }
        return redirect()->route('frontend.event.payment.cancel',$payment_logs->attendance_id);
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
            $payment_logs = EventPaymentLogs::where('track', $track)->first();
            $paypal_business_email = get_static_option('paypal_business_email');

            if ($receiver_email == $paypal_business_email && $payment_logs->status == 'pending') {

                //update event payment log
                $payment_logs = EventPaymentLogs::where('track', $track)->first();
                $payment_logs->status = 'complete';
                $payment_logs->transaction_id = $_POST['txn_id'];
                $payment_logs->save();

                //update event attendance
                $event_attendance =  EventAttendance::find( $payment_logs->attendance_id);
                $event_attendance->payment_status ='complete';
                $event_attendance->status ='complete';
                $event_attendance->save();

                //update event available tickets
                $event_details = Events::find($event_attendance->event_id);
                $event_details->available_tickets = intval($event_details->available_tickets) - $event_attendance->quantity;
                $event_details->save();

                self::send_event_mail($payment_logs->attendance_id);
                Mail::to($payment_logs->email)->send(new PaymentSuccess($payment_logs,'event'));
            }
        }
    }

    public function paytm_ipn(Request $request){
        $order_id = $request['ORDERID'];

        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {

            //update event payment logs
            $transaction_id = $request['TXNID'];
            $payment_logs = EventPaymentLogs::where( 'track', $order_id )->first();
            $payment_logs->status = 'complete';
            $payment_logs->transaction_id = $transaction_id;
            $payment_logs->save();

            //update event attendance
            $event_attendance =  EventAttendance::find( $payment_logs->attendance_id);
            $event_attendance->payment_status ='complete';
            $event_attendance->status ='complete';
            $event_attendance->save();

            //update event available tickets
            $event_details = Events::find($event_attendance->event_id);
            $event_details->available_tickets = intval($event_details->available_tickets) - $event_attendance->quantity;
            $event_details->save();

            //send success mail to user and admin
            self::send_event_mail($payment_logs->attendance_id);
            Mail::to($payment_logs->email)->send(new PaymentSuccess($payment_logs,'event'));

            return redirect()->route('frontend.event.payment.success',$payment_logs->attendance_id);

        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
             $payment_logs = EventPaymentLogs::where( 'track', $order_id )->first();
            return redirect()->route('frontend.event.payment.cancel',$payment_logs->attendance_id);
        }
    }

    public function stripe_ipn(Request $request)
    {
        // stripe customer payment token
        $stripe_token = $request->stripe_token;
        $order_details = EventAttendance::find($request->order_id);
        $payment_log_details = EventPaymentLogs::where('attendance_id',$request->order_id)->first();
        Stripe::setApiKey( get_static_option('stripe_secret_key') );

        if (!empty($stripe_token)){
            // charge customer with your amount
            $result = Charge::create(array(
                "currency" => get_static_option('site_global_currency'),
                "amount"   => ($order_details->event_cost * $order_details->quantity) * 100, // amount in cents,
                'source' => $stripe_token,
                'description' => 'Payment From '. get_static_option('site_'.get_default_language().'_title').'. Order ID '.$order_details->id .', Payer Name: '.$payment_log_details->name.', Payer Email: '.$payment_log_details->email,
            ));
        }

        if ($result->status == 'succeeded'){
            //event attendance update
            $order_details->payment_status = 'complete';
            $order_details->status = 'complete';
            $order_details->save();

            $payment_log_details->transaction_id = $result->balance_transaction;
            $payment_log_details->status = 'complete';
            $payment_log_details->save();

            //update event available tickets
            $event_details = Events::find($order_details->event_id);
            $event_details->available_tickets = intval($event_details->available_tickets) - $order_details->quantity;
            $event_details->save();

            //send success mail to user and admin
            self::send_event_mail($payment_log_details->attendance_id);
            Mail::to($payment_log_details->email)->send(new PaymentSuccess($payment_log_details,'event'));

            return redirect()->route('frontend.event.payment.success',$request->order_id);

        }
        return redirect()->route('frontend.event.payment.cancel',$request->order_id);

    }

    public function razorpay_ipn(Request $request){

        $order_details = EventAttendance::find($request->order_id);
        $payment_log_details = EventPaymentLogs::where('attendance_id',$request->order_id)->first();

        //get API Configuration
        $api = new Api(get_static_option('razorpay_key'), get_static_option('razorpay_secret'));
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if(!empty($request->razorpay_payment_id)) {
            try {
                $response = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount'=> $payment['amount']));
            } catch (\Exception $e) {
                return redirect()->route('frontend.event.payment.cancel',$request->order_id);
            }
            // Do something here for store payment details in database...
            //update attendance status
            $order_details->payment_status = 'complete';
            $order_details->status = 'complete';
            $order_details->save();
            //update event payment log
            $payment_log_details->transaction_id = $payment->id;
            $payment_log_details->status = 'complete';
            $payment_log_details->save();

            //update event available tickets
            $event_details = Events::find($order_details->event_id);
            $event_details->available_tickets = intval($event_details->available_tickets) - $order_details->quantity;
            $event_details->save();

            //send success mail to user and admin
            self::send_event_mail($payment_log_details->attendance_id);
            Mail::to($payment_log_details->email)->send(new PaymentSuccess($payment_log_details,'event'));

        }

        return redirect()->route('frontend.event.payment.success',$request->order_id);

    }

    public function paystack_pay(){
        return Paystack::getAuthorizationUrl()->redirectNow();
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
        $paramList["CALLBACK_URL"] = route('frontend.event.paytm.ipn');
        $paytm_merchant_key = get_static_option('paytm_merchant_key');

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );

        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }

    public function send_event_mail($event_attendance_id){
        $event_attendance = EventAttendance::find($event_attendance_id);
        $fileds_name = unserialize($event_attendance->custom_fields);
        $attachment_list = unserialize($event_attendance->attachment);

        $order_mail = get_static_option('event_attendance_receiver_mail') ? get_static_option('event_attendance_receiver_mail') : get_static_option('site_global_email');
        Mail::to($order_mail)->send(new ContactMessage($fileds_name, $attachment_list, 'your have an event booking for '.$event_attendance->event_name));
    }

}
