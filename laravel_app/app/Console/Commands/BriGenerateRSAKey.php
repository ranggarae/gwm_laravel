<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BriGenerateRSAKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bri:generate-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate RSA 2048-bit keypair for BRI SNAP Integration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Generating RSA 2048-bit keypair for BRI SNAP...");

        $config = [
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];

        // Create the private and public key
        $res = openssl_pkey_new($config);
        
        if(!$res) {
            $this->error("Failed to generate keys. Make sure OpenSSL is installed and configured correctly.");
            return 1;
        }

        // Extract the private key
        openssl_pkey_export($res, $privKey);

        // Extract the public key
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];

        // Save Private Key to storage
        if (!Storage::exists('bri')) {
            Storage::makeDirectory('bri');
        }
        
        Storage::put('bri/private.pem', $privKey);
        Storage::put('bri/public.pem', $pubKey);

        $this->info("Keys generated successfully!");
        $this->info("Private key saved to: storage/app/bri/private.pem");
        $this->line("===============================================");
        $this->info("PUBLIC KEY (Copy and paste this into BRI Dev Portal):");
        $this->line($pubKey);
        $this->line("===============================================");
        
        return 0;
    }
}
