<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Success</title>
    <style>
     .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
      }

      .right{
        display: flex;
        justify-content: right;
        align-items: right;
        height: 100px;
      }

    #logout {
        text-align: right;
        background-color: red;
        border: none;
        color: white;
        padding: 15px 32px;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
      }
      #pay {
        text-align: right;
        background-color: blue;
        border: none;
        color: white;
        padding: 15px 32px;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
      }

    </style>
</head>
<body>

<div class="center">

<h1>Your payment has been successfully done.</h1>
<br>
<br>
    
  <h2>
  @if(isset($response))
    Your TrxID: {{ $response }}
  @endif
  </h2>

 </div>


 <div class="center">
  <button onclick="location.href = '/bkash/pay';" id="pay" >Pay Now</button>
</div>


</body>
</html>