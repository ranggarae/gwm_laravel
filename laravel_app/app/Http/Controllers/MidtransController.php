<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\ProductOrder;
use App\EventPaymentLogs;
use App\DonationLogs;
use App\PaymentLogs;

class MidtransController extends Controller
{
    /**
     * Generate Midtrans Snap Redirect URL
     */
    public static function getRedirectUrl($order_type, $track_id, $amount, $customer_name, $customer_email, $customer_phone, $title)
    {
        $serverKey = get_static_option('midtrans_server_key');
        $isProduction = get_static_option('midtrans_env') == 'production';
        $baseUrl = $isProduction ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $order_id = $order_type . '_' . $track_id . '_' . time(); // Make unique
        
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => ceil($amount),
            ],
            'customer_details' => [
                'first_name' => $customer_name,
                'email' => $customer_email,
                'phone' => $customer_phone ?? '00000000000',
            ],
            'item_details' => [
                [
                    'id' => $order_type,
                    'price' => ceil($amount),
                    'quantity' => 1,
                    'name' => substr($title, 0, 50),
                ]
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($serverKey . ':'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($baseUrl, $params);

            if ($response->successful()) {
                return $response->json()['redirect_url'];
            }
            
            Log::error('Midtrans Error: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Handle IPN Webhook from Midtrans
     */
    public function ipn(Request $request)
    {
        $serverKey = get_static_option('midtrans_server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                
                // Parse order_id: product_xxxxxxxx_1234567890
                $parts = explode('_', $request->order_id);
                $order_type = $parts[0];
                $track_id = $parts[1];
                
                if ($order_type == 'product') {
                    $order = ProductOrder::where('payment_track', $track_id)->first();
                    if ($order && $order->payment_status != 'complete') {
                        $order->payment_status = 'complete';
                        $order->transaction_id = $request->transaction_id;
                        $order->save();
                        ProductOrderController::send_mail($order);
                    }
                } elseif ($order_type == 'event') {
                    $order = EventPaymentLogs::where('track', $track_id)->first();
                    if ($order && $order->status != 'complete') {
                        $order->status = 'complete';
                        $order->transaction_id = $request->transaction_id;
                        $order->save();
                        $event_controller = new EventPaymentLogsController();
                        $event_controller->send_event_mail($order);
                    }
                } elseif ($order_type == 'donation') {
                    $order = DonationLogs::where('track', $track_id)->first();
                    if ($order && $order->status != 'complete') {
                        $order->status = 'complete';
                        $order->transaction_id = $request->transaction_id;
                        $order->save();
                        $donation_controller = new DonationLogController();
                        $donation_controller->send_donation_mail($order);
                    }
                } elseif ($order_type == 'service') {
                    $order = PaymentLogs::where('track', $track_id)->first();
                    if ($order && $order->status != 'complete') {
                        $order->status = 'complete';
                        $order->transaction_id = $request->transaction_id;
                        $order->save();
                        PaymentLogController::send_order_mail($order->id);
                    }
                }
            }
        }
        
        return response()->json(['status' => 'success']);
    }
}
