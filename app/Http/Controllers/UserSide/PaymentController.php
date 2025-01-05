<?php

namespace App\Http\Controllers\UserSide;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function showStripeForm()
    {
        $required_amount = session('required_amount');
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $required_amount * 100, // تحويل إلى سنت
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        $clientSecret = $paymentIntent->client_secret;

        return view('user-side.pages.stripe-payment', compact('clientSecret', 'required_amount'));
    }



    public function processStripePayment(Request $request)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        try {
            // التحقق من صحة البيانات
            $requiredAmount = $request->input('required_amount');
            if (!$requiredAmount || !is_numeric($requiredAmount)) {
                return redirect()->back()->with('error', 'Invalid payment amount.');
            }

            // إنشاء PaymentIntent
            $stripe->paymentIntents->create([
                'amount' => $requiredAmount * 100, // تحويل إلى سنت
                'currency' => 'usd',
                'payment_method_types' => ['card'],
            ]);

            // تحديث رصيد المستخدم
            $user = Auth::user();
            $user->insurance_balance += $requiredAmount;
            $user->save();

            // التحقق إذا كان هناك مزايدة معلقة
            if (session()->has('pending_bid')) {
                $pendingBid = session()->get('pending_bid');
                session()->forget('pending_bid');

                // إعادة تنفيذ طلب المزايدة
                return redirect()->route('auction.placeBid', [
                    'id' => $pendingBid['auction_id'],
                    'bid' => $pendingBid['bid'],
                ]);
            }

            // إعادة التوجيه عند النجاح
            session()->forget('required_amount');
            return redirect()->route('stripe.success')->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            Log::error('Stripe Payment Error: ' . $e->getMessage());

            // إعادة التوجيه عند الفشل
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }
}
