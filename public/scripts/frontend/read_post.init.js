"use strict";
// Class Definition
const loadApp = function() {
    //load Sidebar Widget - 01 
	const _sidebarWidget01 = () => {
        let url = window.location.href,
        slug = url.split('/')[4],
        limit_post = 4,
        sort_by = 'last',
        i,
        widgetContent = '';
        widgetContent += `<div class="inner">
            <h3 class="rbt-widget-title placeholder-glow">
                <span class="placeholder col-12 rounded"></span>
            </h3>
            <ul class="rbt-sidebar-list-wrapper recent-post-list">`;
        for (i = 0; i < 4; i++) {
            widgetContent += `<li class="align-items-start">
                <div class="thumbnail">
                    <a href="javascript:void(0);" title="Card placeholder">
                        <svg class="bd-placeholder-img" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                    </a>
                </div>
                <div class="content flex-grow-1">
                    <h5 class="placeholder-glow mb-0">
                        <span class="placeholder col-12 rounded"></span>
                    </h5>
                    <ul class="rbt-meta m-0">
                        <small class="title placeholder-glow">
                            <span class="placeholder col-6 rounded"></span>
                        </small>
                    </ul>
                </div>
            </li>`;
        }
        widgetContent += `</ul>
        </div>`;
        $('#sidebarWidget-01').append(widgetContent);
        $.ajax({
            url: base_url+ "api/widget_sidebar",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            dataType: 'JSON',
            data: {
                slug, limit_post, sort_by
            },
            success: function (data) {
                let widgetTitle = 'Berita & Informasi Terbaru', rows = data.row;
                if(rows[0].type == 'VIDEO') {
                    widgetTitle = 'Video Terbaru';
                } if(rows[0].type == 'GALLERY') {
                    widgetTitle = 'Galeri Terbaru';
                }
                widgetContent = '';
                widgetContent += `<div class="inner">
                    <h4 class="rbt-widget-title">` +widgetTitle+ `</h4>
                    <ul class="rbt-sidebar-list-wrapper recent-post-list">`;

                $.each(rows, function(key, row) {
                    widgetContent += `<li>
                        <div class="thumbnail">
                            <a href="` +row.link_url+ `" title="` +row.title+ `">
                                <img src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                            </a>
                        </div>
                        <div class="content">
                            <h6 class="title text-row-limit-2"><a href="` +row.link_url+ `" title="` +row.title+ `">` +row.title+ `</a></h6>
                            <ul class="rbt-meta">
                                <li><i class="feather-calendar"></i>` +row.date+ `</li>
                            </ul>
                        </div>
                    </li>`;
                });
                widgetContent += `</ul>
                </div>`;
                $('#sidebarWidget-01').html(widgetContent);
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log('Load data is error');
            }
        });
    }
    //load Sidebar Widget - 02 
	const _sidebarWidget02 = () => {
        let url = window.location.href,
        slug = url.split('/')[4],
        limit_post = 4,
        sort_by = 'Popular',
        i,
        widgetContent = '';
        widgetContent += `<div class="inner">
            <h3 class="rbt-widget-title placeholder-glow">
                <span class="placeholder col-12 rounded"></span>
            </h3>
            <ul class="rbt-sidebar-list-wrapper recent-post-list">`;
        for (i = 0; i < 4; i++) {
            widgetContent += `<li class="align-items-start">
                <div class="thumbnail">
                    <a href="javascript:void(0);" title="Card placeholder">
                        <svg class="bd-placeholder-img" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                    </a>
                </div>
                <div class="content flex-grow-1">
                    <h5 class="placeholder-glow mb-0">
                        <span class="placeholder col-12 rounded"></span>
                    </h5>
                    <ul class="rbt-meta m-0">
                        <small class="title placeholder-glow">
                            <span class="placeholder col-6 rounded"></span>
                        </small>
                    </ul>
                </div>
            </li>`;
        }
        widgetContent += `</ul>
        </div>`;
        $('#sidebarWidget-02').append(widgetContent);
        $.ajax({
            url: base_url+ "api/widget_sidebar",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            dataType: 'JSON',
            data: {
                slug, limit_post, sort_by
            },
            success: function (data) {
                let widgetTitle = 'Berita & Informasi Populer', rows = data.row;
                if(rows[0].type == 'VIDEO') {
                    widgetTitle = 'Video Populer';
                } if(rows[0].type == 'GALLERY') {
                    widgetTitle = 'Galeri Populer';
                }
                widgetContent = '';
                widgetContent += `<div class="inner">
                    <h4 class="rbt-widget-title">` +widgetTitle+ `</h4>
                    <ul class="rbt-sidebar-list-wrapper recent-post-list">`;

                $.each(rows, function(key, row) {
                    widgetContent += `<li>
                        <div class="thumbnail">
                            <a href="` +row.link_url+ `" title="` +row.title+ `">
                                <img src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                            </a>
                        </div>
                        <div class="content">
                            <h6 class="title text-row-limit-2"><a href="` +row.link_url+ `" title="` +row.title+ `">` +row.title+ `</a></h6>
                            <ul class="rbt-meta">
                                <li><i class="feather-calendar"></i>` +row.date+ `</li>
                            </ul>
                        </div>
                    </li>`;
                });
                widgetContent += `</ul>
                </div>`;
                $('#sidebarWidget-02').html(widgetContent);
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log('Load data is error');
            }
        });
    }
    // Public Functions
    return {
        // public functions
        init: function() {
            _sidebarWidget01(), _sidebarWidget02();
        }
    };
}();
// Class Initialization
jQuery(document).ready(function() {
    loadApp.init();
});