<?php

namespace App\Http\Controllers;

use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\EventPaymentLogs;
use App\Events;
use App\Http\Traits\PaytmTrait;
use App\Mail\DonationMessage;
use App\Mail\PaymentSuccess;
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

class DonationLogController extends Controller
{
    use PaytmTrait;
    public function store_donation_logs(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'donation_id' => 'required|string',
            'amount' => 'required|string',
            'selected_payment_gateway' => 'required|string',
        ],
        [
            'name.required' => __('Name field is required'),
            'email.required' => __('Email field is required'),
            'amount.required' => __('Amount field is required'),
        ]
        );
        $donation_payment_details = DonationLogs::find($request->order_id);
        if (empty($donation_payment_details)) {
            $donation_payment_details = DonationLogs::create([
                'email' => $request->email,
                'name' => $request->name,
                'donation_id' => $request->donation_id,
                'amount' => $request->amount,
                'donation_type' => $request->donation_type,
                'payment_gateway' => $request->selected_payment_gateway,
                'user_id' => auth()->check() ? auth()->user()->id : '',
                'status' => 'pending',
                'track' => Str::random(10) . Str::random(10),
            ]);
        }


        //have to work on below code
        if ($request->selected_payment_gateway == 'paypal'){

            $payable_amount = $donation_payment_details->amount;
            $currency_code = get_static_option('site_global_currency');
            if (!is_paypal_supported_currency()){
                $payable_amount = get_amount_in_usd($payable_amount,get_static_option('site_global_currency'));
                if ($payable_amount < 1){
                    return $payable_amount.__('USD amount is not supported by paypal');
                }
                $currency_code = 'USD';
            }
            $paypal_details['currency_code'] = $currency_code;
            $paypal_details['business'] = get_static_option('paypal_business_email');
            $paypal_details['cbt'] = get_static_option('site_'.get_default_language().'_title');
            $paypal_details['item_name'] = __('Payment For Donation:').' '.$donation_payment_details->donation->title;
            $paypal_details['custom'] = $donation_payment_details->track;
            $paypal_details['amount'] = $payable_amount;
            $paypal_details['return'] = route('frontend.donation.payment.success',$donation_payment_details->id);
            $paypal_details['cancel_return'] = route('frontend.donation.payment.cancel',$donation_payment_details->id);
            $paypal_details['notify_url'] = route('frontend.donation.paypal.ipn');

            return view('frontend.payment.paypal')->with(['paypal_details' => $paypal_details]);

        }elseif ($request->selected_payment_gateway == 'paytm'){
            $amount = $donation_payment_details->amount;
            if (!is_paytm_supported_currency() ){
                $amount = get_amount_in_inr($amount,get_static_option('site_global_currency'));
            }

            $data_for_request = $this->handlePaytmRequest( $donation_payment_details->track, $amount );

            $paytm_txn_url = PAYTM_TXN_URL;
            $paramList = $data_for_request['paramList'];
            $checkSum = $data_for_request['checkSum'];

            return view('frontend.payment.paytm')->with([
                'paytm_txn_url' => $paytm_txn_url,
                'paramList' => $paramList,
                'checkSum' => $checkSum,
            ]);

        }elseif ($request->selected_payment_gateway == 'manual_payment'){
            $this->validate($request,[
                'transaction_id' => 'required|string'
            ],
            [
                'transaction_id.required' => __('Transaction ID Required')
            ]);

            DonationLogs::where('donation_id',$request->donation_id)->update(['transaction_id' => $request->transaction_id]);

            return redirect()->route('frontend.donation.payment.success',$donation_payment_details->id);

        }elseif ($request->selected_payment_gateway == 'stripe'){


            $stripe_data['title'] = __('Payment of donation:').' '.$donation_payment_details->donation->title;
            $stripe_data['order_id'] = $donation_payment_details->id;
            $stripe_data['price'] = number_format($donation_payment_details->amount,2);
            $stripe_data['route'] = route('frontend.donation.stripe.ipn');

            return view('frontend.payment.stripe')->with('stripe_data' ,$stripe_data);
        }
        elseif ($request->selected_payment_gateway == 'razorpay'){


            $payable_amount = $donation_payment_details->amount;
            $currency_code = get_static_option('site_global_currency');

            if (!is_razorpay_supported_currency()){
                $payable_amount = get_amount_in_inr($donation_payment_details->amount,get_static_option('site_global_currency'));
                $currency_code = 'INR';
            }

            $razorpay_data['currency_symbol'] = $currency_code;
            $razorpay_data['currency'] = $currency_code;
            $razorpay_data['price'] = $payable_amount;
            $razorpay_data['package_name'] = $donation_payment_details->donation->title;
            $razorpay_data['order_id'] = $donation_payment_details->id;
            $razorpay_data['route'] = route('frontend.donation.razorpay.ipn');

            return view('frontend.payment.razorpay')->with('razorpay_data' ,$razorpay_data);

        }
        elseif ($request->selected_payment_gateway == 'paystack'){
            
            $payable_amount =  $donation_payment_details->amount;
            $currency_code = get_static_option('site_global_currency');

            if (!is_paystack_supported_currency()){
                $payable_amount = get_amount_in_ngn($donation_payment_details->amount,get_static_option('site_global_currency'));
                $currency_code = 'NGN';
            }
            $paystack_data['currency'] = $currency_code;
            $paystack_data['price'] = $payable_amount;
            $paystack_data['package_name'] =  $donation_payment_details->donation->title;
            $paystack_data['name'] = $donation_payment_details->name;
            $paystack_data['email'] = $donation_payment_details->email;
            $paystack_data['order_id'] = $donation_payment_details->id;
            $paystack_data['track'] = $donation_payment_details->track;
            $paystack_data['route'] = route('frontend.donation.paystack.pay');

            $paystack_data['type'] = 'donation';

            return view('frontend.payment.paystack')->with(['paystack_data' => $paystack_data]);
        }
        elseif ($request->selected_payment_gateway == 'mollie'){

            $payable_amount = $donation_payment_details->amount;
            $currency_code = get_static_option('site_global_currency');

            if (!is_mollie_supported_currency() ){
                $payable_amount = get_amount_in_usd($payable_amount,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }

            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => $currency_code,
                    "value" => number_format($payable_amount,2),//"10.00" // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                "description" => "Donation Cause ID #".$donation_payment_details->id .' Name: '.$donation_payment_details->name.' Email: '.$donation_payment_details->email,
                "redirectUrl" => route('frontend.donation.mollie.webhook'),
                "metadata" => [
                    "order_id" => $donation_payment_details->id,
                    "track" => $donation_payment_details->track,
                ],
            ]);

            $payment = Mollie::api()->payments->get($payment->id);

            session()->put('mollie_payment_id',$payment->id);

            // redirect customer to Mollie checkout page
            return redirect($payment->getCheckoutUrl(), 303);
        }
        elseif ($request->selected_payment_gateway == 'flutterwave'){

            $payable_amount = $donation_payment_details->amount;
            $currency_code = get_static_option('site_global_currency');
            if (!is_flutterwave_supported_currency()){
                $payable_amount = get_amount_in_usd($donation_payment_details->amount,get_static_option('site_global_currency'));
                $currency_code = 'USD';
            }

            $flutterwave_data['currency'] = $currency_code;
            $flutterwave_data['name'] = $donation_payment_details->name;
            $flutterwave_data['form_action'] = route('frontend.donation.flutterwave.pay');
            $flutterwave_data['amount'] = $payable_amount;
            $flutterwave_data['description'] = "Donation Details ID #".$donation_payment_details->id .' Name: '.$donation_payment_details->name;
            $flutterwave_data['email'] = $donation_payment_details->email;
            $flutterwave_data['country'] = get_visitor_country() ? get_visitor_country() : 'NG';
            $flutterwave_data['metadata'] = [
                ['metaname' => 'order_id', 'metavalue' => $donation_payment_details->id],
                ['metaname' => 'track', 'metavalue' => $donation_payment_details->track],
            ];
            return view('frontend.payment.flutterwave')->with('flutterwave_data' ,$flutterwave_data);
        }elseif ($request->selected_payment_gateway == 'midtrans'){
            $payable_amount = $donation_payment_details->amount;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000;
            }
            $title = 'Donation: '.$donation_payment_details->donation->title;
            $redirect_url = MidtransController::getRedirectUrl(
                'donation', 
                $donation_payment_details->track, 
                $payable_amount, 
                $donation_payment_details->name, 
                $donation_payment_details->email, 
                null, 
                $title
            );
            if ($redirect_url) {
                return redirect($redirect_url);
            }
            return redirect()->back()->with(['msg' => __('Midtrans Error. Please contact support.'), 'type' => 'danger']);
        }elseif ($request->selected_payment_gateway == 'tripay'){
            $payable_amount = $donation_payment_details->amount;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000;
            }
            $title = 'Donation: '.$donation_payment_details->donation->title;
            return TripayController::getRedirectUrl(
                'donation',
                $donation_payment_details->track,
                $payable_amount,
                $donation_payment_details->name,
                $donation_payment_details->email,
                null,
                $title
            );
        }elseif ($request->selected_payment_gateway == 'xendit'){
            $payable_amount = $donation_payment_details->amount;
            if (get_static_option('site_global_currency') !== 'IDR') {
                $payable_amount = get_amount_in_usd($payable_amount, get_static_option('site_global_currency')) * 15000;
            }
            $title = 'Donation: '.$donation_payment_details->donation->title;
            $redirect_url = XenditController::getRedirectUrl(
                'donation',
                $donation_payment_details->track,
                $payable_amount,
                $donation_payment_details->name,
                $donation_payment_details->email,
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
        Rave::initialize(route('frontend.donation.flutterwave.callback'));
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

        $payment_logs = DonationLogs::where('track', $track)->first();
        if (($chargeResponsecode == "00" || $chargeResponsecode == "0")){
            //update event payment log

            $payment_logs->status = 'complete';
            $payment_logs->transaction_id = $txRef;
            $payment_logs->save();

            //update donation raised amount
            $event_details = Donation::find($payment_logs->donation_id);
            $event_details->raised = intval($event_details->raised) + intval($payment_logs->amount);
            $event_details->save();

            //send success mail to user and admin
            $this->send_mail($payment_logs->id);
            return redirect()->route('frontend.donation.payment.success',$payment_logs->id);

        }else{
            return redirect()->route('frontend.donation.payment.cancel',$payment_logs->id);
        }

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
            $payment_logs = DonationLogs::where('track', $track)->first();
            $paypal_business_email = get_static_option('paypal_business_email');

            if ($receiver_email == $paypal_business_email && $payment_logs->status == 'pending') {

                //update event payment log
                $payment_logs = DonationLogs::where('track', $track)->first();
                $payment_logs->status = 'complete';
                $payment_logs->transaction_id = $_POST['txn_id'];
                $payment_logs->save();


                //update donation raised amount
                $event_details = Donation::find($payment_logs->donation_id);
                $event_details->raised = intval($event_details->raised) + intval($payment_logs->amount);
                $event_details->save();

                $this->send_mail($payment_logs->id);
            }
        }
    }

    public function paytm_ipn(Request $request){
        $order_id = $request['ORDERID'];

        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {


                //update event payment log
                $payment_logs = DonationLogs::where('track', $order_id)->first();
                $payment_logs->status = 'complete';
                $payment_logs->transaction_id = $request['TXNID'];
                $payment_logs->save();

                //update donation raised amount
                $event_details = Donation::find($payment_logs->donation_id);
                $event_details->raised = intval($event_details->raised) + intval($payment_logs->amount);
                $event_details->save();

                $this->send_mail($payment_logs->id);

            return redirect()->route('frontend.donation.payment.success',$payment_logs->id);

        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
             //update event payment log
             $payment_logs = DonationLogs::where('track', $request['ORDERID'])->first();
            return redirect()->route('frontend.donation.payment.cancel',$payment_logs->id);
        }
    }

    public function stripe_ipn(Request $request)
    {
        // stripe customer payment token
        $stripe_token = $request->stripe_token;
        $payment_log_details = DonationLogs::find($request->order_id);
        Stripe::setApiKey( get_static_option('stripe_secret_key') );

        if (!empty($stripe_token)){
            // charge customer with your amount
            $result = Charge::create(array(
                "currency" => get_static_option('site_global_currency'),
                "amount"   => $payment_log_details->amount * 100, // amount in cents,
                'source' => $stripe_token,
                'description' => 'Payment From '. get_static_option('site_'.get_default_language().'_title').'. Donation Log ID '.$payment_log_details->id .', Payer Name: '.$payment_log_details->name.', Payer Email: '.$payment_log_details->email,
            ));
        }

        if ($result->status == 'succeeded'){
            //donation logs update
            $payment_log_details->status = 'complete';
            $payment_log_details->transaction_id = $result->balance_transaction;
            $payment_log_details->save();

            //update donation raised amount
            $event_details = Donation::find($payment_log_details->donation_id);
            $event_details->raised = intval($event_details->raised) + intval($payment_log_details->amount);
            $event_details->save();

            //send success mail to user and admin
            if (!empty(get_static_option('donation_notify_mail'))){
                Mail::to(get_static_option('donation_notify_mail'))->send(new PaymentSuccess($payment_log_details,'donation'));
            }
            Mail::to($payment_log_details->email)->send(new PaymentSuccess($payment_log_details,'donation'));

            return redirect()->route('frontend.donation.payment.success',$request->order_id);
        }
        return redirect()->route('frontend.donation.payment.cancel',$request->order_id);
    }

    public function razorpay_ipn(Request $request){

        $donation_logs = DonationLogs::find($request->order_id);

        //get API Configuration
        $api = new Api(get_static_option('razorpay_key'), get_static_option('razorpay_secret'));
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($request->razorpay_payment_id);

        if(!empty($request->razorpay_payment_id)) {
            try {
                $response = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount'=> $payment['amount']));
            } catch (\Exception $e) {
                return redirect()->route('frontend.donation.payment.cancel',$request->order_id);
            }
            // Do something here for store payment details in database...
            //update donation log status
            $donation_logs->status = 'complete';
            $donation_logs->transaction_id = $payment->id;
            $donation_logs->save();

            //update donation raised amount
            $event_details = Donation::find($donation_logs->donation_id);
            $event_details->raised = intval($event_details->raised) + intval($donation_logs->amount);
            $event_details->save();

            //send success mail to user and admin
            if (!empty(get_static_option('donation_notify_mail'))){
                Mail::to(get_static_option('donation_notify_mail'))->send(new PaymentSuccess($donation_logs,'donation'));
            }
            Mail::to($donation_logs->email)->send(new PaymentSuccess($donation_logs,'donation'));

        }

        return redirect()->route('frontend.donation.payment.success',$request->order_id);
    }

    public function mollie_webhook(){
        $payment_id = session()->get('mollie_payment_id');
        $payment = Mollie::api()->payments->get($payment_id);
        session()->forget('mollie_payment_id');
        $payment_log_details = DonationLogs::where('track',$payment->metadata->track)->first();

         if ($payment->isPaid()){
            //donation logs update
            $payment_log_details->status = 'complete';
            $payment_log_details->transaction_id = $payment->id;
            $payment_log_details->save();

            //update donation raised amount
            $event_details = Donation::find($payment_log_details->donation_id);
            $event_details->raised = intval($event_details->raised) + intval($payment_log_details->amount);
            $event_details->save();

            //send success mail to user and admin
             $this->send_mail($payment_log_details->donation_id);

            return redirect()->route('frontend.donation.payment.success',$payment_log_details->id);
        }

        return redirect()->route('frontend.donation.payment.cancel',$payment_log_details->id);
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
        $paramList["CALLBACK_URL"] = route('frontend.donation.paytm.ipn');
        $paytm_merchant_key = get_static_option('paytm_merchant_key');

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );

        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
    }

    public function paystack_pay(){
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function send_mail($donation_log_id){
        $donation_details = DonationLogs::find($donation_log_id);
        Mail::to(get_static_option('site_global_email'))->send(new DonationMessage($donation_details,__('You have a new donation payment from '.get_static_option('site_'.get_default_language().'_title')),'owner'));
        Mail::to(get_static_option('donation_notify_mail'))->send(new DonationMessage($donation_details,__('Your donation payment success for '.get_static_option('site_'.get_default_language().'_title')),'customer'));
    }

}
