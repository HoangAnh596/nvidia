$(document).ready(function() {
    $('.view-more-option').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.prd-view-more').css('max-height', '10000px'); // Thêm chiều cao cho content-cate
    });

    // nó nằm trong swiper-slide gallery-trigger
    // $('.gallery-trigger').on('click', function(e) {
    //     e.preventDefault();
    //     $('#imageModal').css('display', 'block');
    // });


    // Đảm bảo rằng ảnh chỉ được thêm vào modal một lần
    if ($('#imageModal .modal-content img').length === 0) {
        $('.gallery-trigger img').each(function() {
            const currentImage = $(this).clone();
            $('#imageModal .modal-content').append(currentImage);
        });
    }

    // Khi nhấn vào .gallery-trigger img, hiển thị modal và cuộn tới vị trí ảnh đã nhấp
    $('.gallery-trigger img').on('click', function(e) {
        e.preventDefault();

        const modal = $('#imageModal');
        const modalContent = modal.find('.modal-content'); // cuộn theo website luôn
        console.log("Modal Content Height:", modalContent.height());
        console.log("Modal Content Scroll Height:", modalContent[0].scrollHeight);
        // Hiển thị modal
        modal.css('display', 'block');

        // Đợi một thời gian ngắn để modal được hiển thị hoàn toàn
        setTimeout(() => {
            const clickedImageSrc = $(this).attr('src').trim();
            console.log("Clicked Image Src:", clickedImageSrc);
        
            const normalizedClickedImageSrc = clickedImageSrc.replace('/big/', '/');
            console.log("Normalized Clicked Image Src:", normalizedClickedImageSrc);
        
            let imageFound = false;
        
            // Đợi các ảnh được tải xong
            modalContent.find('img').on('load', function() {
                if (imageFound) return; // Nếu đã tìm thấy ảnh, không cần tiếp tục xử lý
        
                const imageSrc = $(this).attr('src').trim();
                const normalizedImageSrc = imageSrc.replace('/big/', '/');
                if (normalizedImageSrc === normalizedClickedImageSrc) {
                    imageFound = true;
                    const targetPosition = $(this).position().top + modalContent.scrollTop();
                    console.log("Target Image Position:", targetPosition);
        
                    modalContent.scrollTop(targetPosition);
                }
            }).each(function() {
                // Đảm bảo các ảnh chưa được tải xong thì cũng xử lý
                if (this.complete) $(this).load();
            });
        
            if (!imageFound) {
                console.error("Image not found in modal.");
            }
        }, 100);
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