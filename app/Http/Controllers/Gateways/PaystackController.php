<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class PaystackController extends Controller
{
  public function paystackRedirect()
  {
    return view('gateways.paystack-redirect');
  }

  public function verifyTransaction(Request $request)
  {

    // formから来たデータの中身を確認
    // dd($request->all());

    // formからきたreferenceのデータを取得
    $reference = $request->reference;

    // config\paystack.phpからデータを取得している
    $secret_key = config('paystack.secret_key');

    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . $secret_key
    ])->get("https://api.paystack.co/transaction/verify/$reference");

    // $responseをjson_decode関数で配列にしている
    $response_body = json_decode($response);

    if ($response_body->status == true) {
      return 'Payment success';
    } else {
      return 'Payment fail';
    }
  }
}
