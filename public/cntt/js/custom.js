$(document).ready(function() {
    // Css reponsive mobile nav
    $('.nav-link-mb').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var id = $this.data('id');
        var $dropdownContent = $('#dropdown-content-' + id);
        // Ẩn tất cả các danh sách thả xuống ngoại trừ danh sách được nhấp
        $this.closest('li').siblings().find('.dropdown-content-mobile').hide();

        // Chuyển đổi nội dung và icon thả xuống
        $this.find('.icon-down').toggle();
        $this.find('.icon-up').toggle();
        $dropdownContent.toggle();
    });

    // var $searchToggle = $('#searchToggle');
    // var $faSearch = $('#faSearch');
    // var $faXmark = $('#faXmark');
    // var $modal = $('#templatemo_search');

    // $searchToggle.on('click', function(e) {
    //     console.log($searchToggle);
    //     e.preventDefault();
    //     if ($faSearch.css('display') !== 'none') {
    //         $faSearch.css('display', 'none');
    //         $faXmark.css('display', 'inline');
    //         $modal.modal('show'); // Hiển thị modal
    //     }
    // });

    // // Reset icons when the modal is hidden
    // $modal.on('hidden.bs.modal', function() {
    //     $faSearch.css('display', 'inline');
    //     $faXmark.css('display', 'none');
    // });


    // Xem thêm 
    $('.content-cate').each(function() {
        if ($(this).height() > 350) {
            $(this).find('.show-more').show();
        }
    });
    $('.show-more').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.content-cate').css('max-height', '10000px'); // Thêm chiều cao cho content-cate
    });

    $('.outstand-prod').each(function() {
        if ($(this).height() > 350) {
            $(this).find('.outstand-show-more').show();
        }
    });
    $('.outstand-show-more').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.outstand-prod').css('max-height', '10000px'); // Thêm chiều cao cho content-cate
    });

    // bộ lọc filter
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 100) {
            $('.ft-fixed').addClass('fixed-filter');
        } else {
            $('.ft-fixed').removeClass('fixed-filter');
        }
    });
    // Hiển thị/ẩn child-filter khi nhấp vào show-filter và thay đổi border
    $('.child-filter').hide();

    // Khi nút show-filter được nhấp
    $('.show-filter').on('click', function(e) {
        e.preventDefault();
        var index = $('.show-filter').index(this); // Lấy chỉ số của nút được nhấp
        var $childFilter = $('.child-filter').eq(index); // Lấy child-filter tương ứng

        // Kiểm tra xem child-filter hiện đang hiển thị hay ẩn
        if ($childFilter.is(':visible')) {
            $childFilter.hide(); // Nếu đang hiển thị, thì ẩn đi
        } else {
            $('.child-filter').hide(); // Ẩn tất cả các child-filter khác
            $childFilter.show(); // Hiển thị child-filter tương ứng
        }
    });

    // Đóng menu thả xuống khi nhấp vào bên ngoài
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.show-filter, .child-filter').length) {
            $('.child-filter').slideUp();
            // Loại bỏ border khi nhấp bên ngoài
            $('.show-filter').css('border', '');
        }
    });


    // Ẩn filter-button khi nhấp vào btn-filter-close
    $('.btn-filter-close').on('click', function(e) {
        e.preventDefault();
        $(this).closest('.filter-button').hide();
    });

    // Thêm hoặc loại bỏ lớp border-red khi nhấp vào btn-child-filter
    $('.btn-child-filter').on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('border-blue');
        $(this).closest('.child-filter').find('.filter-button').show();
    });
});

document.addEventListener("DOMContentLoaded", function() {

    // Xử lý menu ở website
    const navLinks = document.querySelectorAll('.nav-link-web');
    const dropdownContents = document.querySelectorAll('.dropdown-content');
    const submenus = document.querySelectorAll('.dropdown-sub');
    const defaultActive = document.querySelector('.dropdown-sub[data-default="true"]');

    navLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            const dropdown = this.nextElementSibling;
            if (dropdown && dropdown.classList.contains('dropdown-content')) {
                dropdown.style.display = 'block';
            }
        });

        link.addEventListener('mouseleave', function() {
            const dropdown = this.nextElementSibling;
            if (dropdown && dropdown.classList.contains('dropdown-content')) {
                dropdown.style.display = 'none';
                resetActiveSubmenu();
            }
        });

        const dropdownContent = link.nextElementSibling;
        if (dropdownContent && dropdownContent.classList.contains('dropdown-content')) {
            dropdownContent.addEventListener('mouseenter', function() {
                this.style.display = 'block';
            });

            dropdownContent.addEventListener('mouseleave', function() {
                this.style.display = 'none';
                resetActiveSubmenu();
            });
        }
    });

    submenus.forEach(submenu => {
        submenu.addEventListener('mouseenter', function() {
            this.classList.add('active');
        });

        submenu.addEventListener('mouseleave', function() {
            this.classList.remove('active');
        });
    });

    function resetActiveSubmenu() {
        submenus.forEach(submenu => {
            submenu.classList.remove('active');
        });
        if (defaultActive) {
            defaultActive.classList.add('active');
        }
    }

    // Js search
    var searchToggle = document.getElementById('searchToggleMenu');
    var faSearch = document.getElementById('faSearch');
    var faXmark = document.getElementById('faXmark');
    var modal = new bootstrap.Modal(document.getElementById('templatemo_search'));

    if (searchToggle && faSearch && faXmark) {
        searchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            if (faSearch.style.display !== 'none') {
                faSearch.style.display = 'none';
                faXmark.style.display = 'inline';
                modal.show(); // Hiển thị modal
            } else {
                faSearch.style.display = 'inline';
                faXmark.style.display = 'none';
                modal.hide(); // Hiển thị modal
            }
        });

        // Reset icons when the modal is hidden
        document.getElementById('templatemo_search').addEventListener('hidden.bs.modal', function() {
            faSearch.style.display = 'inline';
            faXmark.style.display = 'none';
        });
    } else {
        console.error('One or more elements are not found in the DOM.');
    }

});