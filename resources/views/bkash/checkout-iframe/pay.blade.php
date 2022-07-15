@extends('layouts.bkash')

@push('js')
<script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
@endpush

@push('css')
<style type="text/css">
  .loader,
  .loader:after {
    border-radius: 50%;
    width: 10em;
    height: 10em;
  }

  .loader {
    margin: 60px auto;
    font-size: 10px;
    position: relative;
    text-indent: -9999em;
    border-top: 1.1em solid rgba(0, 168, 255, 0.2);
    border-right: 1.1em solid rgba(0, 168, 255, 0.2);
    border-bottom: 1.1em solid rgba(0, 168, 255, 0.2);
    border-left: 1.1em solid #00a8ff;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-animation: load8 1.1s infinite linear;
    animation: load8 1.1s infinite linear;
  }

  @-webkit-keyframes load8 {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }

  @keyframes load8 {
    0% {
      -webkit-transform: rotate(0deg);
      transform: rotate(0deg);
    }

    100% {
      -webkit-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
</style>
@endpush

@section('content')
<div class="tw-min-w-screen tw-min-h-screen tw-flex tw-flex-row tw-justify-center tw-items-center">
  <button id="bKash_button"
    class="tw-hidden tw-px-4 tw-py-2 tw-rounded tw-shadow tw-border-none tw-bg-indigo-500 hover:tw-bg-indigo-600 tw-transition tw-duration-300 tw-uppercase tw-text-white tw-text-sm tw-cursor-pointer">
    Pay Now
  </button>
  <div class="loader">Loading...</div>
</div>

<script type="text/javascript">
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    setTimeout(function() {
      // bkash.reconfigure({})
      $('#bKash_button').trigger('click')
    }, 3000);

    var paymentID = '';
    bKash.init({
      paymentMode: 'checkout', //fixed value ‘checkout’ 
      //paymentRequest format: {amount: AMOUNT, intent: INTENT} 
      //intent options 
      //1) ‘sale’ – immediate transaction (2 API calls) 
      //2) ‘authorization’ – deferred transaction (3 API calls) 
      paymentRequest: {
        amount: '{{ $amount }}', //max two decimal points allowed 
        intent: 'sale',
      },
      createRequest: function(request) { // request object is basically the paymentRequest object, automatically pushed by the script in createRequest method 
        $.ajax({
          url: '/checkout-iframe/create',
          type: 'POST',
          data: JSON.stringify({
            amount: '{{ $amount }}',
          }),
          contentType: 'application/json',
          success: function(data) {
            console.log('create payment data', JSON.stringify(data))
            // data = JSON.parse(data);
            if (data && data.paymentID != null) {
              paymentID = data.paymentID;
              bKash.create().onSuccess(data); // pass the whole response data in bKash.create().onSucess() method as a parameter 
            } else {
              bKash.create().onError();
            }
          },
          error: function(err) {
            console.log(err)
            bKash.create().onError();
          }
        });
      },
      executeRequestOnAuthorization: function() {
        $.ajax({
          url: '/checkout-iframe/execute',
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify({
            "paymentID": paymentID
          }),
          success: function(data) {
            // data = JSON.parse(data);
            if (data && data.paymentID != null) {
              window.location.href = "/checkout-iframe/success"; //Merchant’s success page 
            } else {
              bKash.execute().onError();
              var message = data.errorMessage || 'Payment Failed, Please Try Again'
              window.location.href = "/checkout-iframe/fail?message=" + encodeURIComponent(message); //Merchant’s fail page 
            }
          },
          error: function() {
            bKash.execute().onError();
          }
        });
      }
    });
  })
</script>
@endsection