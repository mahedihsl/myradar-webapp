@extends('layouts.new')

@section('title')
Campaign Leads
@endsection

@section('content')
<div class="tw-w-full tw-flex tw-flex-col tw-gap-y-5">
  <form action="/leads" method="get" class="tw-w-full tw-flex tw-flex-row tw-items-center tw-gap-x-4">
    <select name="type" class="tw-w-1/4 form-control">
      <option value="">Select Type</option>
      <option value="demo_user_lead" {{ $type == 'demo_user_lead' ? 'selected' : '' }}>Android demo user lead</option>
      <option value="lucky_coupon_lead" {{ $type == 'lucky_coupon_lead' ? 'selected' : '' }}>Lucky coupon lead</option>
      <option value="message_lead" {{ $type == 'message_lead' ? 'selected' : '' }}>Web message lead</option>
      <option value="hsl_message" {{ $type == 'hsl_message' ? 'selected' : '' }}>HSL website message</option>
    </select>
    <button type="submit" class="btn btn-primary">
      <i class="fa fa-search"></i> Filter
    </button>
  </form>
  @foreach ($leads as $lead)
  @include('promotion.lead-box', ['lead' => $lead])
  @endforeach

  {!! $leads->links() !!}
</div>
@endsection

@push('script')

@endpush