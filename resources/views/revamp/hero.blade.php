<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center">
  <div class="row" style="width: 100%; --bs-gutter-x: 0;">
    <div class="col-lg-12" style="display: flex; flex-direction: column; align-items: center;">
      <div class="container-fluid position-relative">
        <img src="{{ asset('landing2/assets/image/banner.gif', true) }}" class="img-fluid d-none d-lg-block" alt=""
          style="width: 100%;" />
        <div class="row d-none d-lg-block position-absolute bottom-0 start-50 translate-middle-x">
          <div class="col-xs-12 d-flex flex-row justify-content-center align-items-center">
            <a target="_blank" href="https://apps.apple.com/jm/app/bangla-radar/id1526805734"
              title="Download from App Store" class="btn-appstore">App Store</a>
            <a target="_blank" href="https://play.google.com/store/apps/details?id=com.mobile.hs.hyperware"
              title="Download from Play Store" class="btn-playstore">Play Store</a>
          </div>
        </div>
      </div>
      <img src="{{ asset('landing2/assets/image/live_tracking3.gif', true) }}" class="img-fluid d-lg-none" alt=""
        style="width: 100%;" />
      <div class="row d-block d-lg-none">
        <div class="col-xs-12 d-flex flex-row justify-content-center align-items-center">
          <a target="_blank" href="https://apps.apple.com/jm/app/bangla-radar/id1526805734"
            title="Download from App Store" class="btn-appstore">App Store</a>
          <a target="_blank" href="https://play.google.com/store/apps/details?id=com.mobile.hs.hyperware"
            title="Download from Play Store" class="btn-playstore">Play Store</a>
        </div>
      </div>
      <h2 class="text-center bangla" style="font-weight: 800; color: #424242; font-size: 24px; margin-top: 30px;">
        @lang('header.banner.title')
      </h2>
      <p class="text-enter bangla" style="margin-top: 10px; font-size: 16px;">
        @lang('header.banner.caption')
      </p>
      <a href="#pricing" style="background: #4154f1;padding: 18px 30px; border-radius: 4px; color: #fff;"
        class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
        <span class="bangla">@lang('header.banner.action')</span>
        <i class="bi bi-arrow-right text-white"></i>
      </a>
    </div>
  </div>

</section><!-- End Hero -->