"use strict";
// Class Definition
const loadApp = function() {
    // Main Posts
	const _mainPosts = () => {
        let url = window.location.href,
        type = url.split('/')[4],
        action = 'inactive',
        start_post = 0,
        limit_post = 8;
        if(type=='news') {
            $('#titlePage .col-lg-12').html(`<div class="title-wrapper">
                <h1 class="title mb--0 text-white">Semua Berita dan Informasi</h1>
            </div>`);
        } if(type=='video') {
            $('#titlePage .col-lg-12').html(`<div class="title-wrapper">
                <h1 class="title mb--0 text-white">Semua Video</h1>
            </div>`);
        } if(type=='gallery') {
            $('#titlePage .col-lg-12').html(`<div class="title-wrapper">
                <h1 class="title mb--0 text-white">Semua Album Galeri</h1>
            </div>`);
        }
        //load Ajax
        let _loadAjax = (start_post, limit_post) => {
            let bodyContent = '', i;
            for (i = 0; i < 4; i++) {
                let shortDescPlace = `<h6 class="placeholder-glow my-3"><span class="placeholder rounded col-4"></span></h6>`;
                if(type=='video' || type=='gallery') {
                    shortDescPlace = '';
                }
                bodyContent += `<div class="col-lg-3 col-md-4 col-12 col-placeholder">
                    <div class="rbt-card event-grid-card variation-01 rbt-hover bg-transparent px-3">
                        <div class="rbt-card-img">
                            <a href="javascript:void(0);" title="Card placeholder">
                                <svg class="bd-placeholder-img h-180px rounded" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                            </a>
                        </div>
                        ` +shortDescPlace+ `
                        <div class="rbt-card-body pt-0">
                            <h5 class="placeholder-glow">
                                <span class="placeholder rounded col-12"></span>
                                <span class="placeholder rounded col-8"></span>
                            </h5>
                            <h6 class="placeholder-glow">
                                <span class="placeholder rounded col-4 me-3"></span>
                                <span class="placeholder rounded col-4"></span>
                            </h6>
                        </div>
                    </div>
                </div>`;
            }
            $('#container-post .row').append(bodyContent);
            $.ajax({
                url: base_url+ "api/main_posts",
                headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
                type: 'GET',
                dataType: 'JSON',
                data: {
                    type,
                    start_post,
                    limit_post
                },
                success: function (data) {
                    // console.log(data.row.list);
                    let rows = data.row.list, count_all = data.row.count_all, ttlItem = start_post+limit_post;
                    if(count_all <= ttlItem) {
                        $('#row-load_newspaper').hide(), $('#btn-load_newspaper').hide();
                        action = 'active';
                    } else {
                        $('#row-load_newspaper').show(), $('#btn-load_newspaper').show();
                        action = 'inactive';
                    }
                    $.each(rows, function(key, row) {
                        let shortDesc = `<p class="rbt-card-text break-word text-row-limit-3 mb-3">` +row.short_desc+ `</p>`,
                            thumbPost = `<a href="` +row.link_url+ `" title="` +row.title+ `">
                                <img src="` +row.url_thumb+ `" class="h-180px" alt="` +row.thumb+ `">
                            </a>`;
                        if(type=='video' || type=='gallery') {
                            shortDesc = '';
                        } if(type=='video') {
                            thumbPost = `<div class="video-popup-wrapper">
                                <img class="w-100 rounded h-180px" src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                                <a class="rbt-btn rounded-player-2 sm-size-50px position-to-top" href="javascript:void(0);" title="` +row.title+ `" onclick="_showVideoModal('` +row.link_embed+ `');">
                                    <span class="play-icon"></span>
                                </a>
                            </div>`;
                        } if(type=='gallery') {
                            thumbPost = `<div class="video-popup-wrapper">
                                <img class="w-100 rounded h-180px" src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                                <a class="rbt-btn rounded-player-2 sm-size-50px position-to-top shadow" href="` +row.link_url+ `" title="` +row.title+ `">
                                    <i class="far fa-images gallery-icon ps-0 fs-24px"></i>
                                </a>
                            </div>`;
                        }
                        bodyContent += `<div class="col-lg-3 col-md-4 col-12">
                            <div class="rbt-card event-grid-card variation-01 rbt-hover bg-transparent p-0 mb-3">
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
                                    ` +shortDesc+ `
                                    <ul class="rbt-meta fs-4 my-4">
                                        <li><i class="feather-calendar"></i>` +row.date+ `</li>
                                        <li><i class="feather-user"></i>` +row.user+ `</li>
                                    </ul>
                                </div>
                            </div>
                        </div>`;
                    });
                    $('#container-post .row').append(bodyContent);
                    $('#container-post .row .col-placeholder').remove(), $('#preloader-loadmore_newspaper').hide();
                }, error: function (jqXHR, textStatus, errorThrown) {
                    console.log('Load data is error');
                }
            });
        }
        //Load Action Posts
        if(action == 'inactive') {
            action = 'active';
            _loadAjax(start_post, limit_post);
        }
        $('#btn-load_newspaper .btn-link_loadnewspaper').click(function(){
            $('#btn-load_newspaper').hide(), $('#preloader-loadmore_newspaper').show();
            action = 'active';
            start_post = start_post + limit_post;
            _loadAjax(start_post, limit_post);
        });
    }
    // Public Functions
    return {
        // public functions
        init: function() {
            _mainPosts();
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