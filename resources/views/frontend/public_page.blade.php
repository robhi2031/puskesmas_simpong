@extends('frontend.layouts', ['activeMenu' => $data['dtl_page']->parent_menu == '' || $data['dtl_page']->parent_menu == null ? $data['dtl_page']->title : $data['dtl_page']->parent_menu, 'activeSubMenu' => $data['dtl_page']->parent_menu == '' || $data['dtl_page']->parent_menu == null ? '' : $data['dtl_page']->title])
@section('content')
<div class="rbt-page-banner-wrapper pb--175">
    <!-- Start Banner BG Image  -->
    <div class="rbt-banner-image-100" style="background: linear-gradient(45deg, rgb(0 54 20 / 84%), rgb(14 201 114 / 68%)), url({{ asset('/dist/img/bg-detail2.jpg') }}) center top no-repeat; background-size: cover;"></div>
    <!-- End Banner BG Image  -->
    <div class="rbt-banner-content">
        <!-- Start Banner Content Top  -->
        <div class="rbt-banner-content-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title-wrapper">
                            <h1 class="title mb--0 text-white">{{ $data['dtl_page']->title }}</h1>
                        </div>
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
                <div class="rbt-about-area about-style-1 public-page rbt-section-gap rbt-shadow-box card-top-offset rounded py-5">
                    <div class="content">
                        <div class="container">
                            <div class="row g-5 align-items-top mb--100">
                                <div class="col-lg-12">
                                    {!! $data['dtl_page']->content !!}
                                </div>
                            </div>
                            <div class="row g-5 align-items-top mb--30">
                                <div class="col-lg-12">
                                    <div class="social-share-block pb-5">
                                        <div class="fw-medium"><span>Bagikan:</span></div> 
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