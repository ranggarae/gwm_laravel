<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\ProductOrder;
use App\EventPaymentLogs;
use App\DonationLogs;
use App\PaymentLogs;

class TripayController extends Controller
{
    /**
     * Store data to session and return redirect URL to our Tripay selection page
     */
    public static function getRedirectUrl($order_type, $track_id, $amount, $customer_name, $customer_email, $customer_phone, $title)
    {
        session([
            'tripay_order_data' => [
                'order_type' => $order_type,
                'track_id' => $track_id,
                'amount' => ceil($amount),
                'customer_name' => $customer_name,
                'customer_email' => $customer_email,
                'customer_phone' => $customer_phone,
                'title' => $title
            ]
        ]);
        return route('tripay.checkout');
    }

    /**
     * Show payment channels
     */
    public function checkout()
    {
        $data = session('tripay_order_data');
        if (!$data) return redirect()->to('/');
        
        $apiKey = get_static_option('tripay_api_key');
        $isProduction = strtolower((string) get_static_option('tripay_env')) == 'production';
        $baseUrl = $isProduction ? 'https://tripay.co.id/api/merchant/payment-channel' : 'https://tripay.co.id/api-sandbox/merchant/payment-channel';

        try {
            $response = Http::withToken($apiKey)->get($baseUrl);
            $channels = $response->json()['data'] ?? [];
            return view('frontend.payment.tripay', compact('channels', 'data'));
        } catch (\Exception $e) {
            return back()->with(['msg' => 'Tripay Channel Error: '.$e->getMessage(), 'type' => 'danger']);
        }
    }

    /**
     * Process creation of transaction
     */
    public function process(Request $request)
    {
        $request->validate(['method' => 'required']);
        $data = session('tripay_order_data');
        if (!$data) return redirect()->to('/');

        $apiKey = get_static_option('tripay_api_key');
        $privateKey = get_static_option('tripay_private_key');
        $merchantCode = get_static_option('tripay_merchant_code');
        $isProduction = strtolower((string) get_static_option('tripay_env')) == 'production';
        $baseUrl = $isProduction ? 'https://tripay.co.id/api/transaction/create' : 'https://tripay.co.id/api-sandbox/transaction/create';

        $merchantRef = $data['order_type'] . '_' . $data['track_id'] . '_' . time();
        $amount = $data['amount'];
        $signature = hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey);

        $payload = [
            'method' => $request->method,
            'merchant_ref' => $merchantRef,
            'amount' => $amount,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?? '00000000000',
            'order_items' => [
                [
                    'sku' => $data['order_type'],
                    'name' => substr($data['title'], 0, 50),
                    'price' => $amount,
                    'quantity' => 1
                ]
            ],
            'return_url' => url('/'),
            'expired_time' => (time() + (24 * 60 * 60)), // 24 hours
            'signature' => $signature
        ];

        try {
            $response = Http::withToken($apiKey)->post($baseUrl, $payload);
            if ($response->successful() && isset($response['data']['checkout_url'])) {
                session()->forget('tripay_order_data');
                return redirect($response['data']['checkout_url']);
            }
            Log::error('Tripay Create Error: ' . $response->body());
            return back()->with(['msg' => 'Tripay Create Transaction Error. Please check API credentials.', 'type' => 'danger']);
        } catch (\Exception $e) {
            Log::error('Tripay Exception: ' . $e->getMessage());
            return back()->with(['msg' => 'Tripay Exception: ' . $e->getMessage(), 'type' => 'danger']);
        }
    }

    /**
     * Webhook
     */
    public function webhook(Request $request)
    {
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, get_static_option('tripay_private_key'));

        if ($signature !== $request->header('X-Callback-Signature')) {
            return response()->json(['success' => false, 'message' => 'Invalid signature'], 403);
        }

        if ('payment_status' !== $request->header('X-Callback-Event')) {
            return response()->json(['success' => false, 'message' => 'Unrecognized event'], 400);
        }

        $data = json_decode($json);

        if ($data->status === 'PAID') {
            $parts = explode('_', $data->merchant_ref);
            $order_type = $parts[0] ?? '';
            $track_id = $parts[1] ?? '';

            if ($order_type == 'product') {
                $order = ProductOrder::where('payment_track', $track_id)->first();
                if ($order && $order->payment_status != 'complete') {
                    $order->payment_status = 'complete';
                    $order->transaction_id = $data->reference;
                    $order->save();
                    ProductOrderController::send_mail($order);
                }
            } elseif ($order_type == 'event') {
                $order = EventPaymentLogs::where('track', $track_id)->first();
                if ($order && $order->status != 'complete') {
                    $order->status = 'complete';
                    $order->transaction_id = $data->reference;
                    $order->save();
                    $event_controller = new EventPaymentLogsController();
                    $event_controller->send_event_mail($order);
                }
            } elseif ($order_type == 'donation') {
                $order = DonationLogs::where('track', $track_id)->first();
                if ($order && $order->status != 'complete') {
                    $order->status = 'complete';
                    $order->transaction_id = $data->reference;
                    $order->save();
                    $donation_controller = new DonationLogController();
                    $donation_controller->send_donation_mail($order);
                }
            } elseif ($order_type == 'service') {
                $order = PaymentLogs::where('track', $track_id)->first();
                if ($order && $order->status != 'complete') {
                    $order->status = 'complete';
                    $order->transaction_id = $data->reference;
                    $order->save();
                    PaymentLogController::send_order_mail($order->id);
                }
            }
        }

        return response()->json(['success' => true]);
    }
}
