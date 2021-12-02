<div
  class="tw-rounded-lg tw-w-full tw-flex tw-flex-row tw-justify-between tw-items-start tw-px-8 tw-py-5 tw-bg-gray-100">
  <div class="tw-flex tw-flex-col tw-gap-y-2">
    <span class="tw-text-gray-700 tw-font-semibold tw-text-2xl">{{ $lead->name }}</span>
    <div class="tw-flex tw-flex-row tw-gap-x-8">
      <span class="tw-text-gray-700 tw-text-2xl tw-font-medium">
        <i class="fa fa-phone"></i> {{ $lead->phone or '--' }}
      </span>
      <span class="tw-text-gray-700 tw-text-2xl tw-font-medium">
        <i class="fa fa-envelope"></i> {{ $lead->email or '--' }}
      </span>
    </div>
    <p class="tw-text-2xl tw-text-gray-600 tw-font-normal tw-mt-2">
      {{ $lead->message or '--' }}
    </p>
  </div>

  <div class="tw-flex tw-flex-col tw-gap-y-2">
    <span class="tw-text-gray-700 tw-text-xl tw-font-medium">
      <i class="fa fa-calendar"></i> {{ $lead->created_at->toDayDateTimeString() }}
    </span>
    <span class="tw-text-gray-700 tw-text-xl tw-font-semibold">
      <i class="fa fa-certificate"></i> {{ $lead->type or 'general_lead' }}
    </span>
    @if ($lead->type == 'lucky_coupon_lead')
    <span class="tw-text-gray-700 tw-text-xl tw-font-semibold">
      <i class="fa fa-gift"></i>
      Code - {{ $lead->meta['code'] }}
      ({{ $lead->meta['discount'] }}% Discount)
      @if ($lead->meta['notified'])
      <span class="tw-text-green-500"><i class="fa fa-check"></i> SMS SENT</span>
      @endif
    </span>
    @elseif($lead->type == 'demo_user_lead')
    <span class="tw-text-gray-700 tw-text-xl tw-font-semibold">
      <i class="fa fa-key"></i>
      OTP: {{ $lead->meta['otp'] }}
    </span>
    @endif
  </div>
</div>