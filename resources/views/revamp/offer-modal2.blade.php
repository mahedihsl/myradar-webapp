<!-- Modal -->
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="tw-fixed tw-z-[999] tw-inset-0 tw-overflow-y-auto" :class="{'tw-hidden': !showOfferModal}"
  x-show="showOfferModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak x-transition>
  <div
    class="tw-flex tw-items-center tw-justify-center tw-min-h-screen tw-pt-4 tw-px-4 tw-pb-20 tw-text-center sm:tw-block sm:tw-p-0">
    <!--
      Background overlay, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div class="tw-fixed tw-inset-0 tw-bg-gray-500 tw-bg-opacity-75 tw-transition-opacity" aria-hidden="true"></div>

    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="tw-hidden sm:tw-inline-block sm:tw-align-middle sm:tw-h-screen" aria-hidden="true">&#8203;</span>

    <!--
      Modal panel, show/hide based on modal state.

      Entering: "ease-out duration-300"
        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        To: "opacity-100 translate-y-0 sm:scale-100"
      Leaving: "ease-in duration-200"
        From: "opacity-100 translate-y-0 sm:scale-100"
        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    -->

    <div
      class="tw-inline-block tw-align-bottom tw-bg-transparent tw-rounded-lg tw-overflow-hidden tw-text-left tw-overflow-hidden tw-shadow-xl tw-transform tw-transition-all sm:tw-mt-2 sm:tw-align-middle">
      <form action="/enroll/save" method="post" class="tw-w-auto tw-relative" @submit.prevent="registerToOffer">
        <input type="hidden" name="type" value="lucky_coupon_lead">
        <img src="{{ asset('images/promo/lucky_coupon_banner_v2.png') }}" alt="" class="tw-w-full tw-h-auto md:tw-w-auto md:tw-h-[85vh] tw-object-cover">
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

          <div class="tw-relative tw-shadow-lg tw-rounded-lg  tw-bg-white tw-w-3/4 tw-px-5 tw-py-3" x-show="response.available">
            <div class="tw-absolute tw-top-2 tw-right-2 tw-cursor-pointer" @click="response.available = false; offerForm.phone = ''">
              <span class="tw-text-gray-600 tw-text-opacity-50 tw-text-base"><i class="fas fa-times-circle"></i></span>
            </div>
            <p class="tw-text-sm tw-font-semibold tw-my-0 bangla"
              :class="{'tw-text-gray-700': response.success, 'tw-text-red-400': !response.success}"
              x-text="response.message"></p>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>