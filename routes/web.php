<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gateways\PaypalController;
use App\Http\Controllers\Gateways\RazorpayController;
use App\Http\Controllers\Gateways\MollieController;
use App\Http\Controllers\Gateways\PaystackController;
use App\Http\Controllers\Gateways\TwoCheckoutController;
use App\Http\Controllers\SslCommerzPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

// paypal決済
Route::post('paypal/payment', [PaypalController::class, 'payment'])
  ->name('paypal.payment');

Route::get('paypal/success', [PaypalController::class, 'success'])
  ->name('paypal.success');

Route::get('paypal/cancel', [PaypalController::class, 'cancel'])
  ->name('paypal.cancel');

// razorpay決済
Route::post('razorpay/payment', [RazorpayController::class, 'payment'])
  ->name('razorpay.payment');

// mollie決済
Route::post('mollie/payment', [MollieController::class, 'payment'])
  ->name('mollie.payment');

Route::get('mollie/success', [MollieController::class, 'success'])
  ->name('mollie.success');

// paystack決済
Route::get('paystack/redirect', [PaystackController::class, 'paystackRedirect'])
  ->name('paystack.redirect');

Route::get('paystack/callback', [PaystackController::class, 'verifyTransaction'])
  ->name('paystack.callback');


// SslCommerzPayment決済

// SSLCOMMERZ Start
Route::post('/pay', [SslCommerzPaymentController::class, 'index'])
  ->name('sslcommerz.pay');

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
//SSLCOMMERZ END

// 2checkout決済
Route::get('twocheckout/payment', [TwoCheckoutController::class, 'showFrom'])
  ->name('twocheckout.payment');

Route::post('twocheckout/handle-payment', [TwoCheckoutController::class, 'handlePayment'])
  ->name('twocheckout.handle-payment');

Route::get('twocheckout/success', [TwoCheckoutController::class, 'success'])
  ->name('twocheckout.success');
