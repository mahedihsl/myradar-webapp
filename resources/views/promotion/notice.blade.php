@extends('layouts.new')

@section('title')
  Due Bill SMS Notice
@endsection

@section('content')
  <div class="row" id="app">
    <div class="col-xs-12">
      @if ($status == 1)
        <div class="alert alert-success" role="alert">Success ! {{$count}} SMS will be delivered within a few minutes</div>
      @elseif ($status == 0)
        <div class="alert alert-danger" role="alert">Error ! SMS Sending Failed. Something went wrong</div>
      @endif
    </div>
    <div class="col-xs-12">
      <form class="form" action="/send/due/notice" method="post">
        {!! csrf_field() !!}
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
          <button class="btn btn-success" type="submit">
            <i class="fa fa-paper-plane"></i> SEND
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
@endpush
