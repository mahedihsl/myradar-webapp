@extends('layouts.new')

@push('style')
  <link rel="stylesheet" href="{{asset('vendors/buttons/buttons.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
@endpush

@section('content')
  <div id="app">
    <new-device></new-device>
    <recent-devices></recent-devices>
  </div>
@endsection

@push('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="https://unpkg.com/tippy.js/dist/tippy.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
  <script src="{{ mix('js/device/index.js') }}" charset="utf-8"></script>
@endpush
