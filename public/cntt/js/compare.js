$(document).ready(function() {
    // bộ lọc filter
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 320) {
            $('.pro-compare').addClass('sticky-cp');
            $('.fixed-top').hide();
        } else {
            $('.pro-compare').removeClass('sticky-cp');
            $('.fixed-top').show();
        }
    });
});