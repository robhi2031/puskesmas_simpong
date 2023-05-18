@extends('frontend.layouts', ['activeMenu' => 'Fasilitas', 'activeSubMenu' => ''])
@section('content')
<div class="rbt-page-banner-wrapper pb--175">
    <!-- Start Banner BG Image  -->
    <div class="rbt-banner-image-100" style="background: linear-gradient(45deg, rgb(13 32 140 / 70%), rgb(26 90 136 / 80%)), url({{ asset('/dist/img/bg-detail2.jpg') }}) center top no-repeat;"></div>
    <!-- End Banner BG Image  -->
    <div class="rbt-banner-content">
        <!-- Start Banner Content Top  -->
        <div class="rbt-banner-content-top">
            <div class="container">
                <div class="row" id="titlePage">
                    <div class="col-lg-12">
                        <!-- <p class="description">Blog that help beginner designers become true unicorns. </p> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Banner Content Top  -->
    </div>
</div>
<div class="rbt-event-area rbt-section-gap bg-gradient-5 pb--60">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5 mb-md-0">
                <div class="rbt-about-area about-style-1 rbt-section-gap rbt-shadow-box card-top-offset rounded py-5">
                    <div class="content">
                        <div class="container" id="container-pages"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection