@extends('user-side.components.app')
@section('content')
<style>
    :root {
        --primary-color: #5469d4;
        --secondary-color: #1a1f36;
        --success-color: #0d9488;
        --danger-color: #dc2626;
        --background-color: #f7fafc;
        --text-primary: #1a1f36;
        --text-secondary: #697386;
        --border-radius: 12px;
        --card-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.1);
    }

    .payment-container {
        min-height: 100vh;
        padding: 2rem;
        background-color: var(--background-color);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        width: 100%;
        max-width: 500px;
        padding: 2rem;
    }

    .payment-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .logo-container {
        margin-bottom: 1rem;
    }

    .payment-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
    }

    .payment-header h2 {
        color: var(--text-primary);
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .payment-subtitle {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .amount-display {
        background: #f8faff;
        border-radius: var(--border-radius);
        padding: 1rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .amount-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .amount-value {
        color: var(--text-primary);
        font-size: 1.25rem;
        font-weight: 600;
    }

    .payment-form {
        margin-bottom: 1.5rem;
    }

    .form-section {
        margin-bottom: 1.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .payment-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-primary);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .field-icon {
        color: var(--text-secondary);
    }

    .card-field {
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        padding: 0.75rem;
        background: white;
        transition: border-color 0.3s ease;
    }

    .card-field:hover {
        border-color: var(--primary-color);
    }

    .payment-button {
        width: 100%;
        padding: 1rem;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .payment-button:hover {
        background-color: #4559bc;
    }

    .payment-button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .payment-button.processing {
        background-color: #4559bc;
    }

    .button-icon {
        font-size: 0.875rem;
    }

    .payment-result {
        margin-top: 1rem;
        min-height: 24px;
    }

    .error-message, .success-message {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        border-radius: var(--border-radius);
        font-size: 0.875rem;
    }

    .error-message {
        background-color: #fef2f2;
        color: var(--danger-color);
    }

    .success-message {
        background-color: #ecfdf5;
        color: var(--success-color);
    }

    .security-info {
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .alert {
        padding: 1rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .alert-danger {
        background-color: #fef2f2;
        color: var(--danger-color);
    }

    .alert-success {
        background-color: #ecfdf5;
        color: var(--success-green);
    }

    @media (max-width: 640px) {
        .payment-container {
            padding: 1rem;
        }

        .payment-card {
            padding: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
<div class="payment-container">
    <div class="payment-card">
        <div class="payment-header">
            <div class="logo-container">
                <i class="fa-regular fa-credit-card payment-icon"></i>
            </div>
            <h2>Secure Payment</h2>
        </div>

        <div class="amount-display">
            <span class="amount-label">Amount to Pay</span>
            <span class="amount-value">${{ number_format(session('required_amount'), 2) }}</span>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="payment-form">
            <div class="form-section">
                <label class="payment-label">
                    <i class="fa-regular fa-credit-card field-icon"></i>
                    Card Number
                </label>
                <div id="card-number-element" class="card-field"></div>
                <small id="card-brand" class="text-secondary">Card Type: <span>Unknown</span></small>
            </div>

            <div class="form-row">
                <div class="form-section">
                    <label class="payment-label">
                        <i class="fa-regular fa-calendar field-icon"></i>
                        Expiry Date
                    </label>
                    <div id="card-expiry-element" class="card-field"></div>
                    <small class="field-helper">Enter the expiration date (MM/YY)</small>
                </div>

                <div class="form-section">
                    <label class="payment-label">
                        <i class="fa-solid fa-lock field-icon"></i>
                        CVC
                    </label>
                    <div id="card-cvc-element" class="card-field"></div>
                    <small class="field-helper">3-digit code on the back of your card</small>
                </div>
            </div>

            <form action="{{ route('stripe.process') }}" method="POST">
                @csrf
                <input type="hidden" name="required_amount" value="{{ session('required_amount')  }}">
                <button id="card-button" class="payment-button" data-secret="{{ $clientSecret }}">
                    <span class="button-text">Pay ${{ number_format(session('required_amount'), 2) }}</span>
                    <i class="fa-solid fa-lock button-icon"></i>
                </button>
            </form>

            <div id="payment-result" class="payment-result"></div>
        </div>

        <div class="security-info">
            <i class="fa-solid fa-shield-halved"></i>
            <p>Your payment information is encrypted and secure.</p>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const elements = stripe.elements();

    const style = {
        base: {
            color: '#424770',
            fontFamily: 'system-ui, -apple-system, "Segoe UI", Roboto, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            },
        },
        invalid: {
            color: '#dc2626',
            iconColor: '#dc2626'
        }
    };

    const cardNumber = elements.create('cardNumber', {style: style});
    const cardExpiry = elements.create('cardExpiry', {style: style});
    const cardCvc = elements.create('cardCvc', {style: style});

    cardNumber.mount('#card-number-element');
    cardExpiry.mount('#card-expiry-element');
    cardCvc.mount('#card-cvc-element');

    const cardBrandElement = document.getElementById('card-brand');
    cardNumber.on('change', (event) => {
        const brand = event.brand ? event.brand.charAt(0).toUpperCase() + event.brand.slice(1) : 'Unknown';
        cardBrandElement.querySelector('span').textContent = brand;
    });
});
</script>
@endsection
