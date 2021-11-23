@extends('layouts.new')

@section('title')
Campaign Leads
@endsection

@section('content')
<div class="tw-w-full tw-flex tw-flex-col tw-gap-y-5">
  <form action="/leads" method="get" class="tw-w-full tw-flex tw-flex-row tw-items-center tw-gap-x-4">
    <select name="type" class="tw-w-1/4 form-control">
      <option value="">Select Type</option>
      <option value="lucky_coupon_lead">Lucky Coupon Lead</option>
      <option value="message_lead">Message Lead</option>
      <option value="general_lead">General Lead</option>
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