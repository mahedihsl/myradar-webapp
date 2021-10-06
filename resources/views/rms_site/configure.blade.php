@extends('layouts.new')

@push('style')

@endpush

@section('title')

@endsection

@section('action')

@endsection

@section('content')
<input type="hidden" value="{{ $site_id }}" name="site_id" id="site_id" />
<div class="tw-w-full" id="app">
    <div class="tw-w-full tw-flex tw-flex-col" v-if="!!site">
        <div class="tw-w-full tw-border-b tw-border-gray-300" v-for="(dev, i) in site.com_ids" :key="i">
            <h4>Device Com. ID: @{{ dev }}</h4>
            <div class="tw-w-full tw-flex tw-flex-col tw-gap-y-3">
                <pin-config v-for="(conf, j) in pinConfigsOfDevice(dev)" :key="j" :config="conf" />
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('js/rms/configure.js', true) }}" charset="utf-8"></script>
@endpush