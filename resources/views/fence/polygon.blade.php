@extends('layouts.new')

@push('style')
    <style type="text/css">
        #common-map {
            width: 100%;
            min-height: 450px;
        }
    </style>
@endpush

@section('title')
    Area Geofence
@endsection

@section('content')
<div class="row" id="app">
    <modal name="area-builder" width="50%" height="auto" draggable="#builder-header">
        <area-builder @cancel="closeAreaBuilder"></area-builder>
    </modal>
    <div class="col-md-12" v-if="!geofences.length">
        <no-area-found @create="showAreaBuilder"></no-area-found>
    </div>
    <div class="col-md-12" v-show="geofences.length">
        <div class="row row-eq-height">
            <div class="col-md-3">
                <area-list :items="geofences" @item-click="onGeofenceClick" @create="showAreaBuilder"></area-list>
            </div>
            <div class="col-md-9">
                <div id="common-map"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAf9yCy5ZZ6iEo0EyOWjUg4EpUHIeuZVWQ&libraries=geometry">
</script>
<script src="{{ mix('js/fence/polygon.js') }}" charset="utf-8"></script>
@endpush