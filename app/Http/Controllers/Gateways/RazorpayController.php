<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Razorpay\Api\Api;

class RazorpayController extends Controller
{
  public function payment(Request $request)
  {

    // config関数で、config\razorpay.phpで記載したkeyとsecretを呼び出している
    $api = new Api(config('razorpay.key'), config('razorpay.secret'));

    // fetchメソッドで、非同期で外部のリソースを取得している
    $payment = $api->payment->fetch($request->razorpay_payment_id);

    if ($request->has('razorpay_payment_id') && $request->filled('razorpay_payment_id')) {
      try {

        // formからわたってきたrazorpay_payment_idをfetch関数で取得
        $response = $api->payment->fetch($request->razorpay_payment_id)
          ->capture(['amount' => $payment['amount']]);
      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    // dd($response);

    // 処理が成功した際の処理
    if ($response['status'] == 'captured') {
      return 'Payment Success!';
    }
  }
}
