@extends('layouts.app')

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">{{ $user->name }}</h3>
                  <h5 class="panel-subtitle">RMS Site Management</h5>
              </div>
              <div class="panel-body">
                  <div class="row row-eq-height">
                      <div class="col-md-10 col-md-offset-1">
                          
                      </div>
                  </div>
              </div>
              <div class="panel-footer">

              </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{ asset('js/rms/index.js', true) }}" charset="utf-8"></script>
@endsection
