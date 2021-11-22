<!-- Modal -->
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="tw-fixed tw-z-[999] tw-inset-0 tw-overflow-y-auto tw-hidden" id="offer-modal" aria-labelledby="modal-title"
  role="dialog" aria-modal="true">
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
      class="tw-inline-block tw-align-bottom tw-bg-white tw-rounded-lg tw-text-left tw-overflow-hidden tw-shadow-xl tw-transform tw-transition-all sm:tw-mt-2 sm:tw-align-middle sm:tw-max-w-lg sm:tw-w-full">
      <form action="/enroll/save" method="post" class=" tw-w-full">
        {!! csrf_field() !!}
        <div class="tw-bg-white tw-px-4 tw-pt-5 tw-pb-4 sm:tw-p-6 sm:tw-pb-4">
          <div class="tw-flex tw-flex-col tw-items-center">
            <div
              class="tw-mx-auto tw-flex-shrink-0 tw-flex tw-items-center tw-justify-center tw-h-12 tw-w-12 tw-rounded-full tw-bg-purple-600 sm:tw-mx-0">
              <img src="{{ asset('images/icon/giftbox.png') }}" alt="" class="tw-w-6 tw-h-6">
            </div>
            <div class="tw-mt-3 tw-text-center tw-mt-3 tw-text-center">
              <h2 class="tw-text-red-500 tw-font-bold tw-text-lg tw-leading-6" id="modal-title">
                Lucky Coupon
              </h2>
              <div class="tw-mt-2">
                <p class="tw-text-base tw-font-noraml">
                  <span class="tw-text-red-400">Register now to get upto 100% discount</span> <br>
                  <span class="tw-text-sm tw-text-gray-700">Draw in 1 Hour</span>
                </p>

                <input type="hidden" name="type" value="offer_lead">
                <div class="row gy-4">

                  <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Your Name">
                  </div>

                  <div class="col-md-6 ">
                    <input type="text" class="form-control" name="phone" placeholder="Your Phone Number" required>
                    @if ($errors->has('phone'))
                    <span class="help-block">
                      <div class="">{{ $errors->first('phone') }}</div>
                    </span>
                    @endif
                  </div>

                  <div class="col-md-12">
                    <textarea class="form-control" name="message" rows="3" placeholder="Message"></textarea>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="tw-bg-gray-50 tw-px-4 tw-py-3 sm:tw-px-6 sm:tw-flex sm:tw-flex-row-reverse">
          <button type="submit"
            class="tw-w-full tw-inline-flex tw-justify-center tw-rounded-md tw-border tw-border-transparent tw-shadow-sm tw-px-4 tw-py-2 tw-bg-green-600 tw-text-base tw-font-medium tw-text-white hover:tw-bg-green-700 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-red-500 sm:tw-ml-3 sm:tw-w-auto sm:tw-text-sm">
            Register
          </button>
          <button type="button" id="offer-close"
            class="tw-mt-3 tw-w-full tw-inline-flex tw-justify-center tw-rounded-md tw-border tw-border-gray-200 tw-shadow-sm tw-px-4 tw-py-2 tw-bg-white tw-text-base tw-font-medium tw-text-gray-700 hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-indigo-500 sm:tw-mt-0 sm:tw-ml-3 sm:tw-w-auto sm:tw-text-sm">
            Close
          </button>
        </div>
      </form>
    </div>
  </div>
</div>