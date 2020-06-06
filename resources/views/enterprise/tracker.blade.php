@extends('layouts.new')

@section('title')
  Text Tracker
@endsection

@section('content')
  <div  id="app">
      <input type="hidden" name="user_id" value="{{$userId}}">
      <component :is="current" v-bind="props"></component>
  </div>
@endsection
@push('script')
  <script src="{{ mix('js/enterprise/tracker.js') }}" charset="utf-8"></script>
@endpush
