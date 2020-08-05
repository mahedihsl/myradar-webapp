@extends('layouts.new')

@push('style')
    <style type="text/css">
        #common-map {
            width: 100%;
            min-height: 450px;
        }

        .info-panel {
            position: absolute;
            width: 30%;
            height: 100%;
            right: 0;
            top: 0;
            background: white;

            -webkit-box-shadow: -15px 0px 20px -10px rgba(176,176,176,1);
            -moz-box-shadow: -15px 0px 20px -10px rgba(176,176,176,1);
            box-shadow: -15px 0px 20px -10px rgba(176,176,176,1);
        }

        .info-header {
            position: relative;
            border-bottom: 1px solid #eeeeee;
            padding: 15px;
        }
        .info-header h4 {
            margin: 5px 0;
            font-size: 1.5rem;
            color: #212121;
        }

        .info-actions {
            padding: 15px 0;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }

        .info-actions > .btn {
            width: 35%;
        }
        
        .close-round {
            position: absolute;
            top: 15px;
            right: 15px;

            font-size: 1.15rem;
            color: #424242;
            background: #f5f5f5;
            transition: all 0.2s ease-in;

            border-radius: 50px;
            width: 30px;
            height: 30px;

            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .close-round:hover {
            background: #e0e0e0;
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
                <div style="position: relative; padding-left: 0; padding-right: 0;">
                    <div id="common-map"></div>
                    <div class="info-panel">
                        <div class="info-header">
                            <h4>Geofence Details</h4>
                        </div>
                        <span class="close-round">
                            <i class="fa fa-times"></i>
                        </span>
                        <div class="info-actions">
                            <button class="btn btn-info">
                                <i class="fa fa-pencil"></i> Edit
                            </button>
                            <button class="btn btn-danger">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </div>

                    </div>
                </div>
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