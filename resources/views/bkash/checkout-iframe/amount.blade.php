@extends('layouts.bkash')

@section('content')
<div class="tw-min-w-screen tw-min-h-screen tw-flex tw-flex-col tw-justify-center tw-items-center tw-space-y-8">
  <img src="/images/myradar-logo-blue.png" alt="" class="tw-w-24 tw-h-auto tw-rounded tw-shadow-lg">
  <span class="tw-text-xl tw-text-slate-700 tw-font-semibold">myRADAR Bill Payment</span>
  <form action="/checkout-iframe/pay" method="POST">
    {!! csrf_field() !!}
    <div class="tw-flex tw-space-x-4">
      <div class="tw-relative">
        <input type="number"
          class="tw-border tw-border-solid tw-border-slate-200 tw-rounded tw-shadow-sm tw-pl-14 tw-pr-4 tw-py-2 tw-text-sm tw-font-semibold"
          value="20" name="amount">
        <span class="tw-absolute tw-left-4 tw-top-1/2 tw-transform tw--translate-y-1/2 tw-font-semibold tw-text-sm tw-text-gray-500">BDT</span>
      </div>
      <button type="submit"
        class="tw-px-4 tw-py-2 tw-rounded tw-shadow tw-border-none tw-bg-indigo-500 hover:tw-bg-indigo-600 tw-transition tw-duration-300 tw-uppercase tw-text-white tw-text-sm tw-cursor-pointer">Continue</button>
    </div>
  </form>
</div>
@endsection