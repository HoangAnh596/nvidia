$(document).ready(function() {
    $('.view-more-option').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.prd-view-more').css('max-height', '10000px'); // Thêm chiều cao cho content-cate
    });

    $('.gallery-trigger').on('click', function(e) {
        e.preventDefault();
        $('#imageModal').css('display', 'block');
    });

    $('.close').on('click', function() {
        $('#imageModal').css('display', 'none');
    });

    $(window).on('click', function(e) {
        if ($(e.target).is('#imageModal')) {
            $('#imageModal').css('display', 'none');
        }
    });


    
});
document.addEventListener('DOMContentLoaded', function() {
    var toggler = document.getElementsByClassName("caret");
    for (var i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function(e) {
            e.preventDefault();
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }
});
$('.filtering').slick({
    slidesToShow: 4,
    slidesToScroll: 4
});

var filtered = false;

$('.js-filter').on('click', function() {
    if (filtered === false) {
        $('.filtering').slick('slickFilter', ':even');
        $(this).text('Unfilter Slides');
        filtered = true;
    } else {
        $('.filtering').slick('slickUnfilter');
        $(this).text('Filter Slides');
        filtered = false;
    }
});