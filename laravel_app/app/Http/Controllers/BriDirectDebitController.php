<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserSavedCard;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Exception;

class BriDirectDebitController extends Controller
{
    private $clientId;
    private $clientSecret;
    private $baseUrl;

    public function __construct()
    {
        $this->clientId = get_static_option('bri_client_id');
        $this->clientSecret = get_static_option('bri_client_secret');
        $env = get_static_option('bri_env') === 'production' ? 'production' : 'sandbox';
        $this->baseUrl = $env === 'production' ? 'https://partner.api.bri.co.id' : 'https://sandbox.partner.api.bri.co.id';
    }

    public function getB2bToken()
    {
        if (!Storage::exists('bri/private.pem')) {
            throw new Exception("Private key not found. Please run php artisan bri:generate-keys first.");
        }
        
        $timestamp = gmdate("Y-m-d\TH:i:sP"); // SNAP BI standard format e.g. 2026-07-16T15:20:30+07:00, but using gmdate for UTC: 2026-07-16T08:20:30+00:00. Wait, SNAP expects ISO8601 usually. Let's stick to the SNAP timestamp format: Y-m-d\TH:i:sP
        // Actually, SNAP specifies X-TIMESTAMP as ISO8601.
        $timestamp = date("Y-m-d\TH:i:sP"); // Use local timezone with offset
        
        $stringToSign = $this->clientId . "|" . $timestamp;
        
        $privateKeyStr = Storage::get('bri/private.pem');
        $privateKey = openssl_pkey_get_private($privateKeyStr);
        openssl_sign($stringToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $signature = base64_encode($signature);

        $client = new Client();
        try {
            $response = $client->post($this->baseUrl . '/snap/v1.0/access-token/b2b', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-TIMESTAMP' => $timestamp,
                    'X-CLIENT-KEY' => $this->clientId,
                    'X-SIGNATURE' => $signature,
                ],
                'json' => ['grant_type' => 'client_credentials']
            ]);
            $body = json_decode($response->getBody()->getContents(), true);
            return $body['accessToken'] ?? null;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $errorMsg = $e->getResponse()->getBody()->getContents();
            \Illuminate\Support\Facades\Log::error('BRI B2B Token Error: ' . $errorMsg);
            throw new Exception("BRI B2B Token Error: " . $errorMsg);
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('BRI Connection Error: ' . $e->getMessage());
            throw new Exception("Connection Error: " . $e->getMessage());
        }
    }

    public function generateSignature($method, $path, $token, $body, $timestamp)
    {
        $bodyStr = empty($body) ? "" : json_encode($body, JSON_UNESCAPED_SLASHES);
        $hashedBody = strtolower(hash('sha256', $bodyStr));
        
        $stringToSign = $method . ":" . $path . ":" . $token . ":" . $hashedBody . ":" . $timestamp;
        
        return base64_encode(hash_hmac('sha512', $stringToSign, $this->clientSecret, true));
    }

    public function startRegistration(Request $request)
    {
        if(!Auth::check()) return redirect()->back()->with(['msg' => __('Unauthorized'), 'type' => 'danger']);
        
        try {
            $token = $this->getB2bToken();
            if(!$token) return redirect()->back()->with(['msg' => __('Failed to get B2B Access Token from BRI'), 'type' => 'danger']);

            $timestamp = date("Y-m-d\TH:i:sP");
            $path = '/snap/v1.0/card-registration';
            $method = 'POST';
            $body = [
                'partnerReferenceNo' => 'REG-' . time() . '-' . Auth::id(),
                'customerNumber' => (string) Auth::id(),
            ];

            $signature = $this->generateSignature($method, $path, $token, $body, $timestamp);
            
            $client = new Client();
            $response = $client->post($this->baseUrl . $path, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                    'X-TIMESTAMP' => $timestamp,
                    'X-SIGNATURE' => $signature,
                    'X-PARTNER-ID' => $this->clientId,
                    'CHANNEL-ID' => 'WEB',
                ],
                'json' => $body
            ]);
            
            $result = json_decode($response->getBody()->getContents(), true);
            
            if (isset($result['webRedirectUrl'])) {
                return redirect($result['webRedirectUrl']);
            }
            
            return redirect()->back()->with(['msg' => __('BRI SNAP Connection successful, but no redirect URL provided.'), 'type' => 'warning']);
            
        } catch (Exception $e) {
            return redirect()->back()->with(['msg' => 'BRI API Error: ' . $e->getMessage(), 'type' => 'danger']);
        }
    }

    public function getSavedCards()
    {
        if(!Auth::check()) return response()->json([]);
        return response()->json(UserSavedCard::where('user_id', Auth::id())->get());
    }

    public function simulateAddCard(Request $request)
    {
        if(!Auth::check()) return redirect()->back();

        UserSavedCard::create([
            'user_id' => Auth::id(),
            'card_token' => 'sim_' . time(),
            'masked_card' => '1234 **** **** ' . rand(1000, 9999),
            'card_type' => 'BRI Debit (Simulasi)',
            'status' => 'active'
        ]);

        return redirect()->back()->with(['msg' => __('Simulasi sukses! Kartu bohongan berhasil ditambahkan.'), 'type' => 'success']);
    }
}
