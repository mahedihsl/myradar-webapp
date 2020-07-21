@extends('layouts.new')

@section('title')
Due Bill SMS Notice
@endsection

@section('content')
<div class="row" id="app">
  <div class="col-xs-12">
    @if ($count > 0)
    <div class="alert alert-success" role="alert">
      Sending <strong>{{ $count }}</strong> Notices via <strong>{{ strtoupper($via) }}</strong>
    </div>
    <div class="progress">
      <div class="progress-bar progress-bar-success" id="progress" role="progressbar" aria-valuenow="60"
        aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
        0%
      </div>
    </div>
    @endif
    <input type="hidden" value="{{ $count }}" name="count" />
    <input type="hidden" value="{{ $via }}" name="via" />
  </div>
  <div class="col-xs-12">
    <form class="form" action="/send/due/notice" method="post" id="notice-form">
      {!! csrf_field() !!}
      <input type="hidden" name="via" value="" />
      <div class="col-xs-6">
        <div class="form-group">
          <label>Select Month</label>
          <select class="form-control" name="month">
            @foreach ($months as $key => $month)
            <option value="{{$month['value']}}">{{$month['label']}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-xs-6"></div>
      <div class="col-xs-12">
        <div class="form-group">
          <label for="">Message</label>
          <textarea name="message" rows="8" class="form-control" placeholder="Write SMS Content Here"></textarea>
        </div>
        <button class="btn btn-success btn-send" type="button" data-via="sms">
          <i class="fa fa-paper-plane"></i> SEND SMS
        </button>
        <button class="btn btn-primary btn-send" type="button" data-via="push">
          <i class="fa fa-bell"></i> SEND PUSH
        </button>
      </div>
    </form>
  </div>
  <div class="col-xs-12">
    <h4>Notice History</h4>
    @foreach ($history as $key => $notice)
    <div class="col-xs-12">
      <strong><small>{{ $notice->created_at->toDayDateTimeString() }}</small></strong><br>
      <p>{{ $notice->message }}</p>
    </div>
    @endforeach
  </div>
</div>
@endsection

@push('script')
<script src="{{mix('js/customer/promotion/index.js')}}"></script>
<script type="text/javascript">
    var count;

    function sendSingleNotice() {
      var via = $('input[name="via"]').val()
      $.post('/send/single/notice', {via: via}, function(data) {
        // console.log(`response`, data)
        var done = count - data.remaining
        var percentage = Math.floor(done / count * 100)
        // console.log(`percentage progress`, percentage)
        
        $('#progress').attr('aria-valuenow', percentage)
        $('#progress').css('width', percentage + '%')
        $('#progress').text(percentage + '%')
        if (data.remaining > 0) {
          sendSingleNotice()
        }
      })
    }

    $(function() {
      $('.btn-send').click(function() {
        var via = $(this).data('via');
        $('input[name="via"]').val(via);
        $('#notice-form').submit();
      })

      count = parseInt($('input[name="count"]').val());
      if (count > 0) {
        sendSingleNotice();
      }
    })
</script>
@endpush