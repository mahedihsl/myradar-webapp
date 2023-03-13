@extends('layouts.bkash')

@section('content')
<div class="tw-min-w-screen tw-min-h-screen tw-flex tw-flex-col tw-justify-center tw-items-center tw-space-y-8">
    <img src="/images/myradar-logo-blue.png" alt="" class="tw-w-24 tw-h-auto tw-rounded tw-shadow-lg">
    <span class="tw-text-xl tw-text-slate-700 tw-font-semibold">myRADAR Bill Payment</span>
    <form action="/bkash/pay" method="POST" class="tw-w-10/12 md:tw-w-1/2 lg:tw-w-1/3" id="bkashForm">
        {!! csrf_field() !!}

        <span class="tw-w-full tw-font-semibold tw-text-sm tw-text-gray-700">Car Number</span>
        @foreach ($cars_list as $car)
        <div>
            <input type="checkbox" name="cars[]" value="{{ $car }}" checked>
            <label>{{ $car }}</label>
        </div>
        @endforeach

        <div class="tw-w-full tw-flex tw-flex-col tw-items-center tw-space-y-4">
            <span class="tw-w-full tw-font-semibold tw-text-sm tw-text-gray-700 tw-mt-4">BDT Amount</span>
            <input type="number"
                class="tw-w-full tw-border tw-border-solid tw-border-slate-200 tw-rounded tw-shadow-sm tw-px-4 tw-py-2 tw-text-sm tw-font-medium"
                placeholder="Ex: 400" name="amount" id="amount" value='{{ $due_bill }}'>
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

<script type="text/javascript">
$(document).ready(function() {
    $('#bkashForm').submit(function(event) {
        // Prevent the form from submitting normally
        event.preventDefault();

        // Validate the form
        if (validateForm()) {
            // If the form is valid, submit it
            this.submit();
        }
    });
});

function validateForm() {
    // Get the values of the form fields
    var amount = $('#amount').val();

    // Check if the fields are empty
    if (!amount) {
        alert('Please enter amount');
        return false;
    }
    // If all checks pass, return true
    return true;
}
</script>

@endsection