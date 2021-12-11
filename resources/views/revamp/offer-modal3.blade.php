<div
  class="tw-w-[80%] md:tw-w-[40%] lg:tw-w-[25%] tw-h-auto tw-fixed tw-top-full tw-left-1/2 md:tw-left-auto md:tw-top-1/2 md:tw-right-full tw-transform tw--translate-x-1/2 md:tw--translate-x-0 md:tw--translate-y-1/2 tw-z-[999] tw-transition-all tw-duration-500 tw-ease-out"
  :class="{'tw--translate-y-full md:tw-translate-x-full': showOfferModal}">
  {{-- <div class="tw-h-screen tw-w-screen tw-bg-gray-800/20"></div> --}}
  <div @click="showOfferModal = !showOfferModal"
    class="tw-flex tw-flex-row md:tw-flex-col tw-justify-start tw-items-center tw-px-5 tw-py-3 md:tw-px-3 md:tw-py-5 tw-absolute tw-transform tw-bottom-full tw-left-1/2 tw--translate-x-1/2 md:tw-bottom-auto md:tw-left-full md:tw-top-1/2 md:tw-translate-x-0 md:tw--translate-y-1/2 tw-h-[75px] tw-w-auto md:tw-w-[100px] md:tw-h-auto tw-py-2.5 tw-rounded-t-md md:tw-rounded-l-none md:tw-rounded-r-md tw-shadow tw-z-[999] tw-bg-[#ffd32a] hover:tw-bg-[#ffc800] tw-transition tw-duration-300 tw-cursor-pointer tw-transition-all tw-duration-500 tw-ease-out"
    :class="{'tw-opacity-0': showOfferModal}">
    <span class="tw-text-xl tw-gray-700 tw-font-bold bangla tw-text-center tw-my-0 md:tw--mb-2">বিজয়</span>

    <img src="{{ asset('images/promo/victory.png') }}" alt=""
      class="tw-h-full tw-h-auto md:tw-w-full md:tw-h-auto tw-my-3 md:tw-my-0 md:tw-mx-3">
    <span class="tw-text-base tw-gray-600 tw-font-bold bangla tw-text-center">দিবস</span>

    <img src="{{ asset('images/promo/offer1.png') }}" alt=""
      class="tw-h-full tw-h-auto md:tw-w-full md:tw-h-auto tw-mx-6 tw-my-3 md:tw-my-6 md:tw-mx-3 animate__animated animate__tada animate__slow animate__infinite">
  </div>
  <form action="/enroll/save" method="post" class="" @submit.prevent="registerToOffer">
    <input type="hidden" name="type" value="lucky_coupon_lead">
    <img src="{{ asset('images/promo/lucky_coupon_banner_v2.png') }}" alt=""
      class="tw-w-full tw-h-auto tw-rounded tw-shadow">
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