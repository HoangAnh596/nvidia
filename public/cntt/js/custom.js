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

    var selectedFilters = {};   
    // Khi nút show-filter được nhấp
    $('.show-filter').on('click', function(e) {
        e.preventDefault();
        var $showFilter = $(this); // Lấy nút show-filter được nhấp
        var $childFilter = $showFilter.next('.child-filter'); // Lấy child-filter tương ứng
        // Kiểm tra xem child-filter hiện đang hiển thị hay ẩn
        if ($childFilter.is(':visible')) {
            $childFilter.hide(); // Nếu đang hiển thị, thì ẩn đi
        } else {
            // Ẩn tất cả các child-filter khác và xóa border-blue từ các show-filter không có btn-child-filter nào được chọn
            $('.child-filter').not($childFilter).hide().each(function() {
                var $siblingChildFilter = $(this);
                var $siblingShowFilter = $siblingChildFilter.prev('.show-filter');
                if ($siblingChildFilter.find('.btn-child-filter.border-blue').length === 0) {
                    $siblingShowFilter.removeClass('border-blue');
                }
            });

            $childFilter.show(); // Hiển thị child-filter tương ứng
            $showFilter.addClass('border-blue'); // Thêm border-blue cho nút hiện tại
        }
    });

    // Đóng menu thả xuống khi nhấp vào bên ngoài
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.show-filter, .child-filter').length) {
            $('.child-filter').slideUp();
            $('.show-filter').each(function() {
                var $showFilter = $(this);
                var $childFilter = $showFilter.next('.child-filter');
                if ($childFilter.find('.btn-child-filter.border-blue').length === 0) {
                    $showFilter.removeClass('border-blue'); // Xóa border-blue nếu không có btn-child-filter nào được chọn
                }
            });
        }
    });

    // Thêm hoặc loại bỏ lớp border-blue khi nhấp vào btn-child-filter
    $('.btn-child-filter').on('click', function(e) {
        e.preventDefault();
        var $btnChildFilter = $(this);
        $btnChildFilter.toggleClass('border-blue');
        $(this).closest('.child-filter').find('.filter-button').show();
        var $showFilter = $btnChildFilter.closest('.child-filter').prev('.show-filter');
        
        var filterName = $showFilter.attr('name');
        var filterValue = $btnChildFilter.attr('id');

        if ($btnChildFilter.hasClass('border-blue')) {
            // Nếu được chọn, thêm giá trị vào danh sách các bộ lọc đã chọn
            if (!selectedFilters[filterName]) {
                selectedFilters[filterName] = [];
            }
            selectedFilters[filterName].push(filterValue);
        } else {
            // Nếu bị bỏ chọn, xóa giá trị khỏi danh sách các bộ lọc đã chọn
            var index = selectedFilters[filterName].indexOf(filterValue);
            if (index > -1) {
                selectedFilters[filterName].splice(index, 1);
            }
            if (selectedFilters[filterName].length === 0) {
                delete selectedFilters[filterName]; // Xóa bộ lọc nếu không còn giá trị nào
            }
        }
    });

    // Ẩn tất cả các child-filter khi người dùng cuộn trang
    $(window).on('scroll', function() {
        $('.child-filter').hide();
        $('.show-filter').each(function() {
            var $showFilter = $(this);
            var $childFilter = $showFilter.next('.child-filter');
            if ($childFilter.find('.btn-child-filter.border-blue').length === 0) {
                $showFilter.removeClass('border-blue'); // Xóa border-blue nếu không có btn-child-filter nào được chọn
            }
        });
    });

    // Xử lý nút "Bỏ chọn"
    $('.btn-filter-close').on('click', function() {
        var $childFilter = $(this).closest('.child-filter');
        var $showFilter = $childFilter.prev('.show-filter');
        var filterName = $showFilter.attr('name');
        delete selectedFilters[filterName]; // Xóa bộ lọc đã chọn
        $childFilter.find('.btn-child-filter').removeClass('border-blue'); // Xóa border-blue từ tất cả btn-child-filter
        $childFilter.hide();
        $showFilter.removeClass('border-blue'); // Xóa border-blue từ show-filter tương ứng
        // Cập nhật URL
        var queryParams = Object.keys(selectedFilters).map(function(key) {
            return key + '=' + selectedFilters[key].join(',');
        }).join('&');

        var currentUrl = window.location.href.split('?')[0]; // Lấy URL hiện tại mà không có query parameters
        var newUrl = currentUrl + (queryParams ? '?' + queryParams : '');
        window.location.href = newUrl;
    });
    // Xử lý nút "Xem kết quả"
    $('.btn-filter-readmore').on('click', function() {
        var queryParams = Object.keys(selectedFilters).map(function(key) {
            return key + '=' + selectedFilters[key].join(',');
        }).join('&');// Chuyển đổi đối tượng bộ lọc đã chọn thành chuỗi query parameters
        
        var currentUrl = window.location.href.split('?')[0];
        var newUrl = currentUrl + '?' + queryParams;
        window.location.href = newUrl; // Chuyển hướng đến URL mới
    });

    // Khởi tạo trạng thái ban đầu từ query parameters
    function initFiltersFromUrl() {
        var queryParams = new URLSearchParams(window.location.search);

        queryParams.forEach(function(value, key) {
            var values = value.split(',');
            selectedFilters[key] = values;

            var $showFilter = $('.show-filter[name="' + key + '"]');
            $showFilter.addClass('border-blue');

            values.forEach(function(id) {
                var $btnChildFilter = $('.btn-child-filter[id="' + id + '"]');
                $btnChildFilter.addClass('border-blue');
            });
            // Hiển thị filter-button nếu có bất kỳ btn-child-filter nào được chọn
            var $childFilter = $showFilter.next('.child-filter');
            // $childFilter.show();
            if (values.length > 0) {
                $childFilter.find('.filter-button').show();
            }
        });
    }

    initFiltersFromUrl(); // Khởi tạo trạng thái từ URL khi trang được tải
});

document.addEventListener("DOMContentLoaded", function() {

    // Xử lý menu ở website
    const navLinks = document.querySelectorAll('.nav-link-web');
    const dropdownContents = document.querySelectorAll('.dropdown-content');
    
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
    const submenus = document.querySelectorAll('.dropdown-sub');
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