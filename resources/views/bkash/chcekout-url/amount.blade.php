@extends('layouts.bkash')

@section('content')
<div class="tw-min-w-screen tw-min-h-screen tw-flex tw-flex-col tw-justify-center tw-items-center tw-space-y-8">
    <img src="/images/myradar-logo-blue.png" alt="" class="tw-w-24 tw-h-auto tw-rounded tw-shadow-lg">
    <span class="tw-text-xl tw-text-slate-700 tw-font-semibold">myRADAR Bill Payment</span>
    <form action="/bkash/pay" method="POST" class="tw-w-10/12 md:tw-w-1/2 lg:tw-w-1/3" id="bkashForm">
        {!! csrf_field() !!}

        <div class="tw-w-full tw-flex tw-flex-col tw-items-center tw-space-y-4">
            <span class="tw-w-full tw-font-semibold tw-text-sm tw-text-gray-700 tw-mt-4">Total Due Bill :  {{ number_format($total_due_bill) }} TK</span>
        </div>
        <br>
        
        <div>
        <span class="tw-w-full tw-font-semibold tw-text-sm tw-text-gray-700">Car No Wise Due Bill</span>
       </div>
       <br>
        @foreach ($cars_bill_details as $car_bill_details)
        <div>
            <input type="checkbox" name="cars[]" value="{{ $car_bill_details['reg_no'] }}" checked>
            <label>{{ $car_bill_details['reg_no'] }}</label>
            <input type="number" name="{{$car_bill_details['reg_no']}}" value="{{ $car_bill_details['bill'] }}">
        </div>
        <br>
        @endforeach
        <br>
        <div class="tw-w-full tw-flex tw-flex-col tw-items-center tw-space-y-4">
            <button type="submit"
                class="tw-w-full tw-px-4 tw-py-2 tw-rounded tw-shadow tw-border-none tw-bg-indigo-500 hover:tw-bg-indigo-600 tw-transition tw-duration-300 tw-uppercase tw-text-white tw-text-sm tw-cursor-pointer">
                Continue
            </button>
        </div>
    </form>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

@endsection