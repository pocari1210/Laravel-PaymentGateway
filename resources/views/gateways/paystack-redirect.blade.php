<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Paystack payment</title>
</head>

<body>

  <script src="https://js.paystack.co/v1/inline.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      payWithPaystack();
    });

    function payWithPaystack() {

      let handler = PaystackPop.setup({

        // config\paystack.phpから読み込んでいる
        key: "{{config('paystack.public_key')}}", // Replace with your public key

        email: 'user@gmail.com',

        amount: '4000',

        // ガーナの通貨を設定
        currency: 'GHS',

        onClose: function() {

          alert('Window closed.');

        },

        callback: function(response) {

          // redirecturlの中身は、dashboardで設定した
          // 「Test callback URLを指す」
          // console.log(response)

          // dashboardで設定した「Test callback URL」のページに遷移
          window.location.href = response.redirecturl
        }

      });


      handler.openIframe();

    }
  </script>
</body>

</html>