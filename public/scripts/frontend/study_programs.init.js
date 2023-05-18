"use strict";
// Class Definition
var rows;
const loadApp = function() {
    //Load List Program Studi
	const _loadNavStudyPrograms = () => {
        $('#titlePage').html(`<h6 class="rbt-title-style-2">PROGRAM STUDI</h6>`);
        let navContent = '';
        let i;
        navContent += `<ul class="dashboard-mainmenu rbt-default-sidebar-list">`;
        for (i = 0; i < 4; i++) {
            navContent += `
                <li>
                    <h5 class="placeholder-glow w-100 mb-0">
                        <span class="placeholder rounded col-12"></span>
                    </h5>
                </li>
            `;
        }
        navContent += `</ul>`;
        $('#sidebarNavContent').html(navContent);
        //load Ajax
        $.ajax({
            url: base_url+ "api/main_studyprograms",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                rows = data.row;
                navContent = '';
                navContent += `<ul class="dashboard-mainmenu rbt-default-sidebar-list">`;
                $.each(rows, function(key, row) {
                    let navActive = '', bodyContent = '';
                    if(key == 0 ) {
                        navActive = `active`;
                        bodyContent = `<div class="section-title">
                            <h4 class="rbt-title-style-3 title pb-3 mb--20">` +row.name+ `</h4>
                        </div>
                        <div class="content mb--30">
                            <a href="` +row.url_thumb+ `" class="image-popup" title="` +row.name+ `">
                                <img class="w-100 radius-10 shadow" src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                            </a>
                        </div>
                        <div class="description mt--30">` +row.description+ `</div>`;
                        $('#bodyNavContent').html(bodyContent);
                    }
                    navContent += `<li><a href="javascript:void(0);" title="` +row.name+ `" class="nav-list ` +navActive+ `" data-key="nav-` +row.id+ `"><i class="feather-arrow-right"></i><span>` +row.name+ `</span></a></li>`;
                });
                navContent += `</ul>`;
                $('#sidebarNavContent').html(navContent);
            }, complete: function(data) {
                $('.image-popup').magnificPopup({
                    type: 'image', closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                    image: {
                        verticalFit: true
                    },
                    zoom: {
                        enabled: true, duration: 150
                    },
                });
                // If Click Nav List
                $('#sidebarNavContent .nav-list').on("click", function (e) {
                    e.preventDefault();
                    $('#sidebarNavContent .nav-list.active').removeClass('active'), $(this).addClass('active');
                    let dataKey = $(this).attr('data-key');
                    let idp = parseInt(dataKey.split('-')[1]);
                    let objIndex = rows.findIndex((obj => obj.id == idp));
                    let bodyContent = `<div class="section-title">
                        <h4 class="rbt-title-style-3 title pb-3 mb--20">` +rows[objIndex].name+ `</h4>
                    </div>
                    <div class="content mb--30">
                        <a href="` +rows[objIndex].url_thumb+ `" class="image-popup" title="` +rows[objIndex].name+ `">
                            <img class="w-100 radius-10 shadow" src="` +rows[objIndex].url_thumb+ `" alt="` +rows[objIndex].thumb+ `">
                        </a>
                    </div>
                    <div class="description mt--30">` +rows[objIndex].description+ `</div>`;
                    $('#bodyNavContent').html(bodyContent);

                    $('.image-popup').magnificPopup({
                        type: 'image', closeOnContentClick: true, closeBtnInside: false, fixedContentPos: true,
                        image: {
                            verticalFit: true
                        },
                        zoom: {
                            enabled: true, duration: 150
                        },
                    });
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
            _loadNavStudyPrograms();
        }
    };
}();
// Class Initialization
jQuery(document).ready(function() {
    loadApp.init();
});