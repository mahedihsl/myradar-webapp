<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Failed</title>
    <style>
    .center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
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
         @if(isset($response))
         <h1>
           {{ $response }}
         </h1>
        @endif
 </div>

 <div class="center">
  <button onclick="location.href = '/bkash/pay';" id="pay" >Pay Now</button>
</div>
 
</body>
</html>