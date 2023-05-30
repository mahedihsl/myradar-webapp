<form class="" action="{{ route('bkash-webhook-view') }}" method="get">
    <div class="row">
       
   
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="wallet" class="form-control" placeholder="bKash Wallet No" value="{{$data['debitMSISDN'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <input type="text" name="trxID" class="form-control" placeholder="bKash trxID" value="{{$data['trxID'] or ''}}">
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-sm-2">
            <input type="submit" class="btn btn-sm btn-primary" name="type" value="search" />
        </div>
    </div>
</form>
