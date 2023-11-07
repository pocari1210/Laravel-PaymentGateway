<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gateways\PaypalController;
use App\Http\Controllers\Gateways\RazorpayController;

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
