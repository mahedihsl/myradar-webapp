@extends('layouts.new')

@section('content')
  <div class="row" id="app">
    <div class="col-xs-12 table-responsive">
      <car-list></car-list>
    </div>
  </div>
@endsection

@push('script')
<script src="{{ mix('js/car/index.js') }}"></script>
@endpush
