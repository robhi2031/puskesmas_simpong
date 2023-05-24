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
                <div class="blog-content-wrapper public-page blog-content-detail rbt-article-content-wrapper card-top-offset rounded p-5">
                    <div class="content p-0">
                        <div class="container p-0 mb--50" id="container-post">
                            <div class="row g-3"></div>
                            <div class="row-newsmore" id="row-load_newspaper">
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
                        <div class="container mb--30">
                            <div class="row g-5 align-items-top mb--30">
                                <div class="col-lg-12">
                                    <div class="social-share-block pb-3">
                                        <div class="fw-medium mb-3 mb-md-0"><span>Bagikan:</span></div> 
                                        <ul class="social-icon social-default transparent-with-border align-items-center pb-0">
                                            <li>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" title="Bagikan ke facebook">
                                                    <i class="feather-facebook"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://twitter.com/share?url={{ url()->current() }}" target="_blank" title="Bagikan ke twitter">
                                                    <i class="feather-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://api.whatsapp.com/send?text={{ url()->current() }}" target="_blank" title="Bagikan ke WhatsApp">
                                                    <i class="fab fa-whatsapp"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}" target="_blank" title="Bagikan ke LinkedIn">
                                                    <i class="feather-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
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