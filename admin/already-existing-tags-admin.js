jQuery(function($) {
    'use strict';
    $('#aet-filter-by-category').on('click', function() {
        $('#included-categories, #categories-container').toggleClass('softened');
        $('#categories-container-mask').toggleClass('active');
    });
});
