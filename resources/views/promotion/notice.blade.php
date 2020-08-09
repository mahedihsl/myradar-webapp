@extends('layouts.new')

@push('style')
<style type="text/css">
  .alert-default {
    border-radius: 5px;
    border: 1px solid #eeeeee;
    background: white;
  }
</style>
@endpush

@section('title')
Due Bill SMS/Push Notice
@endsection

@section('content')
<div class="row" id="app">
  <div class="col-xs-12">
    @foreach ($counts as $via => $count)
    <div class="alert alert-default" role="alert">
      <p style="margin-bottom: 30px;">
        Pending <strong>{{ strtoupper($via) }}</strong> Notifications: <strong id="{{ $via }}-count">{{ $count }}</strong>
        <a href="/export/due/notice/{{ $via }}" class="btn btn-info pull-right export-button" data-via="{{ $via }}">
          <i class="fa fa-file-o"></i> Export
        </a>
        <button class="btn btn-success pull-right send-button" style="margin: 0 20px;" data-via="{{ $via }}">
          <i class="fa fa-paper-plane"></i> Start Sending
        </button>
      </p>
      <div class="progress">
        <div class="progress-bar progress-bar-success" id="progress-{{ $via }}" role="progressbar" aria-valuenow="0"
          aria-valuemin="0" aria-valuemax="100" style="width: 0%;" data-total="{{ $count }}">
          0%
        </div>
      </div>
    </div>
    @endforeach
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

    function startNoticeQueue(via) {
      $.post('/send/single/notice', {via}, function(data) {
        var progress = $('#progress-' + via)
        var count = parseInt(progress.data('total'))
        var done = count - data.remaining
        var percentage = Math.floor(done / count * 100)
        
        progress.attr('aria-valuenow', percentage)
        progress.css('width', percentage + '%')
        progress.text(percentage + '%')

        $('#' + via + '-count').text(data.remaining)
        if (data.remaining > 0) {
          startNoticeQueue(via)
        }
      })
    }

    $(function() {
      $('.btn-send').click(function() {
        var via = $(this).data('via');
        $('input[name="via"]').val(via);
        $('#notice-form').submit();
      })

      $('.send-button').click(function() {
        startNoticeQueue($(this).data('via'))
      })
    })
</script>
@endpush