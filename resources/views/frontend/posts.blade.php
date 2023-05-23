@extends('frontend.layouts', ['activeMenu' => 'Publikasi', 'activeSubMenu' => $data['post_type']])
@section('content')
<div class="rbt-page-banner-wrapper pb--175">
    <!-- Start Banner BG Image  -->
    <div class="rbt-banner-image-100" style="background: linear-gradient(45deg, rgb(0 54 20 / 84%), rgb(14 201 114 / 68%)), url({{ asset('/dist/img/bg-detail2.jpg') }}) center top no-repeat; background-size: cover;"></div>
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
                <div class="blog-content-wrapper blog-content-detail rbt-article-content-wrapper card-top-offset rounded p-0">
                    <div class="content">
                        <div class="container" id="container-post">
                            <div class="row g-0"></div>
                            <div class="row-newsmore my-5 mb--30" id="row-load_newspaper">
                                <div class="col-newsmore">
                                    <div class="btn-loadmore" id="btn-load_newspaper" style="display: none;">
                                        <span>LAINNYA</span>
                                        <i class="icon fas fa-caret-down"></i>
                                        <div class="link-overlay btn-link_loadnewspaper"></div>
                                    </div>
                                    <div class="ajax-preloader active" id="preloader-loadmore_newspaper" style="display: none;">
                                        <div class="main-preloader-in">
                                            <img src="{{ $data['loader-logo'] }}" alt="logo-gifloader" class="loader-logo" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection