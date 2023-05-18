"use strict";
// Class Definition
const loadApp = function() {
    //Load List Layanan
	const _loadServices = () => {
        $('#titlePage .col-lg-12').html(`<div class="title-wrapper">
            <h1 class="title mb--0 text-white">Layanan</h1>
        </div>`);
        let bodyContent = '';
        let i;
        for (i = 0; i < 4; i++) {
            if(i % 2 == 0){
                bodyContent += `<div class="row g-5 align-items-top mb--100">
                    <div class="col-lg-5">
                        <div class="content">
                            <a href="javascript:void(0);" title="Card placeholder">
                                <svg class="bd-placeholder-img h-345px rounded" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <h3 class="placeholder-glow mb-5">
                            <span class="placeholder rounded col-12"></span>
                        </h3>
                        <h6 class="placeholder-glow">
                            <span class="placeholder rounded col-12 mb-3"></span>
                            <span class="placeholder rounded col-6 mb-3"></span>
                            <span class="placeholder rounded col-4 mb-3"></span>
                            <span class="placeholder rounded col-8 mb-3"></span>
                        </h6>
                    </div>
                </div>`;
            } else {
                bodyContent += `<div class="row g-5 align-items-top mb--100">
                    <div class="col-lg-7">
                        <h3 class="placeholder-glow mb-5">
                            <span class="placeholder rounded col-12"></span>
                        </h3>
                        <h6 class="placeholder-glow">
                            <span class="placeholder rounded col-12 mb-3"></span>
                            <span class="placeholder rounded col-6 mb-3"></span>
                            <span class="placeholder rounded col-4 mb-3"></span>
                            <span class="placeholder rounded col-8 mb-3"></span>
                        </h6>
                    </div>
                    <div class="col-lg-5">
                        <div class="content">
                            <a href="javascript:void(0);" title="Card placeholder">
                                <svg class="bd-placeholder-img h-345px rounded" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                            </a>
                        </div>
                    </div>
                </div>`;
            }
        }
        $('#container-pages').html(bodyContent);
        //load Ajax
        $.ajax({
            url: base_url+ "api/main_services",
            headers: { 'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') },
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                let rows = data.row;
                bodyContent = '';
                $.each(rows, function(key, row) {
                    if(key % 2 == 0){
                        bodyContent += `<div class="row g-5 align-items-top mb--100">
                            <div class="col-lg-5">
                                <div class="content">
                                    <a href="` +row.url_thumb+ `" class="image-popup" title="` +row.name+ `">
                                        <img class="w-100 radius-10 shadow" src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="inner pl--0">
                                    <div class="section-title text-start">
                                        <h3 class="title">` +row.name+ `</h3>
                                    </div>
                                    <div class="description mt--20">` +row.description+ `</div>
                                </div>
                            </div>
                        </div>`;
                    } else{
                        bodyContent += `<div class="row g-5 align-items-top mb--100">
                            <div class="col-lg-7 order-2 order-lg-1">
                                <div class="inner pl--0">
                                    <div class="section-title text-start">
                                        <h3 class="title">` +row.name+ `</h3>
                                    </div>
                                    <div class="description mt--20">` +row.description+ `</div>
                                </div>
                            </div>
                            <div class="col-lg-5 order-1 order-lg-2">
                                <div class="content">
                                    <a href="` +row.url_thumb+ `" class="image-popup" title="` +row.name+ `">
                                        <img class="w-100 radius-10 shadow" src="` +row.url_thumb+ `" alt="` +row.thumb+ `">
                                    </a>
                                </div>
                            </div>
                        </div>`;
                    }
                });
                $('#container-pages').html(bodyContent);
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
            }, error: function (jqXHR, textStatus, errorThrown) {
                console.log('Load data is error');
            }
        });
    }
    // Public Functions
    return {
        // public functions
        init: function() {
            _loadServices();
        }
    };
}();
// Class Initialization
jQuery(document).ready(function() {
    loadApp.init();
});