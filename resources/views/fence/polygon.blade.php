@extends('layouts.new')

@section('title')
    Area Geofence
@endsection

@section('content')
<div class="row" id="app">
    <div class="col-md-12">
        <no-area-found></no-area-found>
    </div>
</div>
@endsection

@push('script')
<script src="{{ mix('js/fence/polygon.js') }}" charset="utf-8"></script>
@endpush