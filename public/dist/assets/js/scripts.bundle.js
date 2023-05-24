(function (window, document, $, undefined) {
    'use strict';

    var eduJs = {
        i: function (e) {
            eduJs.d();
            eduJs.methods();
        },
        d: function (e) {
            this._window = $(window),
                this._document = $(document),
                this._body = $('body'),
                this._html = $('html'),
                this.sideNav = $('.rbt-search-dropdown')
        },
        methods: function (e) {
            eduJs._loadSiteInfo();
            eduJs.searchPost();
            eduJs.tableExistsOnContent();
            eduJs.salActive();
            eduJs.menuCurrentLink();
            eduJs.eduBgCardHover();
            eduJs.magnigyPopup();
            eduJs.counterUp();
            eduJs.courseView();
            eduJs.stickyHeader();
            eduJs.masonryActivation();
            eduJs._clickDoc();
            eduJs.wowActivation();
            eduJs.radialProgress();
            eduJs.marqueImage();
            eduJs.popupMobileMenu();
            eduJs.headerSticky();
            eduJs.qtyBtn();
            eduJs.checkoutPage();
            eduJs.offCanvas();
            eduJs.transparentHeader();
            eduJs.categoryMenuHover();
            eduJs.filterClickButton();
            eduJs.selectPicker();
            eduJs.headerTopActivation();
            eduJs.magnificPopupActivation();
            eduJs.showMoreBtn();
            eduJs.sidebarVideoHidden();
            eduJs.courseActionBottom();
            eduJs.topbarExpend();
            eduJs.categoryOffcanvas();
            eduJs.autoslidertab();
            eduJs.moveAnimation();
        },
        autoslidertab: function (params) {
            function tabChange() {
                var tabs = $('.nav-tabs.splash-nav-tabs > li');
                var active = tabs.find('a.active');
                var next = active.parent('li').next('li').find('a');
                if (next.length === 0) {
                    next = tabs.first().find('a').on('click');
                }
                next.tab('show');
            }
            var tabCycle = setInterval(tabChange, 5000);
        },
        offCanvas: function (params) {
            if ($('#rbt-offcanvas-activation').length) {
                $('#rbt-offcanvas-activation').on('click', function () {
                    $('.side-menu').addClass('side-menu-active'), 
                    $('body').addClass('offcanvas-menu-active')
                }),

                $('.close_side_menu').on('click', function () {
                    $('.side-menu').removeClass('side-menu-active'), 
                    $('body').removeClass('offcanvas-menu-active')
                }),

                $('.side-menu .side-nav .navbar-nav li a').on('click', function () {
                    $('.side-menu').removeClass('side-menu-active'), 
                    $('body').removeClass('offcanvas-menu-active')
                }), 
                
                $('#btn_sideNavClose').on('click', function () {
                    $('.side-menu').removeClass('side-menu-active'), 
                    $('body').removeClass('offcanvas-menu-active')
                });
            } 
        },
        menuCurrentLink: function () {
            var currentPage = location.pathname.split("/"),
            current = currentPage[currentPage.length-1];
            $('.mainmenu li a, .dashboard-mainmenu li a').each(function(){
                var $this = $(this);
                if($this.attr('href') === current){
                    $this.addClass('active');
                    $this.parents('.has-menu-child-item').addClass('menu-item-open')
                }
            });
        },
        _loadSiteInfo: function () {
            /* ===> Site Info Section <=== */
            $('#headerInfo').html(`<p class="placeholder-glow">
                <span class="placeholder col-3 me-5"></span><span class="placeholder col-3"></span>
            </p>`);
            $('#headerInfo2').html(`<p class="placeholder-glow">
                <span class="placeholder col-2"></span>
            </p>`);
            $('#headerLogo').css("width", "150px").html(`<p class="placeholder-glow">
                <span class="placeholder col-12"></span>
            </p>`);
            $('#footerInfo').html(`<h2 class="placeholder-glow">
                <span class="placeholder col-6"></span>
            </h2>
            <p class="placeholder-glow">
                <span class="placeholder col-8"></span>
                <span class="placeholder col-2"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-6"></span>
            </p>`);
            $('#footerInfo3').html(`<h3 class="placeholder-glow">
                <span class="placeholder col-6"></span>
            </h3>
            <p class="placeholder-glow">
                <span class="placeholder col-8"></span>
                <span class="placeholder col-2"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-6"></span>
                <span class="placeholder col-8"></span>
                <span class="placeholder col-2"></span>
            </p>
            <h4 class="placeholder-glow">
                <span class="placeholder col-6"></span>
            </h4>`);
            $('#copyrightArea').html(`<h3 class="placeholder-glow m-0">
                <span class="placeholder col-4"></span>
            </h3>`);
            $.ajax({
				url: base_url+ "api/site_info",
				type: "GET",
				dataType: "JSON",
				success: function (data) {
					let headerInfo = `<ul class="rbt-information-list">
                        <li>
                            <a href="mailto:` +data.row.organization_info.email+ `" target="_blank" title="` +data.row.organization_info.email+ `"><i class="fas fa-envelope"></i>` +data.row.organization_info.email+ `</a>
                        </li>
                        <li>
                            <a href="tel:` +data.row.organization_info.phone_number+ `" target="_blank" title="` +data.row.organization_info.phone_number+ `"><i class="fas fa-phone"></i>` +data.row.organization_info.phone_number+ `</a>
                        </li>
                    </ul>`;
                    $('#headerInfo').html(headerInfo);
                    let headerInfo2 = `<ul class="social-share-transparent">
                        <li>
                            <a href="` +data.row.organization_info.facebook_account+ `" target="_blank" title="` +data.row.organization_info.facebook_account+ `"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href="` +data.row.organization_info.instagram_account+ `" target="_blank" title="` +data.row.organization_info.instagram_account+ `"><i class="fab fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="` +data.row.organization_info.twitter_account+ `" target="_blank" title="` +data.row.organization_info.twitter_account+ `"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="` +data.row.organization_info.youtube_channel+ `" target="_blank" title="` +data.row.organization_info.youtube_channel+ `"><i class="fab fa-youtube"></i></a>
                        </li>
                    </ul>`;
                    $('#headerInfo2').html(headerInfo2);
                    let headerLogo = `<div class="logo">
                        <a href="` +base_url+ `" title="` +data.row.frontend_logo+ `">
                            <img src="` +data.row.url_frontendLogo+ `" alt="` +data.row.frontend_logo+ `">
                        </a>
                    </div>`;
                    $('#headerLogo').removeAttr('style').html(headerLogo);
                    let mobileLogo = `<a href="` +base_url+ `">
                        <img src="` +data.row.url_frontendLogo+ `" alt="` +data.row.frontend_logo+ `">
                    </a>`;
                    $('#mobileLogo').removeAttr('style').html(mobileLogo);
                    $('#mobileDesc').html(data.row.organization_info.short_description);
                    let mobileContact = `<li>
                        <a href="mailto:` +data.row.organization_info.email+ `"><i class="fas fa-envelope"></i>` +data.row.organization_info.email+ `</a>
                    </li>
                    <li>
                        <a href="tel:` +data.row.organization_info.phone_number+ `"><i class="fas fa-phone"></i>` +data.row.organization_info.phone_number+ `</a>
                    </li>`;
                    $('#mobileContact').html(mobileContact);
                    let mobileSocialMedia = `<span class="rbt-short-title d-block">Sosial Media Kami</span>
                    <ul class="social-icon social-default transparent-with-border justify-content-start mt-3">
                        <li>
                            <a href="` +data.row.organization_info.facebook_account+ `" target="_blank" title="` +data.row.organization_info.facebook_account+ `">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="` +data.row.organization_info.instagram_account+ `" target="_blank" title="` +data.row.organization_info.instagram_account+ `">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="` +data.row.organization_info.twitter_account+ `" target="_blank" title="` +data.row.organization_info.twitter_account+ `">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="` +data.row.organization_info.youtube_channel+ `" target="_blank" title="` +data.row.organization_info.youtube_channel+ `">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                    </ul>`;
                    $('#mobileSocialMedia').html(mobileSocialMedia);
                    let footerInfo = `<div class="logo">
                        <a href="` +base_url+ `" title="` +data.row.organization_info.logo+ `">
                            <img src="` +data.row.organization_info.url_logo+ `" alt="` +data.row.organization_info.logo+ `">
                        </a>
                    </div>
                    <p class="description mt--20">` +data.row.organization_info.short_description+ `</p>`;
                    $('#footerInfo').html(footerInfo);
                    let footerInfo3 = `<h5 class="ft-title">Dapatkan Kontak</h5>
                    <ul class="ft-link">
                        <li><span>E-mail:</span> <a href="mailto:` +data.row.organization_info.email+ `" target="_blank" title="` +data.row.organization_info.email+ `">` +data.row.organization_info.email+ `</a></li>
                        <li><span>Telpon / Hp:</span> <a href="tel:` +data.row.organization_info.phone_number+ `" target="_blank" title="` +data.row.organization_info.phone_number+ `">` +data.row.organization_info.phone_number+ `</a></li>
                        <li><span>Lokasi Kantor:</span> <a href="http://www.google.com/maps/place/` +data.row.organization_info.office_address_coordinate+ `" target="_blank" title="` +data.row.organization_info.office_address+ `">` +data.row.organization_info.office_address+ `</a></li>
                    </ul>
                    <ul class="social-icon social-default justify-content-start mt-5">
                        <li><a href="` +data.row.organization_info.facebook_account+ `" target="_blank" title="` +data.row.organization_info.facebook_account+ `">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li><a href="` +data.row.organization_info.instagram_account+ `" target="_blank" title="` +data.row.organization_info.instagram_account+ `">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li><a href="` +data.row.organization_info.twitter_account+ `" target="_blank" title="` +data.row.organization_info.twitter_account+ `">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li><a href="` +data.row.organization_info.youtube_channel+ `" target="_blank" title="` +data.row.organization_info.youtube_channel+ `">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                    </ul>`;
                    $('#footerInfo3').html(footerInfo3);
                    $('#copyrightArea').html(data.row.copyright);
                }, error: function (jqXHR, textStatus, errorThrown) {
					console.log('Load data is error');
				}
			});

            /* ===> Footer Link Section <=== */
            let position = 'footerLinkSection';
            $('#footerLinkSection .ft-title').html(`<h5 class="placeholder-glow">
                <span class="placeholder col-12 rounded"></span>
            </h5>`);
            $('#footerLinkSection .ft-link').html(`<p class="placeholder-glow">
                <span class="placeholder col-8 rounded"></span>
                <span class="placeholder col-8 rounded"></span>
                <span class="placeholder col-8 rounded"></span>
            </p>`);
            $.ajax({
                url: base_url+ "api/related_link",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: 'GET',
                dataType: 'JSON',
                data: {
                    position
                },
                success: function (data) {
                    $('#footerLinkSection .ft-title').html('Tautan Yang Berguna');
                    $('#footerLinkSection .ft-link').html(data.row);
                }, error: function (jqXHR, textStatus, errorThrown) {
                    console.log('Load data is error');
                }
            });
        },
        searchPost: function () {
            let start_post = 0,
            limit_post = 4;
            //load Ajax
            let _loadAjax = (start_post, limit_post, search) => {
                $('#contentSearch .rbt-search-content').remove();
                let bodyContent = '', i;
                bodyContent += `<div class="rbt-separator-mid rbt-placeholder">
                    <hr class="rbt-separator m-0">
                </div>
                <div class="row g-4 pt--30 pb--60 rbt-placeholder">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h6 class="placeholder-glow mb-0">
                                <span class="placeholder rounded col-3"></span>
                            </h6>
                        </div>
                    </div>`; 
                for (i = 0; i < 4; i++) {
                    bodyContent += `<div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card event-grid-card variation-01 rbt-hover bg-transparent px-0">
                            <div class="rbt-card-img">
                                <a href="javascript:void(0);" title="Card placeholder">
                                    <svg class="bd-placeholder-img h-180px rounded" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                                </a>
                            </div>
                            <div class="rbt-card-body pt-3">
                                <h6 class="placeholder-glow">
                                    <span class="placeholder rounded col-12"></span>
                                    <span class="placeholder rounded col-8"></span>
                                </h6>
                                <small class="placeholder-glow">
                                    <span class="placeholder rounded col-4 me-3"></span>
                                    <span class="placeholder rounded col-4"></span>
                                </small>
                            </div>
                        </div>
                    </div>`;
                }
                bodyContent += `</div>`;
                $(bodyContent).insertAfter("#contentSearch .row");
                $.ajax({
                    url: base_url+ "api/search_posts",
                    headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        search,
                        start_post,
                        limit_post
                    }, success: function (data) {
                        $('#contentSearch .rbt-placeholder').remove();
                        let rows = data.row;
                        bodyContent = '';
                        if(rows==null) {
                            if (search.length > 0) {
                                bodyContent += `<div class="rbt-separator-mid rbt-search-content">
                                    <hr class="rbt-separator m-0">
                                </div>
                                <div class="row g-4 pt--30 pb--60 rbt-search-content">
                                    <div class="col-lg-12">
                                        <div class="section-title">
                                            <h5 class="rbt-title-style-2">Hasil pencarian:</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <p>Hasil tidak ditemukan, Gunakan kata kunci pencarian lain</p>
                                    </div>
                                </div>`;
                            }
                            bodyContent += '';
                        } else {
                            bodyContent += `<div class="rbt-separator-mid rbt-search-content">
                                <hr class="rbt-separator m-0">
                            </div>
                            <div class="row g-4 pt--30 pb--60 rbt-search-content">
                                <div class="col-lg-12">
                                    <div class="section-title">
                                        <h5 class="rbt-title-style-2">Hasil pencarian:</h5>
                                    </div>
                                </div>`;
                            $.each(rows, function(key, row) {
                                let thumbPost = `<a href="` +row.link_url+ `" title="` +row.title+ `">
                                    <img src="` +row.url_thumb+ `" class="h-180px" alt="` +row.thumb+ `">
                                </a>`;
                                if(row.type=='VIDEO') {
                                    thumbPost = `<div class="video-popup-wrapper">
                                        <img class="w-100 rounded h-180px" src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                                        <a class="rbt-btn rounded-player-2 sm-size-50px position-to-top" href="` +row.link_url+ `" title="` +row.title+ `">
                                            <span class="play-icon"></span>
                                        </a>
                                    </div>`;
                                } if(row.type=='GALLERY') {
                                    thumbPost = `<div class="video-popup-wrapper">
                                        <img class="w-100 rounded h-180px" src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                                        <a class="rbt-btn rounded-player-2 sm-size-50px position-to-top shadow" href="` +row.link_url+ `" title="` +row.title+ `">
                                            <i class="far fa-images gallery-icon ps-0 fs-24px"></i>
                                        </a>
                                    </div>`;
                                }
                                bodyContent += `<div class="col-lg-3 col-md-4 col-12">
                                    <div class="rbt-card event-grid-card variation-01 rbt-hover bg-transparent px-0">
                                        <div class="rbt-card-img">
                                            ` +thumbPost+ `
                                        </div>
                                        <div class="rbt-card-top mt-4 justify-content-start">
                                            <ul class="rbt-meta fs-4 my-0">
                                                <li><i class="feather-tag"></i>` +row.category+ `</li>
                                            </ul>
                                        </div>
                                        <div class="rbt-card-body pt-0">
                                            <h4 class="rbt-card-title rbt-card-title-24 text-row-limit-2 mb-3">
                                                <a href="` +row.link_url+ `" title="` +row.title+ `">` +row.title+ `</a>
                                            </h4>
                                            <ul class="rbt-meta fs-4 my-4">
                                                <li><i class="feather-calendar"></i>` +row.date+ `</li>
                                                <li><i class="feather-user"></i>` +row.user+ `</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>`;
                            });
                            bodyContent += `</div>`;
                        }
                        $(bodyContent).insertAfter("#contentSearch .row");
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Load data is error');
                    }
                });
            }
            //Save Post by Enter onclick="_showVideoModal('` +row.link_embed+ `');"
            $("#searchPosts input").keyup(function (event) {
                if (event.keyCode == 13 || event.key === "Enter") {
                    $("#btn-search").click();
                }
                if ($(this).val().length > 0) {
                    $("#btn-resetSearch").show();
                } else {
                    $("#btn-resetSearch").hide();
                }
            });
            //Save Post Form
            $("#btn-search").on("click", function (e) {
                e.preventDefault();
                let search = $('#top-search').val();
                _loadAjax(start_post, limit_post, search);
            });
            //Clear Search
            $("#btn-resetSearch").on("click", function () {
                $("#top-search").val(""), $(this).hide();
                let search = $('#top-search').val();
                _loadAjax(start_post, limit_post, search);
            });
            $(".header-right .search-trigger-active").on("click", function () {
                $("#top-search").val(""), $("#btn-resetSearch").hide();
                $('#contentSearch .rbt-placeholder').remove(),
                $('#contentSearch .rbt-search-content').remove();
            });
        },
        tableExistsOnContent: function () {
            if($('#page-content table').length){
                let self = '#page-content table';
                console.log(self);
                $(self).addClass('table table-striped');
                $(self).prepend(`<div class="table-responsive"></div>`);
                $(self).appendTo(`<div class="table-responsive"></div>`);



                // $(self).prepend('<div class="table-responsive"></div>');
                // $(`<div class="table-responsive"></div>`).append($(self).clone());
            }
        },
        salActive: function () {
            sal({
                threshold: 0.01,
                once: true,
            });
        },
        eduParalax: function () {
            var scene = document.getElementById('scene');
            var parallaxInstance = new Parallax(scene);
        },
        eduBgCardHover : function () {
            $('.rbt-hover-active').mouseenter(function() {
                var self = this;
                setTimeout(function() {
                    $('.rbt-hover-active.active').removeClass('active');
                    $(self).addClass('active');
                }, 0);
            });
        },
        magnigyPopup: function () {
            $(document).on('ready', function () {
                $('.popup-video').magnificPopup({
                    type: 'iframe'
                });
            });
        },
        counterUp: function () {
            var odo = $('.odometer');
            odo.each(function() {
                $('.odometer').appear(function(e) {
                    var countNumber = $(this).attr('data-count');
                    $(this).html(countNumber);
                });
            });
        },
        courseView: function () {
            var gridViewBtn = $('.rbt-grid-view'),
                listViewBTn = $('.rbt-list-view');
            $(gridViewBtn).on('click', function () {
                $(this).addClass('active').parent('.course-switch-item').siblings().children().removeClass('active');
                $('.rbt-course-grid-column').addClass('active-grid-view');
                $('.rbt-course-grid-column').removeClass('active-list-view');
                $('.rbt-card').removeClass('card-list-2');
            })
            $(listViewBTn).on('click', function () {
                $(this).addClass('active').parent('.course-switch-item').siblings().children().removeClass('active');
                $('.rbt-course-grid-column').removeClass('active-grid-view');
                $('.rbt-course-grid-column').addClass('active-list-view');
                $('.rbt-card').addClass('card-list-2');
            })
        },
        stickyHeader:  function () {
            // Header Transparent
            if ($('header').hasClass('header-transparent')) {
                $('body').addClass('active-header-transparent')
            } else {
                $('body').removeClass('active-header-transparent')
            }
        },
        masonryActivation: function name(params) {
            $(window).load(function () {
                $('.masonary-wrapper-activation').imagesLoaded(function () {
                    // filter items on button click
                    $('.messonry-button').on('click', 'button', function () {
                        var filterValue = $(this).attr('data-filter');
                        $(this).siblings('.is-checked').removeClass('is-checked');
                        $(this).addClass('is-checked');
                        $grid.isotope({
                            filter: filterValue
                        });
                    });
                    // init Isotope
                    var $grid = $('.mesonry-list').isotope({
                        percentPosition: true,
                        transitionDuration: '0.7s',
                        layoutMode: 'masonry',
                        masonry: {
                            columnWidth: '.resizer',
                        }
                    });
                });
            })
            $(window).load(function () {
                $('.splash-masonary-wrapper-activation').imagesLoaded(function () {
                    // filter items on button click
                    $('.messonry-button').on('click', 'button', function () {
                        var filterValue = $(this).attr('data-filter');
                        $(this).siblings('.is-checked').removeClass('is-checked');
                        $(this).addClass('is-checked');
                        $grid.isotope({
                            filter: filterValue
                        });
                    });
                    // init Isotope
                    var $grid = $('.splash-mesonry-list').isotope({
                        percentPosition: true,
                        transitionDuration: '0.7s',
                        layoutMode: 'masonry',
                        masonry: {
                            columnWidth: '.resizer',
                        }
                    });
                });
            })
        },
        _clickDoc: function () {
            var inputblur, inputFocus, openSideNav, closeSideNav;
            inputblur = function (e) {
				if (!$(this).val()) {
					$(this).parent('.form-group').removeClass('focused');
				}
            };
            inputFocus = function (e) {
				$(this).parents('.form-group').addClass('focused');
            };
            openSideNav = function (e) {
                e.preventDefault();
                eduJs.sideNav.addClass('active');
                $('.search-trigger-active').addClass('open');
                eduJs._html.addClass('side-nav-opened');
            };
            closeSideNav = function (e) {
				if (!$('.rbt-search-dropdown, .rbt-search-dropdown *:not(".search-trigger-active, .search-trigger-active *")').is(e.target)) {
                    eduJs.sideNav.removeClass('active');
                    $('.search-trigger-active').removeClass('open');
                    eduJs._html.removeClass('side-nav-opened');
                }
            };
            eduJs._document
            .on('blur', 'input,textarea,select', inputblur)
            .on('focus', 'input:not([type="radio"]),input:not([type="checkbox"]),textarea,select', inputFocus)
            .on('click', '.search-trigger-active', openSideNav)
            .on('click', '.side-nav-opened', closeSideNav)
        },
        wowActivation: function () {
            new WOW().init();
        },
        radialProgress: function () {
            $(window).scroll( function(){
                /* Check the location of each desired element */
                $('.radial-progress').each( function(i){
                    var bottom_of_object = $(this).offset().top + $(this).outerHeight();
                    var bottom_of_window = $(window).scrollTop() + $(window).height();
                    /* If the object is completely visible in the window, fade it in */
                    if( bottom_of_window > bottom_of_object ){
                        $('.radial-progress').easyPieChart({
                            lineWidth: 10,
                            scaleLength: 0,
                            rotate: 0,
                            trackColor: false,
                            lineCap: 'round',
                            size: 180,
                            onStep: function(from, to, percent) {
                            $(this.el).find('.percent').text(Math.round(percent));
                        }
                    });
                    }
                }); 
            });
        },
        marqueImage: function () {
            $('.edumarque').each(function () {
                var t = 0;
                var i = 1;
                var $this = $(this);
                setInterval(function () {
                    t += i;
                    $this.css('background-position-x', -t + 'px');
                }, 10);
            });
        },
        popupMobileMenu: function (e) {
            $('.hamberger-button').on('click', function (e) {
                $('.popup-mobile-menu').addClass('active');
            });
            $('.close-button').on('click', function (e) {
                $('.popup-mobile-menu').removeClass('active');
                $('.popup-mobile-menu .mainmenu .has-dropdown > a, .popup-mobile-menu .mainmenu .with-megamenu > a').siblings('.submenu, .rbt-megamenu').removeClass('active').slideUp('400');
                $('.popup-mobile-menu .mainmenu .has-dropdown > a, .popup-mobile-menu .mainmenu .with-megamenu > a').removeClass('open')
            });
            $('.popup-mobile-menu .mainmenu .has-dropdown > a, .popup-mobile-menu .mainmenu .with-megamenu > a').on('click', function (e) {
                e.preventDefault();
                $(this).siblings('.submenu, .rbt-megamenu').toggleClass('active').slideToggle('400');
                $(this).toggleClass('open')
            })
            $('.popup-mobile-menu, .popup-mobile-menu .mainmenu.onepagenav li a').on('click', function (e) {
                e.target === this && $('.popup-mobile-menu').removeClass('active') && $('.popup-mobile-menu .mainmenu .has-dropdown > a, .popup-mobile-menu .mainmenu .with-megamenu > a').siblings('.submenu, .rbt-megamenu').removeClass('active').slideUp('400') && $('.popup-mobile-menu .mainmenu .has-dropdown > a, .popup-mobile-menu .mainmenu .with-megamenu > a').removeClass('open');
            });
        },
        headerSticky: function () {
            $(window).on('scroll', function() {
                if ($('body').hasClass('rbt-header-sticky')) {
                    var stickyPlaceHolder = $('.rbt-sticky-placeholder'),
                        headerConainer = $('.rbt-header-wrapper'),
                        headerConainerH = headerConainer.outerHeight(),
                        topHeaderH = $('.rbt-header-top').outerHeight() || 0,
                        targrtScroll = topHeaderH + 200;
                    if ($(window).scrollTop() > targrtScroll) {
                        headerConainer.addClass('rbt-sticky');
                        stickyPlaceHolder.height(headerConainerH);
                    } else {
                        headerConainer.removeClass('rbt-sticky');
                        stickyPlaceHolder.height(0);
                    }
                }
            });
        },
        qtyBtn: function () {
            $('.pro-qty').prepend('<span class="dec qtybtn">-</span>');
            $('.pro-qty').append('<span class="inc qtybtn">+</span>');
            $('.qtybtn').on('click', function () {
                var $button = $(this);
                var oldValue = $button.parent().find('input').val();
                if ($button.hasClass('inc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    if (oldValue > 0) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 0;
                    }
                }
                $button.parent().find('input').val(newVal);
            });
        },
        checkoutPage: function () {
            $('[data-shipping]').on('click', function () {
                if ($('[data-shipping]:checked').length > 0) {
                    $('#shipping-form').slideDown();
                } else {
                    $('#shipping-form').slideUp();
                }
            })
            $('[name="payment-method"]').on('click', function () {
                var $value = $(this).attr('value');
                $('.single-method p').slideUp();
                $('[data-method="' + $value + '"]').slideDown();
            })
        },
        transparentHeader: function () {
            if ($('.rbt-header').hasClass('rbt-transparent-header')) {
                var mainHeader = $('.rbt-header').outerHeight();
                $('body').addClass('rbt-header-transpernt-active');
                $('.header-transperent-spacer').css('padding-top', mainHeader + 'px');
            }
        },
        categoryMenuHover: function () {
            $('.vertical-nav-menu li.vertical-nav-item').mouseover(function () {
                $('.rbt-vertical-inner').hide();
                $('.vertical-nav-menu li.vertical-nav-item').removeClass('active');
                $(this).addClass('active');
                var selected_tab = $(this).find('a').attr("href");
                $(selected_tab).stop().fadeIn();
                return false;
            });
        },
        selectPicker: function () {
            $('select').selectpicker();
        },
        filterClickButton: function () {
            $('.discover-filter-activation').on('click', function () {
                $(this).toggleClass('open');
                $('.default-exp-expand').slideToggle('400');
            })
            $('#slider-range').slider({
                range: true,
                min: 10,
                max: 500,
                values: [100, 300],
                slide: function (event, ui) {
                    $('#amount').val('$' + ui.values[0] + ' - $' + ui.values[1]);
                }
            });
            $('#amount').val('$' + $('#slider-range').slider('values', 0) +
                " - $" + $('#slider-range').slider('values', 1));
        },
        headerTopActivation: function () {
            $('.bgsection-activation').on('click', function () {
                $(this).parents('.rbt-header-campaign').addClass('deactive')
            })
        },
        magnificPopupActivation: function () {
            $('.parent-gallery-container').magnificPopup({
                delegate: 'a.child-gallery-single', // child items selector, by clicking on it popup will open
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                image: {
                    verticalFit: true,
                    titleSrc: function(item) {
                        return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('href')+'" target="_blank">image source</a>';
                    }
                },
                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300, // don't foget to change the duration also in CSS
                    easing: 'ease-in-out',
                    opener: function(element) {
                        return element.find('img');
                    }
                }

                /* type: 'image',
                mainClass: 'mfp-with-zoom',
                // other options
                gallery:{
                    enabled:true
                },
                zoom: {
                    enabled: true, // By default it's false, so don't forget to enable it
                    duration: 300, // duration of the effect, in milliseconds
                    easing: 'ease-in-out', // CSS transition easing function
                    // The "opener" function should return the element from which popup will be zoomed in
                    // and to which popup will be scaled down
                    // By defailt it looks for an image tag:
                    opener: function(openerElement) {
                      // openerElement is the element on which popup was initialized, in this case its <a> tag
                      // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                } */
            });
        },
        showMoreBtn: function () {
            $.fn.hasShowMore = function () {
                return this.each(function () {
                    $(this).toggleClass('active');
                    $(this).text('Show Less');
                    $(this).parent('.has-show-more').toggleClass('active');
                    if ($(this).parent('.has-show-more').hasClass('active')) {
                        $(this).text('Show Less');
                    } else {
                        $(this).text('Show More');
                    }
                });
            };
            $(document).on('click', '.rbt-show-more-btn', function () {
                $(this).hasShowMore();
            });
        },
        sidebarVideoHidden: function () {
            var scrollTop = $('.sidebar-video-hidden');
            $(window).scroll(function () {
                // declare variable
                var topPos = $(this).scrollTop();
                // if user scrolls down - show scroll to top button
                if (topPos > 250) {
                    $(scrollTop).css('display', 'none');
                } else {
                    $(scrollTop).css('display', 'block');
                }
            });
        },
        courseActionBottom: function () {
            var scrollBottom = $('.rbt-course-action-bottom');
            $(window).scroll(function () {
                var topPos = $(this).scrollTop();
                var targetPossition = $(document).height() * 0.66; 
                var filled = (($(document).scrollTop() + window.innerHeight) / $(document).height());
                if (topPos > targetPossition && filled != 1) {
                    $(scrollBottom).addClass('rbt-course-action-active');
                } else {
                    $(scrollBottom).removeClass('rbt-course-action-active')
                }
            });
        },
        topbarExpend: function () {
            var windowWidth = $(window).width(); {
                if (windowWidth < 1199) {
                    $('.top-bar-expended').on('click', function () {
                        $('.top-expended-activation').hasClass('active') ? ( $('.top-expended-activation').removeClass('active'), $('.top-expended-activation').find('.top-expended-wrapper').css({ height: '32px' }) ) : ($('.top-expended-activation').addClass('active'), $('.top-expended-activation').find('.top-expended-wrapper').css({ height: ($('.top-expended-inner')).outerHeight() + 'px' }))
                    })
                    $(window).on('hresize', function() {
                        $('.top-expended-activation').hasClass('active') && $('.top-expended-activation').find('.top-expended-inner').css({
                            height: ($('.top-expended-inner')).outerHeight() + 'px'
                        })
                    })
                }
            }
        },
        categoryOffcanvas: function () {
            var windowWidth = $(window).width();
            if (windowWidth < 1200) {
                $('.rbt-side-offcanvas-activation').on('click', function () {
                    $('.rbt-offcanvas-side-menu').addClass('active-offcanvas')
                })
                $('.rbt-close-offcanvas').on('click', function () {
                    $('.rbt-offcanvas-side-menu').removeClass('active-offcanvas')
                })
                $('.rbt-offcanvas-side-menu').on('click', function (e) {
                    e.target === this && $('.rbt-offcanvas-side-menu').removeClass('active-offcanvas');
                });
                $('.rbt-vertical-nav-list-wrapper .vertical-nav-item a').on('click', function (e) {
                    e.preventDefault();
                    $(this).siblings('.vartical-nav-content-menu-wrapper').toggleClass('active').slideToggle('400');
                    $(this).toggleClass('active')
                })
            }
        },
        moveAnimation: function () {
            $('.scene').each(function () {
                new Parallax($(this)[0]);
            });
        },
    }
    eduJs.i();
})(window, document, jQuery);