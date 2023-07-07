<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Omnipay\Common\GatewayInterface;
use Omnipay\Omnipay;
use Throwable;

class PayPalController extends Controller
{
    private GatewayInterface $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(env('PAYPAL_SANDBOX'));
    }

    public function index()
    {
        return Inertia::render('Payments/PayPal');
    }

    public function pay(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:'.round(convertCurrency(1, 'USD', 'UAH')),
        ], [], [
            'amount' => trans('global.amount'),
        ]);

        try {
            $response = $this->gateway->purchase([
                'amount' => round(convertCurrency($request->amount, 'UAH', 'USD'), 2),
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('payments/paypal/success'),
                'cancelUrl' => url('payments/paypal/error'),
            ])->send();

            if ($response->isRedirect()) {
                Payment::create([
                    'amount' => $request->amount,
                    'currency' => env('PAYPAL_CURRENCY'),
                    'payment_status' => false,
                    'payment_id' => $response->getTransactionReference(),
                    'user_id' => Auth::id(),
                ]);
                $redirectUrl = $response->getRedirectUrl();

                return Inertia::location($redirectUrl);
            } else {
                Log::debug($response->getMessage());

                return redirect()->route('payments.fail');
            }

        } catch (Throwable $th) {
            Log::debug($th->getMessage());
        }
    }

    public function success(Request $request)
    {
        try {
            $transaction = $this->gateway->completePurchase([
                'payer_id' => $request->PayerID,
                'transactionReference' => $request->paymentId,
            ])->send();

            $payment = Payment::where('payment_id', $request->paymentId)->first();
            $arr = $transaction->getData();

            if ($transaction->isSuccessful() && ! $payment->payment_status) {
                $payment->update([
                    'payment_status' => true,
                    'payer_email' => $arr['payer']['payer_info']['email'],
                ]);
                //Increase user balance after successful payment
                $user = Auth::user();
                $user->balance += $payment->amount;
                $user->save();

                return redirect()->route('payments.success');

            }

            return redirect()->route('payments.fail');

        } catch (Throwable $th) {
            Log::debug($th->getMessage());
        }

    }

    public function error()
    {
        return Inertia::render('Payments/Fail');
    }
}
