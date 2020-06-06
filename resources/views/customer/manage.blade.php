@extends('layouts.new')

@push('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <style media="screen">
    .nopadding {
       padding-left: 0 !important;
       padding-right: 0 !important;
       margin: 0 !important;
    }
    .manage-panel {
        border: 1px solid rgb(226, 226, 226);
    }
    .manage-panel {
      margin-left: 0 !important;
      margin-right: 0 !important;
    }
  </style>
@endpush

@section('content')
  <div class="row row-eq-height manage-panel" id="app">
    <input type="hidden" name="user_id" value="{{$user->id}}">
    <sidebar></sidebar>
    <manage-content></manage-content>
  </div>
@endsection

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script src="{{ mix('js/customer/manage.js') }}"></script>
@endpush
