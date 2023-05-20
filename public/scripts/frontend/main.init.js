"use strict";
// Class Definition
const loadApp = function() {
    //load Head Slide Banner
	const _headSlideBanner = () => {
        $('#headSectionSlide .swiper-wrapper').html(`
            <div class="swiper-slide">
                <div class="thumbnail">
                    <svg class="bd-placeholder-img" width="100%" height="420" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                </div>
            </div>
        `);
        $.ajax({
            url: base_url+ "api/head_slidebanner",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#headSectionSlide .swiper-wrapper').html(data.row);
            }, complete: function (data) {
                let swiper = new Swiper('#headSectionSlide', {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    centeredSlides: true,
                    autoplay: {
                        delay: 3000,
                        stopOnLastSlide: false,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                        reverseDirection: true
                    },
                    effect: "fade",
                    loop: true,
                    navigation: {
                        nextEl: '.rbt-arrow-left',
                        prevEl: '.rbt-arrow-right',
                        clickable: true,
                    },
                });
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log('Load data is error');
            }
        });
    }
    //load Head Welcome
	const _headWelcome = () => {
        $('#row-headWelcome').html(`<div class="col-md-3 col-sm-4">
            <div class="thumbnail">
                <svg class="bd-placeholder-img rounded" width="100%" height="245px" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <rect width="100%" height="100%" fill="#868e96"></rect>
                </svg>
            </div>
        </div>
        <div class="col-md-9 col-sm-8 mt_md--10 mt_sm--30">
            <div class="content">
                <div class="inner pe-0">
                    <h3 class="placeholder-glow my-0 mb-5">
                        <span class="placeholder col-12 rounded"></span>
                    </h3>
                    <h5 class="placeholder-glow mb-5">
                        <span class="placeholder rounded col-12"></span>
                        <span class="placeholder rounded col-12"></span>
                        <span class="placeholder rounded col-8"></span>
                    </h5>
                    <h6 class="placeholder-glow mb-0">
                        <span class="placeholder rounded col-4"></span>
                    </h6>
                    <h6 class="placeholder-glow">
                        <span class="placeholder rounded col-4"></span>
                    </h6>
                </div>
            </div>
        </div>
        <div class="top-circle-shape position-bottom-right"></div>`);
        $.ajax({
            url: base_url+ "api/head_welcome",
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#row-headWelcome').html(`<div class="col-md-3 col-sm-4">
                    <div class="thumbnail">
                        <img src="` +data.row.url_thumb+ `" alt="` +data.row.thumb+ `">
                    </div>
                </div>
                <div class="col-md-9 col-sm-8 mt_md--10 mt_sm--30">
                    <div class="content">
                        <div class="inner pe-0">
                            <h4 class="title mb-3">` +data.row.text_header_welcome+ `</h4>
                            <div class="text-body-welcome">` +data.row.text_welcome+ `</div>
                            <ul class="contact-address">
                                <li class="mb-0">
                                    <strong class="text-capitalize">` +data.row.name_kapuskesmas+ `</strong>
                                </li>
                                <li class="mt-0 text-position-welcome text-capitalize">` +data.row.position_kapuskesmas.toLowerCase()+ `</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="top-circle-shape position-bottom-right"></div>`);
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log('Load data is error');
            }
        });
    }
    //load Blog Post Simple Section - 01 
	const _postSimpleSection01 = () => {
        let headerTitle = `<h1 class="col-lg-6 col-md-6 col-12 placeholder-glow my-0">
            <span class="placeholder col-lg-10 col-12 rounded"></span>
        </h1>
        <h1 class="col-lg-6 col-md-6 col-12 placeholder-glow my-0 text-end">
            <span class="placeholder col-lg-6 col-12 rounded"></span>
        </h1>`;
        $('#postSimpleSection-01 .header-content').html(headerTitle);
        let bodyContent = '';
        let i;
        for (i = 0; i < 4; i++) {
            bodyContent += `<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="rbt-card variation-01 rbt-hover shadow p-4">
                    <div class="rbt-card-img">
                        <a href="javascript:void(0);" title="Card placeholder">
                            <svg class="bd-placeholder-img rounded" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                        </a>
                    </div>
                    <div class="rbt-card-body">
                        <h6 class="placeholder-glow mb-3"><span class="placeholder rounded col-4"></span></h6>
                        <h5 class="placeholder-glow">
                            <span class="placeholder rounded col-12"></span>
                            <span class="placeholder rounded col-12"></span>
                            <span class="placeholder rounded col-8"></span>
                        </h5>
                        <h6 class="placeholder-glow">
                            <span class="placeholder rounded col-4"></span>
                            <span class="placeholder rounded col-4"></span>
                        </h6>
                        <h5 class="rbt-card-bottom placeholder-glow justify-content-end">
                            <span class="placeholder rounded col-6"></span>
                        </h5>
                    </div>
                </div>
            </div>`;
        }
        $('#postSimpleSection-01 .body-content').append(bodyContent);
        
        const format_post = 'DEFAULT', limit_post = 4;
        $.ajax({
            url: base_url+ "api/show_mainpost",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            dataType: 'JSON',
            data: {
                format_post, limit_post
            },
            success: function (data) {
                headerTitle = `<div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <h2 class="title">Berita & Informasi Terbaru</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="read-more-btn text-start text-md-end">
                        <a class="rbt-btn btn-gradient hover-icon-reverse radius-round" href="` +base_url+ `all/news" title="Berita dan Informasi">
                            <div class="icon-reverse-wrapper">
                                <span class="btn-text">LIHAT SEMUA BERITA & INFORMASI</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                </div>`;
                $('#postSimpleSection-01 .header-content').html(headerTitle);

                let rows = data.row;
                bodyContent = '';
                $.each(rows, function(key, row) {
                    bodyContent += `<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="rbt-card variation-01 rbt-hover shadow p-4">
                            <div class="rbt-card-img">
                                <a href="` +row.link_url+ `" title="` +row.title+ `">
                                    <img src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <div class="rbt-card-top justify-content-start">
                                    <ul class="rbt-meta fs-4 mb-0">
                                        <li><i class="feather-tag"></i>` +row.category+ `</li>
                                    </ul>
                                </div>
                                <h4 class="rbt-card-title rbt-card-title-24 text-row-limit-3">
                                    <a href="` +row.link_url+ `" title="` +row.title+ `">` +row.title+ `</a>
                                </h4>
                                <ul class="rbt-meta fs-4 mt-3">
                                    <li><i class="feather-calendar"></i>` +row.date+ `</li>
                                    <li><i class="feather-user"></i>` +row.user+ `</li>
                                </ul>
                                <div class="rbt-card-bottom justify-content-end">
                                    <a class="rbt-btn-link" href="` +row.link_url+ `" title="` +row.title+ `">
                                        Selengkapnya <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>`;
                });
                $('#postSimpleSection-01 .body-content').html(bodyContent);
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log('Load data is error');
            }
        });
    }
    //load Blog Post Simple Section - 02
	const _postSimpleSection02 = () => {
        let headerTitle = `<h1 class="col-lg-6 col-md-6 col-12 placeholder-glow my-0">
            <span class="placeholder col-lg-10 col-12 rounded"></span>
        </h1>
        <h1 class="col-lg-6 col-md-6 col-12 placeholder-glow my-0 text-end">
            <span class="placeholder col-lg-6 col-12 rounded"></span>
        </h1>`;
        $('#postSimpleSection-02 .header-content').html(headerTitle);
        let bodyContent = '';
        let i;
        bodyContent += `<div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30">
            <div class="rbt-card variation-02 height-330 rbt-hover">
                <div class="rbt-card-img">
                    <div class="video-popup-wrapper">
                        <a href="javascript:void(0);" title="Card placeholder">
                            <svg class="bd-placeholder-img rounded" width="100%" height="330" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                        </a>
                    </div>
                </div>
                <div class="rbt-card-body d-flex flex-column">
                    <h4 class="placeholder-glow">
                        <span class="placeholder rounded col-12"></span>
                        <span class="placeholder rounded col-8"></span>
                    </h4>
                    <h5 class="placeholder-glow mb-5">
                        <span class="placeholder rounded col-4"></span>
                        <span class="placeholder rounded col-4"></span>
                    </h5>
                    <h5 class="placeholder-glow rbt-card-bottom align-items-center justify-content-end">
                        <span class="placeholder rounded col-3 rbt-meta fs-4 m-0 p-0 me-auto"></span>
                        <span class="placeholder rounded col-6"></span>
                    </h5>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30">`;
        for (i = 0; i < 3; i++) {
            bodyContent += `<div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="rbt-card card-list-2 event-list-card variation-01 rbt-hover align-items-start px-3 py-4">
                            <div class="rbt-card-img">
                                <a href="javascript:void(0);" title="Card placeholder">
                                    <svg class="bd-placeholder-img rounded" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                                </a>
                            </div>
                            <div class="rbt-card-body d-flex flex-column">
                                <h5 class="placeholder-glow mb-3">
                                    <span class="placeholder rounded col-12"></span>
                                    <span class="placeholder rounded col-8"></span>
                                </h5>
                                <small class="placeholder-glow mb-5">
                                    <span class="placeholder rounded col-4"></span>
                                    <span class="placeholder rounded col-4"></span>
                                </small>
                                <small class="placeholder-glow rbt-card-bottom align-items-center justify-content-end">
                                    <span class="placeholder rounded col-3 rbt-meta fs-4 m-0 p-0 me-auto"></span>
                                    <span class="placeholder rounded col-6"></span>
                                </small>
                            </div>
                        </div>
                    </div>
            </div>`;
        }
        bodyContent += `</div>`;
        $('#postSimpleSection-02 .body-content').append(bodyContent);
        
        const format_post = 'VIDEO', limit_post = 4;
        $.ajax({
            url: base_url+ "api/show_mainpost",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            dataType: 'JSON',
            data: {
                format_post, limit_post
            },
            success: function (data) {
                headerTitle = `<div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <h2 class="title">Video Terbaru</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="read-more-btn text-start text-md-end">
                        <a class="rbt-btn btn-gradient hover-icon-reverse radius-round" href="` +base_url+ `all/video" title="Video">
                            <div class="icon-reverse-wrapper">
                                <span class="btn-text">LIHAT SEMUA VIDEO</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                </div>`;
                $('#postSimpleSection-02 .header-content').html(headerTitle);

                let rows = data.row;
                bodyContent = '';
                bodyContent += `<div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30">
                    <div class="rbt-card variation-02 height-330 rbt-hover">
                        <div class="rbt-card-img">
                            <div class="video-popup-wrapper mt_lg--10 mt_md--20 mt_sm--20">
                                <img class="w-100 rbt-radius" src="` +rows[0].url_thumb+ `" alt="` +rows[0].thumb+ `">
                                <a class="rbt-btn rounded-player-2 position-to-top with-animation" href="javascript:void(0);" title="` +rows[0].title+ `" onclick="_showVideoModal('` +rows[0].link_embed+ `');">
                                    <span class="play-icon"></span>
                                </a>
                            </div>
                        </div>
                        <div class="rbt-card-body">
                            <h4 class="rbt-card-title rbt-card-title-24 text-row-limit-3">
                                <a href="` +rows[0].link_url+ `" title="` +rows[0].title+ `">` +rows[0].title+ `</a>
                            </h4>
                            <ul class="rbt-meta fs-4 mt-3">
                                <li><i class="feather-clock"></i>` +rows[0].date+ `</li>
                                <li><i class="feather-users"></i>` +rows[0].user+ `</li>
                            </ul>
                            <div class="rbt-card-bottom align-items-center justify-content-end">
                                <ul class="rbt-meta fs-4 m-0 p-0 me-auto">
                                    <li><i class="feather-tag"></i>` +rows[0].category+ `</li>
                                </ul>
                                <a class="rbt-btn-link" href="` +rows[0].link_url+ `">
                                    Selengkapnya <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt--30">`;
                $.each(rows, function(key, row) {
                    if(key > 0) {
                        bodyContent += `<div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="rbt-card card-list-2 event-list-card variation-01 rbt-hover px-3 py-4">
                                    <div class="rbt-card-img">
                                        <div class="video-popup-wrapper mt_lg--10 mt_md--20 mt_sm--20">
                                            <img class="w-100 rbt-radius" src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                                            <a class="rbt-btn rounded-player-2 sm-size-50px position-to-top" href="javascript:void(0);" title="` +row.title+ `" onclick="_showVideoModal('` +row.link_embed+ `');">
                                                <span class="play-icon"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="rbt-card-body">
                                        <h4 class="rbt-card-title rbt-card-title-24 text-row-limit-2">
                                            <a href="` +row.link_url+ `"  title="` +row.title+ `">` +row.title+ `</a>
                                        </h4>
                                        <ul class="rbt-meta">
                                            <li><i class="feather-calendar"></i>` +row.date+ `</li>
                                            <li><i class="feather-user"></i>` +row.user+ `</li>
                                        </ul>
                                        <div class="rbt-card-bottom align-items-center justify-content-end">
                                            <ul class="rbt-meta fs-4 m-0 p-0 me-auto">
                                                <li><i class="feather-tag"></i>` +row.category+ `</li>
                                            </ul>
                                            <a class="rbt-btn-link" href="` +row.link_url+ `" title="` +row.title+ `">
                                                Selengkapnya <i class="feather-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    }
                });
                bodyContent += `</div>`;
                $('#postSimpleSection-02 .body-content').html(bodyContent);
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log('Load data is error');
            }
        });
    }
    //load Blog Post Simple Section - 03 
    const _postSimpleSection03 = () => {
        let headerTitle = `<h1 class="col-lg-6 col-md-6 col-12 placeholder-glow my-0">
            <span class="placeholder col-lg-10 col-12 rounded"></span>
        </h1>
        <h1 class="col-lg-6 col-md-6 col-12 placeholder-glow my-0 text-end">
            <span class="placeholder col-lg-6 col-12 rounded"></span>
        </h1>`;
        $('#postSimpleSection-03 .header-content').html(headerTitle);
        let bodyContent = '';
        let i;
        for (i = 0; i < 4; i++) {
            bodyContent += `<div class="col-lg-3 col-md-6 col-sm-12 col-12">
                <div class="rbt-card variation-02 rbt-hover">
                    <div class="rbt-card-img">
                        <a href="javascript:void(0);" title="Card placeholder">
                            <svg class="bd-placeholder-img rounded-top" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                        </a>
                    </div>
                    <div class="rbt-card-body">
                        <h5 class="placeholder-glow mb-3">
                            <span class="placeholder rounded col-12"></span>
                            <span class="placeholder rounded col-8"></span>
                        </h5>
                        <small class="placeholder-glow rbt-card-bottom align-items-center justify-content-end mt-5">
                            <span class="placeholder rounded col-3 rbt-meta fs-4 m-0 p-0 me-auto"></span>
                            <span class="placeholder rounded col-6"></span>
                        </small>
                    </div>
                </div>
            </div>`;
        }
        $('#postSimpleSection-03 .body-content').append(bodyContent);
        
        const format_post = 'GALLERY', limit_post = 4;
        $.ajax({
            url: base_url+ "api/show_mainpost",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            dataType: 'JSON',
            data: {
                format_post, limit_post
            },
            success: function (data) {
                headerTitle = `<div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <h2 class="title">Galeri Kegiatan Terbaru</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="read-more-btn text-start text-md-end">
                        <a class="rbt-btn btn-gradient hover-icon-reverse radius-round" href="` +base_url+ `all/gallery" title="Galeri Kegiatan">
                            <div class="icon-reverse-wrapper">
                                <span class="btn-text">LIHAT SEMUA GALERI</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                </div>`;
                $('#postSimpleSection-03 .header-content').html(headerTitle);

                let rows = data.row;
                bodyContent = '';
                $.each(rows, function(key, row) {
                    bodyContent += `<div class="col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="rbt-card variation-02 rbt-hover">
                            <div class="rbt-card-img">
                                <div class="video-popup-wrapper">
                                    <img class="w-100 rounded-top" src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                                    <a class="rbt-btn rounded-player-2 sm-size-50px position-to-top shadow" href="` +row.link_url+ `" title="` +row.title+ `">
                                        <i class="far fa-images gallery-icon ps-0 fs-24px"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title fs-24px text-row-limit-3">
                                    <a href="` +row.link_url+ `" title="` +row.title+ `">` +row.title+ `</a>
                                </h5>
                                <div class="rbt-card-bottom mt-5">
                                    <ul class="rbt-meta">
                                        <li><i class="feather-calendar"></i>` +row.date+ `</li>
                                        <li><i class="feather-user"></i>` +row.user+ `</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>`;
                });
                $('#postSimpleSection-03 .body-content').html(bodyContent);
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log('Load data is error');
            }
        });
    }
    //load Link Terkait with Slide Image
	const _relatedLinkWithImage = () => {
        let position = 'relatedLinkWithImage';
        $('#' +position+ ' .swiper-wrapper').html(`<div class="swiper-slide">
            <div class="single-slide mx-3">
                <svg class="bd-placeholder-img rounded" width="100%" height="100" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
            </div>
        </div>
        <div class="swiper-slide">
            <div class="single-slide mx-3">
                <svg class="bd-placeholder-img rounded" width="100%" height="100" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
            </div>
        </div>
        <div class="swiper-slide">
            <div class="single-slide mx-3">
                <svg class="bd-placeholder-img rounded" width="100%" height="100" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
            </div>
        </div>`);
        $.ajax({
            url: base_url+ "api/related_link",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            dataType: 'JSON',
            data: {
                position
            },
            success: function (data) {
                $('#'+position+' .swiper-wrapper').html(data.row);
            }, complete: function (data) {
                let swiper = new Swiper('#' +position, {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    autoplay: {
                        delay: 3000,
                        stopOnLastSlide: false,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                        reverseDirection: true
                    },
                    loop: true,
                    navigation: {
                        nextEl: '.rbt-arrow-left',
                        prevEl: '.rbt-arrow-right',
                        clickable: true,
                    },
                    breakpoints: {
                        575: {
                            slidesPerView: 1,
                        },
    
                        768: {
                            slidesPerView: 2,
                        },
    
                        992: {
                            slidesPerView: 3,
                        },
                    },
                });
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log('Load data is error');
            }
        });
    }
    // Public Functions
    return {
        // public functions
        init: function() {
            _headSlideBanner(), _headWelcome(), _postSimpleSection01(), _postSimpleSection02(), _postSimpleSection03(), _relatedLinkWithImage();
        }
    };
}();
// Call Open Modal Video
const _showVideoModal = (link_embed) => {
    let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    let match = link_embed.match(regExp);
    if (match && match[2].length == 11) {
        $.magnificPopup.open({
            type: 'iframe',
            items: {
                src: 'https://www.youtube.com/watch?v='+match[2]
            }
        });
    }
};
// Class Initialization
jQuery(document).ready(function() {
    loadApp.init();
});