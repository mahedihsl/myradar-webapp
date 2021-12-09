<div
  class="tw-w-[80%] md:tw-w-[40%] lg:tw-w-[25%] tw-h-auto tw-fixed tw-top-1/2 tw-transform tw--translate-y-1/2 tw-z-[999] tw-transition-all tw-duration-500 tw-ease-out tw-right-full"
  :class="{'tw-translate-x-full': showOfferModal}">
  <div @click="showOfferModal = !showOfferModal" class="tw-cursor-pointer tw-absolute tw-left-full tw-top-10 tw-px-3 tw-py-2.5 tw-rounded-r tw-shadow tw-flex tw-flex-col tw-justify-center tw-items-center tw-z-[999] tw-gap-y-2" style="background: #3B3B98;">
    <img src="{{ asset('images/icon/giftbox.png') }}" alt=""
      class="tw-w-6 tw-h-6 animate__animated animate__tada animate__slow animate__infinite">
      <span class="tw-text-white tw-text-sm tw-font-bold">Offer</span>
  </div>
  <form action="/enroll/save" method="post" class="" @submit.prevent="registerToOffer">
    <input type="hidden" name="type" value="lucky_coupon_lead">
    <img src="{{ asset('images/promo/lucky_coupon_banner_v2.png') }}" alt="" class="tw-w-full tw-h-auto tw-rounded tw-shadow">
    <div class="tw-absolute tw-top-2 tw-right-2 tw-cursor-pointer" @click="showOfferModal = false">
      <span class="tw-text-gray-700 tw-text-opacity-50 tw-text-xl"><i class="fas fa-times-circle"></i></span>
    </div>
    <div
      class="tw-absolute tw-bottom-0 tw-w-full tw-h-32 md:tw-h-40 tw-flex tw-flex-col tw-justify-end tw-items-center tw-pb-[15%]">
      <div class="tw-shadow-lg tw-w-10/12 tw-flex tw-flex-row tw-justify-center tw-items-center"
        :class="{'tw-hidden': response.available}">
        <input type="text"
          class="form-control tw-border-0 tw-rounded-l-lg tw-rounded-r-none tw-h-12 tw-px-4 tw-flex-grow tw-text-sm tw-placeholder-gray-600 bangla"
          placeholder="মোবাইল নাম্বার" x-model="offerForm.phone">
        <button type="submit"
          class="btn btn-success tw-rounded-r-lg tw-rounded-l-none tw-h-12 tw-flex-shrink-0 tw-text-sm tw-px-5 bangla">
          <i class="fa fa-paper-plane"></i> রেজিস্টার
        </button>
      </div>

      <div class="tw-relative tw-shadow-lg tw-rounded-lg  tw-bg-white tw-w-3/4 tw-px-5 tw-py-3"
        x-show="response.available">
        <div class="tw-absolute tw-top-2 tw-right-2 tw-cursor-pointer"
          @click="response.available = false; offerForm.phone = ''">
          <span class="tw-text-gray-600 tw-text-opacity-50 tw-text-base"><i class="fas fa-times-circle"></i></span>
        </div>
        <p class="tw-text-sm tw-font-semibold tw-my-0 bangla"
          :class="{'tw-text-gray-700': response.success, 'tw-text-red-400': !response.success}"
          x-text="response.message">
        </p>
      </div>
    </div>
  </form>
</div>