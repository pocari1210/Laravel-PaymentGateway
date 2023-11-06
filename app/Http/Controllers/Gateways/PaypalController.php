<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
  public function payment(Request $request)
  {

    $provider = new PayPalClient;

    $provider->setApiCredentials(config('paypal'));

    $paypalToken = $provider->getAccessToken();

    $response = $provider->createOrder([
      "intent" => "CAPTURE",
      "application_context" => [
        "return_url" => route('paypal.success'),
        "cancel_url" => route('paypal.cancel'),
      ],
      "purchase_units" => [
        [
          "amount" => [
            // 通貨を選択する
            "currency_code" => "USD",

            // formタグ内に記載したinputタグのデータを受け取る
            "value" => $request->price
          ]
        ]
      ]
    ]);

    // dd($response);

    // idがあり、且つNull出ない場合の処理
    if (isset($response['id']) && $response['id'] != null) {

      // $responseのlinksのデータを$linkとし、foreachで出力
      foreach ($response['links'] as $link) {

        if ($link['rel'] === 'approve') {
          return redirect()->away($link['href']);
        }
      }

      // 承認された値がない場合の処理
      // paypal.cancelにリダイレクトさせる
    } else {
      return redirect()->route('paypal.cancel');
    }
  }

  public function success(Request $request)
  {
    $provider = new PayPalClient;

    $provider->setApiCredentials(config('paypal'));

    $paypalToken = $provider->getAccessToken();

    $response = $provider->capturePaymentOrder($request->token);

    if (isset($response['status']) && $response['status'] == 'COMPLETED') {
      return 'Paid Successfully!';
    }

    return redirect()->route('paypal.cancel');
  }

  public function cancel()
  {
    return 'Paymnet faild';
  }
}
