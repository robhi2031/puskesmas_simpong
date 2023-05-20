@extends('frontend.layouts', ['activeMenu' => 'Profil', 'activeSubMenu' => ''])
@section('content')
<div class="rbt-page-banner-wrapper pb--175">
    <!-- Start Banner BG Image  -->
    <div class="rbt-banner-image-100" style="background: linear-gradient(45deg, rgb(0 54 20 / 84%), rgb(14 201 114 / 68%)), url({{ asset('/dist/img/bg-detail2.jpg') }}) center top no-repeat;"></div>
    <!-- End Banner BG Image  -->
    <div class="rbt-banner-content">
        <!-- Start Banner Content Top  -->
        <div class="rbt-banner-content-top">
            <div class="container">
                <div class="row" id="titlePage">
                    <div class="col-lg-12">
                        <div class="title-wrapper">
                            <h1 class="title mb--0 text-white">Profil {{ $data['organization_name'] }}</h1>
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
                <div class="profile-content rbt-shadow-box card-top-offset rounded py-5">
                    <div class="content">
                        <div class="container">
                            <div class="row g-0">
                                <div class="col-md-12 mb-5">
                                    <h1 class="rbt-title-style-3 text-uppercase">Profil</h1>
                                    {!! $data['organization']->profile !!}
                                </div>
                                <div class="col-md-12 mb-5">
                                    <h1 class="rbt-title-style-3 text-uppercase">Visi & Misi</h1>
                                    {!! $data['organization']->vision_mission !!}
                                </div>
                                <div class="col-md-12 mb-5">
                                    <h1 class="rbt-title-style-3 text-uppercase">Profil Kepala {{ $data['organization_name'] }}</h1>
                                    <div class="row g-3 row--30 align-items-top mb-5">
                                        <div class="col-lg-4">
                                            <div class="rbt-team-thumbnail">
                                                <div class="thumb">
                                                    <a href="{{ $data['kapuskesmas']->url_thumb }}" class="image-popup" title="{{ $data['kapuskesmas']->name }}">
                                                        <img class="w-100 rounded shadow" src="{{ $data['kapuskesmas']->url_thumb }}" alt="{{ $data['kapuskesmas']->thumb }}">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="rbt-team-details">
                                                <div class="author-info">
                                                    <h4 class="title mb-3">{{ $data['kapuskesmas']->name }}</h4>
                                                    <div class="mb-3">
                                                        <span class="d-block">Jenis Kelamin</span>
                                                        <span class="d-block text-black">{{ $data['kapuskesmas']->gender }}</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="d-block">Status Kepegawaian</span>
                                                        <span class="d-block text-black">{{ $data['kapuskesmas']->employment_status }}</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="d-block">Pangkat/ Golongan</span>
                                                        <span class="d-block text-black">{{ $data['kapuskesmas']->rank_grade }}</span>
                                                    </div>
                                                    <div class="mb-3">
                                                        <span class="d-block">Penghargaan</span>
                                                        <span class="d-block text-black">{!! $data['kapuskesmas']->awards !!}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-5">
                                    <h1 class="rbt-title-style-3 text-uppercase">Struktur Organisasi</h1>
                                    <figure>
                                        <img class="w-100" src="{{ $data['organization']->url_organizationStructure }}" alt="{{ $data['organization']->organization_structure }}">
                                        {{-- <figcaption>Business and core management app are for enterprise.</figcaption> --}}
                                    </figure>
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