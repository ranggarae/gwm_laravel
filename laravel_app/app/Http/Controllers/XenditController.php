<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\ProductOrder;
use App\EventPaymentLogs;
use App\DonationLogs;
use App\PaymentLogs;

class XenditController extends Controller
{
    /**
     * Generate Xendit Invoice URL
     */
    public static function getRedirectUrl($order_type, $track_id, $amount, $customer_name, $customer_email, $title)
    {
        $secretKey = get_static_option('xendit_secret_key');
        $isProduction = get_static_option('xendit_env') == 'production';
        $baseUrl = 'https://api.xendit.co/v2/invoices';

        $external_id = $order_type . '_' . $track_id . '_' . time();

        $params = [
            'external_id' => $external_id,
            'amount' => ceil($amount),
            'payer_email' => $customer_email,
            'description' => substr($title, 0, 255),
            'currency' => 'IDR',
            'success_redirect_url' => url('/'),
        ];

        try {
            $response = Http::withBasicAuth($secretKey, '')
                ->post($baseUrl, $params);

            if ($response->successful()) {
                return $response->json()['invoice_url'];
            }

            Log::error('Xendit Error: ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('Xendit Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Handle IPN Webhook from Xendit
     */
    public function ipn(Request $request)
    {
        // Verify callback token
        $callbackToken = $request->header('x-callback-token');
        $expectedToken = get_static_option('xendit_secret_key');

        // Xendit sends payment notification with status
        if ($request->status == 'PAID' || $request->status == 'SETTLED') {
            // Parse external_id: product_xxxxxxxx_1234567890
            $parts = explode('_', $request->external_id);
            $order_type = $parts[0];
            $track_id = $parts[1];

            if ($order_type == 'product') {
                $order = ProductOrder::where('payment_track', $track_id)->first();
                if ($order && $order->payment_status != 'complete') {
                    $order->payment_status = 'complete';
                    $order->transaction_id = $request->id;
                    $order->save();
                    ProductOrderController::send_mail($order);
                }
            } elseif ($order_type == 'event') {
                $order = EventPaymentLogs::where('track', $track_id)->first();
                if ($order && $order->status != 'complete') {
                    $order->status = 'complete';
                    $order->transaction_id = $request->id;
                    $order->save();
                    $controller = new EventPaymentLogsController();
                    $controller->send_event_mail($order);
                }
            } elseif ($order_type == 'donation') {
                $order = DonationLogs::where('track', $track_id)->first();
                if ($order && $order->status != 'complete') {
                    $order->status = 'complete';
                    $order->transaction_id = $request->id;
                    $order->save();
                    $controller = new DonationLogController();
                    $controller->send_donation_mail($order);
                }
            } elseif ($order_type == 'service') {
                $order = PaymentLogs::where('track', $track_id)->first();
                if ($order && $order->status != 'complete') {
                    $order->status = 'complete';
                    $order->transaction_id = $request->id;
                    $order->save();
                    PaymentLogController::send_order_mail($order->id);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
