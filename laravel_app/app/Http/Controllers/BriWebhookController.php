<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserSavedCard;
use Illuminate\Support\Facades\Log;

class BriWebhookController extends Controller
{
    /**
     * Handle the incoming Webhook from BRI SNAP for card registration callback
     */
    public function handleCardRegistrationCallback(Request $request)
    {
        // Log the callback for debugging
        Log::info('BRI Webhook Received: ', $request->all());

        // In a real implementation, you MUST verify the X-SIGNATURE header from BRI here
        // using the Public Key provided by BRI.
        
        $partnerReferenceNo = $request->input('partnerReferenceNo');
        $customerNumber = $request->input('customerNumber');
        $status = $request->input('status'); // e.g. "SUCCESS", "FAILED"
        $cardToken = $request->input('cardToken');
        $maskedCard = $request->input('maskedCard');

        if ($status === 'SUCCESS' && $cardToken && $maskedCard) {
            // Save the newly registered card token to database
            UserSavedCard::create([
                'user_id' => $customerNumber,
                'card_token' => $cardToken,
                'masked_card' => $maskedCard,
                'card_type' => 'BRI Debit',
                'status' => 'active'
            ]);
            
            return response()->json(['responseCode' => '2000000', 'responseMessage' => 'Successful']);
        }

        return response()->json(['responseCode' => '4000000', 'responseMessage' => 'Failed processing webhook'], 400);
    }
}
