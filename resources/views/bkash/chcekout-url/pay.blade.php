@extends('layouts.bkash')

@push('css')
<style type="text/css">
.loader,
.loader:after {
    border-radius: 50%;
    width: 10em;
    height: 10em;
}

.loader {
    margin: 60px auto;
    font-size: 10px;
    position: relative;
    text-indent: -9999em;
    border-top: 1.1em solid rgba(0, 168, 255, 0.2);
    border-right: 1.1em solid rgba(0, 168, 255, 0.2);
    border-bottom: 1.1em solid rgba(0, 168, 255, 0.2);
    border-left: 1.1em solid #00a8ff;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-animation: load8 1.1s infinite linear;
    animation: load8 1.1s infinite linear;
}

@-webkit-keyframes load8 {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@keyframes load8 {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
</style>
@endpush

@section('content')
<div class="tw-min-w-screen tw-min-h-screen tw-flex tw-flex-row tw-justify-center tw-items-center">
    <form action="/bkash/create" method="POST">
        {!! csrf_field() !!}
        <input type="hidden" id="amount" name="amount" value='{{ $amount }}'>
        <input type="hidden" id="car_wise_bill" name="car_wise_bill" value='{{ $car_wise_bill }}'>
        <button id="bKash_button" class="tw-hidden tw-cursor-pointer">
    </form>
    </button>

    <div class="tw-flex tw-flex-col tw-items-center tw-w-10/12 md:tw-w-1/2 lg:tw-w-1/3">
        <div
            class="tw-flex tw-w-full tw-flex-row tw-justify-between tw-items-center tw-py-3 tw-border-b tw-border-gray-300">
            <span class="tw-text-xl tw-text-gray-700 tw-font-medium">Selected Car No</span>
            <span class="tw-text-xl tw-text-gray-700 tw-font-semibold">{{ $selected_cars }}</span>
        </div>
        <div class="tw-flex tw-w-full tw-flex-row tw-justify-between tw-items-center tw-py-3 ">
            <span class="tw-text-xl tw-text-gray-700 tw-font-medium">Total Pay Amount</span>
            <span class="tw-text-xl tw-text-gray-700 tw-font-semibold">{{ number_format($amount) }}</span>
        </div>
        <img src="/images/bkash.jpg" alt="" class="tw-cursor-pointer tw-w-2/3" id="bkash_logo">
    </div>

    {{-- <div class="loader">Loading...</div> --}}
</div>

<script type="text/javascript">
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#bkash_logo').click(function() {
        $('#bKash_button').trigger('click')
    });
})
</script>
@endsection