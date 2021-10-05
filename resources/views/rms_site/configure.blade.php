@extends('layouts.new')

@push('style')

@endpush

@section('title')

@endsection

@section('action')

@endsection

@section('content')
<input type="hidden" value="{{ $site_id }}" name="site_id" id="site_id" />
<div class="row" id="app">
    <div class="col-xs-12" v-if="!!site">
        <div class="col-xs-12" v-for="(dev, i) in site.com_ids" :key="i" style="border-bottom: 1px solid #e0e0e0;">
            <h4>Device Com. ID: @{{ dev }}</h4>
            <pin-config v-for="(conf, j) in pinConfigsOfDevice(dev)" :key="j" />
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('js/rms/configure.js', true) }}" charset="utf-8"></script>
@endpush