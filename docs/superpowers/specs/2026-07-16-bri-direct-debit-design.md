# BRI SNAP Direct Debit (Card Registration) Design Specification

## Overview
Implement a Direct Debit / Card Registration feature using the BRI API (SNAP Sandbox) into the Nexelit Laravel CMS. This will allow EV Charging customers to bind their BRI Debit/Credit cards to their accounts for seamless 1-click payments.

## Architecture & Components

### 1. Database Layer
**Table:** `user_saved_cards`
- `id` (Primary Key)
- `user_id` (Foreign Key referencing `users`)
- `card_token` (String, encrypted token from BRI API)
- `masked_card` (String, e.g., "1234 **** **** 5678")
- `card_type` (String, e.g., "BRI Debit")
- `expiry_date` (String, optional)
- `status` (Enum: active, inactive)
- Timestamps

**Note on Security:** 
No raw card numbers or CVV will be stored. Only the API token and the masked string will be retained in the database in compliance with PCI-DSS guidelines.

### 2. Backend (Controllers & Services)
**`BriDirectDebitController`**
- `registerCard()`: Initiates the card binding process, handles Oauth2 B2B token generation, and builds the SHA256withRSA signature according to BI-SNAP standards.
- `chargeCard()`: Uses the saved token to deduct funds during checkout.
- `unbindCard()`: Removes the token from the system and signals the BRI API to drop the binding.

### 3. Frontend (User Interface)
**Bilingual Support Requirement:** 
All new UI elements must use Laravel's localization wrapper `{{__('Text')}}`. JSON translation files (`id.json` and `en.json`) must be updated with all new phrases.

**User Dashboard:**
- New Menu: "My Cards" / "Kartu Saya"
- A page displaying a list of saved cards.
- "Add New Card" / "Tambah Kartu Baru" button, which redirects or opens a modal to the BRI SNAP card input form.
- "Delete" / "Hapus" button next to each saved card.

**Checkout Page:**
- Additional Payment Method radio button: "BRI Direct Debit" / "Bayar dengan Kartu BRI Tersimpan".
- If selected, a dropdown appears listing the user's saved cards.

### 4. External Integrations (API Flow)
- **Token Generation:** `/api/v1.0/access-token/b2b`
- **Signature:** `/api/v1.0/utilities/signature-auth`
- **Card Binding:** `/snap/v1.0/registration/binding`
- **Payment Deduction:** `/snap/v1.0/payment/direct-debit`

### 5. Error Handling
- Catch API timeouts and display user-friendly error messages (bilingual).
- Handle "Insufficient Funds" or "Token Expired" responses from BRI API during checkout.
- Fallback to standard payment methods if the direct debit transaction fails.

## Verification
- Run tests on the Sandbox API.
- Simulate successful card binding, failed binding (invalid OTP), and successful deduction.
- Ensure translations correctly apply when switching between EN and ID.
