<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Secure Payment | {{ $storeName }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
</head>
<body>

<div class="payment-page">
    
<header class="page-header">

    <div class="header-left">
        <a href="{{ url('/checkout') }}" class="back-link"
           aria-label="Back to checkout">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <img src="{{ asset('images/banks/payfastlogo.png') }}"
             alt="PayFast Pakistan"
             class="payfast-logo-image">
    </div>

    <div class="secure-label">
        <i class="fa-solid fa-lock"></i>
        Secure checkout
    </div>

</header>


    <main class="payment-layout">

        <!-- ORDER SUMMARY -->
        <aside class="summary-card">
            <div class="brand">
                <div class="brand-mark">SM</div>

                <div>
                    <div class="brand-name">{{ $storeName }}</div>
                    <div class="brand-caption">Online Store</div>
                </div>
            </div>

            <div class="summary-heading">Order summary</div>

            <div class="order-number">
                <span>Order number</span>
                <strong>{{ $orderNumber }}</strong>
            </div>

            <div class="order-number">
                <span>Order date</span>
                <strong>{{ $orderDate->format('d M Y') }}</strong>
            </div>

            <div class="summary-divider"></div>

            <div class="amount-row">
                <span>Total amount</span>
                <strong>
                    Rs. {{ number_format($totalAmount, 2) }}
                </strong>
            </div>

            <div class="summary-note">
                <i class="fa-solid fa-shield-halved"></i>
                <span>
                    Your payment should only be completed through an
                    authorized payment provider.
                </span>
            </div>

            <div class="summary-footer">
                <i class="fa-solid fa-lock"></i>
                Secure payment experience
            </div>
            
<!-- QR CODE PAYMENT OPTION -->
<div class="qr-payment">
    <div class="qr-payment-heading">
        <div class="qr-icon">
            <i class="fa-solid fa-qrcode"></i>
        </div>

        <div class="qr-payment-text">
            <strong>Scan to pay</strong>
            <span>Quick and convenient payment</span>
        </div>
    </div>

    <button
        type="button"
        class="qr-open-button"
        id="openQrModal"
        aria-haspopup="dialog"
        aria-controls="qrModal"
    >
        <i class="fa-solid fa-qrcode"></i>
        View QR Code
        <i class="fa-solid fa-arrow-up-right-from-square"></i>
    </button>
</div>

<!-- QR CODE MODAL -->
<div
    class="qr-modal"
    id="qrModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="qrModalTitle"
    hidden
>
    <div class="qr-modal-backdrop" data-close-qr></div>

    <div class="qr-modal-content">
        <button
            type="button"
            class="qr-close-button"
            id="closeQrModal"
            aria-label="Close QR code"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="qr-modal-icon">
            <i class="fa-solid fa-qrcode"></i>
        </div>

        <h2 id="qrModalTitle">Scan to pay</h2>

        <p>
            Scan the merchant's official payment QR code using your
            supported banking app.
        </p>

        <div class="qr-code-placeholder" id="qrCodePlaceholder">
            <img
                src="{{ asset('images/banks/Qr code.jpeg') }}"
                alt="Merchant Payment QR Code"
                style="width: 220px; height: auto;"
            >
        </div>

        <div class="qr-modal-amount">
            <span>Amount payable</span>
            <strong>Rs. {{ number_format($totalAmount, 2) }}</strong>
        </div>

        <p class="qr-disclaimer">
            Use only a verified merchant QR code. A displayed QR code
            does not confirm that payment has been received.
        </p>
    </div>
</div>

        </aside>

        <!-- PAYMENT FORM -->
        <section class="payment-card">
            <div class="payment-heading">
                <span class="eyebrow">PAYMENT</span>
                <h1>Choose how to pay</h1>
                <p>Select your preferred payment method to continue.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Please check your details.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-warning" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <form
                action="{{ route('payments.initiate') }}"
                method="POST"
                id="paymentForm"
            >
                @csrf

                <!-- PAYMENT METHOD CHOICES -->
                <div class="payment-methods">

                    <label class="method-card active">
                        <input
                            type="radio"
                            name="payment_method"
                            value="card"
                            {{ old('payment_method', 'card') === 'card' ? 'checked' : '' }}
                        >

                        <span class="method-icon">
                            <i class="fa-regular fa-credit-card"></i>
                        </span>

                        <span class="method-name">Card</span>
                        <span class="method-description">Debit or credit</span>
                    </label>

                    <label class="method-card">
                        <input
                            type="radio"
                            name="payment_method"
                            value="wallet"
                            {{ old('payment_method') === 'wallet' ? 'checked' : '' }}
                        >

                        <span class="method-icon">
                            <i class="fa-solid fa-mobile-screen-button"></i>
                        </span>

                        <span class="method-name">Wallet</span>
                        <span class="method-description">Mobile wallet</span>
                    </label>

                    <label class="method-card">
                        <input
                            type="radio"
                            name="payment_method"
                            value="raast"
                            {{ old('payment_method') === 'raast' ? 'checked' : '' }}
                        >

                        <span class="method-icon">
                            <i class="fa-solid fa-bolt"></i>
                        </span>

                        <span class="method-name">Raast</span>
                        <span class="method-description">Instant payment</span>
                    </label>

                    <label class="method-card">
                        <input
                            type="radio"
                            name="payment_method"
                            value="bank"
                            {{ old('payment_method') === 'bank' ? 'checked' : '' }}
                        >

                        <span class="method-icon">
                            <i class="fa-solid fa-building-columns"></i>
                        </span>

                        <span class="method-name">Bank</span>
                        <span class="method-description">Bank transfer</span>
                    </label>

                </div>

                <!-- CARD -->
                
                
                <div class="method-panel" data-panel="card">
                    <div class="panel-title">Pay by card</div>

                    <div class="card-fields">

                        <div class="form-group">
                            <label for="card_number">Card number</label>
                            <input
                                type="text"
                                id="card_number"
                                name="card_number"
                                placeholder="1234 5678 9012 3456"
                                inputmode="numeric"
                                autocomplete="cc-number"
                                maxlength="19"
                                required
                                disabled
                            >
                        </div>

                        <div class="card-fields-row">
                            <div class="form-group">
                                <label for="card_expiry">Expiry date</label>
                                <input
                                    type="text"
                                    id="card_expiry"
                                    name="card_expiry"
                                    placeholder="MM/YY"
                                    inputmode="numeric"
                                    autocomplete="cc-exp"
                                    maxlength="5"
                                    required
                                    disabled
                                >
                            </div>

                            <div class="form-group">
                                <label for="card_cvv">CVV</label>
                                <input
                                    type="password"
                                    id="card_cvv"
                                    name="card_cvv"
                                    placeholder="123"
                                    inputmode="numeric"
                                    autocomplete="cc-csc"
                                    maxlength="4"
                                    pattern="[0-9]{3,4}"
                                    required
                                    disabled
                                >
                            </div>
                        </div>

                        <div class="gateway-message">
                            <div class="gateway-message-icon">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <strong>Secure card payment</strong>
                                <p>Enter your card details to continue with payment.</p>
                            </div>
                        </div>

                    </div>
                </div>



                <!-- MOBILE WALLET -->
                <div class="method-panel" data-panel="wallet" hidden>
                    <div class="panel-title">Mobile wallet details</div>

                    <div class="field-group">
                        <label for="wallet_provider">Select wallet</label>

                        <select
                            class="form-select"
                            id="wallet_provider"
                            name="wallet_provider"
                            disabled
                        >
                            <option value="">Choose a wallet</option>
                            <option
                                value="easypaisa"
                                @selected(old('wallet_provider') === 'easypaisa')
                            >
                                Easypaisa
                            </option>
                            <option
                                value="jazzcash"
                                @selected(old('wallet_provider') === 'jazzcash')
                            >
                                JazzCash
                            </option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label for="wallet_mobile">Registered mobile number</label>

                        <input
                            class="form-control"
                            id="wallet_mobile"
                            name="wallet_mobile"
                            type="tel"
                            inputmode="tel"
                            autocomplete="tel"
                            placeholder="03XX XXXXXXX"
                            value="{{ old('wallet_mobile') }}"
                            disabled
                        >
                    </div>

                    <div class="field-group">
                        <label for="wallet_cnic">CNIC (if required)</label>

                        <input
                            class="form-control cnic-input"
                            id="wallet_cnic"
                            name="wallet_cnic"
                            type="text"
                            inputmode="numeric"
                            maxlength="15"
                            placeholder="XXXXX-XXXXXXX-X"
                            value="{{ old('wallet_cnic') }}"
                            disabled
                        >
                    </div>
                </div>

                <!-- RAAST -->
                <div class="method-panel" data-panel="raast" hidden>
                    <div class="panel-title">Raast payment details</div>

                    <div class="field-group">
                        <label for="raast_id">Raast ID or IBAN</label>

                        <input
                            class="form-control"
                            id="raast_id"
                            name="raast_id"
                            type="text"
                            autocomplete="off"
                            placeholder="Enter your Raast ID or IBAN"
                            value="{{ old('raast_id') }}"
                            disabled
                        >
                    </div>

                    <div class="field-help">
                        Enter the identifier required by your supported
                        payment provider. This form does not itself initiate
                        a Raast transfer.
                    </div>
                </div>

                <!-- BANK TRANSFER -->
                
                <div class="method-panel" data-panel="bank" hidden>
                    <div class="panel-title">Bank transfer details</div>

                    <div class="field-group">
                        <label for="bankPickerTrigger">Select your bank</label>

                        <div class="bank-picker" id="bankPicker">
                            <input
                                type="hidden"
                                name="bank_name"
                                id="bank_name"
                                value="{{ old('bank_name') }}"
                                disabled
                            >

                            <button
                                type="button"
                                class="bank-picker-trigger"
                                id="bankPickerTrigger"
                                aria-expanded="false"
                                aria-haspopup="listbox"
                                disabled
                            >
                                
                        <span class="bank-picker-current" id="bankPickerCurrent">
                            <span class="bank-logo-fallback">
                                <i class="fa-solid fa-building-columns"></i>
                            </span>

                            <span id="bankPickerLabel">
                                {{ old('bank_name') ?: 'Select your bank' }}
                            </span>
                        </span>


                                <i class="fa-solid fa-chevron-down bank-chevron"></i>
                            </button>

                            <div
                                class="bank-picker-menu"
                                id="bankPickerMenu"
                                role="listbox"
                                aria-label="Choose your bank"
                                hidden
                            >
                                @foreach ([
                                    'HBL' => 'HBL.png',
                                    'UBL' => 'ubl.JPG',
                                    'MCB' => 'MCB.svg',
                                    'ABL' => 'ABL.png',
                                    'Meezan Bank' => 'meezan.png',
                                    'NBP' => 'NBP.png',
                                ] as $bank => $logoFile)
                                    <button
                                        type="button"
                                        class="bank-option"
                                        data-value="{{ $bank }}"
                                        data-name="{{ $bank }}"
                                        data-logo="{{ asset('images/banks/' . $logoFile) }}"
                                        role="option"
                                        aria-selected="{{ old('bank_name') === $bank ? 'true' : 'false' }}"
                                    >
                                        <img
                                            class="bank-logo"
                                            src="{{ asset('images/banks/' . $logoFile) }}"
                                            alt=""
                                        >

                                        <span>{{ $bank }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="field-group">
                        <label for="account_iban">Account number or IBAN</label>
                        <input
                            class="form-control"
                            id="account_iban"
                            name="account_iban"
                            type="text"
                            autocomplete="off"
                            placeholder="Enter account number or IBAN"
                            value="{{ old('account_iban') }}"
                            disabled
                        >
                    </div>

                    <div class="field-group">
                        <label for="bank_cnic">CNIC (if required)</label>
                        <input
                            class="form-control cnic-input"
                            id="bank_cnic"
                            name="bank_cnic"
                            type="text"
                            inputmode="numeric"
                            maxlength="15"
                            placeholder="XXXXX-XXXXXXX-X"
                            value="{{ old('bank_cnic') }}"
                            disabled
                        >
                    </div>

                    <p class="field-help">
                        A bank selection and account identifier do not complete a transfer.
                        Verify merchant bank instructions before accepting real payments.
                    </p>
                </div>

                <div class="payment-total">
                    <span>Amount payable</span>
                    <strong>Rs. {{ number_format($totalAmount, 2) }}</strong>
                </div>

                <button type="submit" class="pay-button" id="payButton">
                    <i class="fa-solid fa-lock"></i>
                    <span id="payButtonText">Continue to secure payment</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

                <p class="secure-caption">
                    <i class="fa-solid fa-shield-halved"></i>
                    Your payment is not completed until confirmed by the
                    payment provider.
                </p>
            </form>
        </section>
    </main>

    <footer class="page-footer">
        &copy; {{ now()->year }} {{ $storeName }}. All rights reserved.
    </footer>
</div>

<script src="{{ asset('js/payment.js') }}" defer></script>
</body>
</html>