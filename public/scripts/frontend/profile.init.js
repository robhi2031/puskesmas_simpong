"use strict";
// Class Initialization
jQuery(document).ready(function() {
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