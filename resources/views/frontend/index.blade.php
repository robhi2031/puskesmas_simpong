@extends('frontend.layouts', ['activeMenu' => 'Beranda', 'activeSubMenu' => ''])
@section('content')
<!-- Start Our Banner Area  -->
<div class="rbt-banner-area pt--50 pt_md--30 pt_sm--30">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="swiper viral-banner-activation rbt-arrow-between rbt-radius shadow" id="headSectionSlide">
                    <div class="swiper-wrapper"></div>
                    <div class="rbt-swiper-arrow rbt-arrow-left">
                        <div class="custom-overfolow">
                            <i class="rbt-icon feather-arrow-left"></i>
                            <i class="rbt-icon-top feather-arrow-left"></i>
                        </div>
                    </div>
                    <div class="rbt-swiper-arrow rbt-arrow-right">
                        <div class="custom-overfolow">
                            <i class="rbt-icon feather-arrow-right"></i>
                            <i class="rbt-icon-top feather-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="about-style-3 pb--30">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="row row--0 about-wrapper align-items-top theme-shape" id="row-headWelcome"></div>
            </div>
        </div>
    </div>
</div>
<!-- Start Post Area  -->
<div class="rbt-course-area rbt-section-gap pt--50" id="postSimpleSection-01">
    <div class="container">
        <div class="row mb--60 g-5 align-items-end header-content"></div>
        <!-- Start Body Content Area -->
        <div class="row g-5 body-content" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800"></div>
        <!-- End Body Content Area -->
    </div>
</div>
<!-- End Post Area  -->
<!-- Start Post Video Area  -->
<div class="rbt-course-area rbt-section-gap bg-gradient-5" id="postSimpleSection-02">
    <div class="container">
        <div class="row mb--60 g-5 align-items-end header-content"></div>
        <!-- Start Body Content Area -->
        <div class="row g-5 body-content" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800"></div>
        <!-- End Body Content Area -->
    </div>
</div>
<!-- End Post Video Area  -->
<!-- Start Post Gallery Area  -->
<div class="rbt-course-area rbt-section-gap bg-color-extra2" id="postSimpleSection-03">
    <div class="container">
        <div class="row mb--60 g-5 align-items-end header-content"></div>
        <!-- Start Body Content Area -->
        <div class="row g-5 body-content" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800"></div>
        <!-- End Body Content Area -->
    </div>
</div>
<!-- End Post Gallery Area  -->
<!-- Start Link With Image Area  -->
<div class="rbt-event-area rbt-section-gap bg-primary-opacity">
    <div class="container">
        <div class="row mb--55">
            <div class="section-title text-center">
                <!-- <span class="subtitle bg-white-opacity">Aplikasi & Layanan Lainnya</span> -->
                <h2 class="title">Aplikasi & Layanan Lainnya</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="swiper event-activation-1 rbt-arrow-between rbt-dot-bottom-center" id="relatedLinkWithImage">
                    <div class="swiper-wrapper"></div>
                    <div class="rbt-swiper-arrow rbt-arrow-left">
                        <div class="custom-overfolow">
                            <i class="rbt-icon feather-arrow-left"></i>
                            <i class="rbt-icon-top feather-arrow-left"></i>
                        </div>
                    </div>

                    <div class="rbt-swiper-arrow rbt-arrow-right">
                        <div class="custom-overfolow">
                            <i class="rbt-icon feather-arrow-right"></i>
                            <i class="rbt-icon-top feather-arrow-right"></i>
                        </div>
                    </div>
                    <div class="rbt-swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Event Area  -->
@endsection