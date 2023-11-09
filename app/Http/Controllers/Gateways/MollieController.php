<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Mollie\Laravel\Facades\Mollie;

class MollieController extends Controller
{
  public function payment(Request $request)
  {

    // formからきたtokenとpriceの中身を確認できる
    // dd($request->all());

    $payment = Mollie::api()->payments->create([
      "amount" => [

        // 通貨の設定(デフォルトでユーロ)
        "currency" => "EUR",

        // 第一引数のformからきたpriceを設定
        "value" =>  number_format($request->price, 2, '.', '') // You must send the correct number of decimals, thus we enforce the use of strings
      ],
      "description" => "Order #12345",

      // 処理が成功した後のリダイレクト先のURLを記述
      "redirectUrl" => route('mollie.success'),

      // "webhookUrl" => route('webhooks.mollie'),

      // metadataの配列の中に注文されたid情報を記述されている
      "metadata" => [
        "order_id" => "12345",
      ],
    ]);

    // dd($payment);

    // 第二引数のformからきた$payment->idを
    // 第一引数のmollie_idの変数に格納している
    session()->put('mollie_id', $payment->id);

    // redirect customer to Mollie checkout page
    return redirect($payment->getCheckoutUrl(), 303);
  }

  public function success(Request $request)
  {
    $paymentId = session()->get('mollie_id');
    $payment = Mollie::api()->payments->get($paymentId);

    // statusがpaidになっていたらOK
    // dd($payment);

    // 処理の結果
    if ($payment->isPaid()) {
      return 'payment success';
    } else {
      return 'Payment not completed';
    }
  }
}
