$(document).ready(function() {
    $('.nav-link-web').on("click", function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        console.log(id);
        var $el = $('#dropdown-' + id);
        $('.dropdown-content').not($el).hide(); // Đóng tất cả các dropdown khác
        $el.toggle();
        // Thêm hoặc xóa lớp underline-blue
        $('.nav-link-web').not(this).removeClass('underline-gr');
        $(this).toggleClass('underline-gr');
    });

    // Sự kiện hover
    // $('.nav-link-web').on("mouseenter", function() {
    //     var id = $(this).data('id');
    //     var $el = $('#dropdown-' + id);
    //     $('.dropdown-content').not($el).hide(); // Đóng tất cả các dropdown khác
    //     $el.show();
    //     // Thêm lớp underline-blue khi hover
    //     $(this).addClass('underline-gr');
    // });

    // $('.nav-link-web').on("mouseleave", function() {
    //     var id = $(this).data('id');
    //     var $el = $('#dropdown-' + id);
    //     $el.hide();
    //     // Xóa lớp underline-blue khi không hover
    //     $(this).removeClass('underline-gr');
    // });

    // Ngăn chặn sự kiện nhấp chuột trên các phần tử con nổi lên trên phần tử gốc
    $('.dropdown-sub').on('click', function(e) {
        e.stopPropagation();
    });

    // Ẩn dropdown menu khi click ra ngoài
    $(document).on("click", function(e) {
        if (!$(e.target).closest('.nav-item').length) {
            $('.dropdown-content').hide();
            $('.nav-link-web').removeClass('underline-gr'); // Xóa gạch chân khi click ra ngoài
        }
    });


    $('.dropdown-sub .title-sub').on('click', function(e) {
        e.preventDefault();

        // Chuyển đổi lớp đang hoạt động trên phần tử .dropdown-sub gốc
        var parentDropdownSub = $(this).closest('.dropdown-sub');
        parentDropdownSub.toggleClass('active');
        // Thêm hoặc xóa lớp underline-blue
        $('.menu-lg-item').toggleClass('underline-green');

        $('.list-sub').on('click', function(e) {
            e.stopPropagation();
        });
        // Hide all other .list-sub elements
        $('.dropdown-sub').not(parentDropdownSub).removeClass('active');
    });

    // Đóng menu thả xuống khi nhấp vào bên ngoài
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown-sub').length) {
            $('.dropdown-sub').removeClass('active');
            $('.menu-lg-item').removeClass('underline-green');
        }
    });

    // Css reponsive mobile nav
    $('.nav-link-mb').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var id = $this.data('id');
        var $dropdownContent = $('#dropdown-content-' + id);
        // Hide all dropdowns except the clicked one
        $this.closest('li').siblings().find('.dropdown-content-mobile').hide();

        // Toggle the dropdown content and icons
        $this.find('.icon-down').toggle();
        $this.find('.icon-up').toggle();
        $dropdownContent.toggle();
    });

    // Xem thêm 
    $('.show-more').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.content-cate').css('max-height', '10000px'); // Thêm chiều cao cho content-cate
    });

    $('.outstand-show-more').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.outstand-prod').css('max-height', '10000px'); // Thêm chiều cao cho content-cate
    });

    // bộ lọc filter
    
    // Hiển thị/ẩn child-filter khi nhấp vào show-filter và thay đổi border
    $('.show-filter').on('click', function(e) {
        e.preventDefault();
        // Ẩn tất cả các child-filter khác
        $('.child-filter').not($(this).next('.child-filter')).slideUp();
        
        // Thay đổi border của show-filter hiện tại và loại bỏ border của các cái khác
        $('.show-filter').not(this).css('border', '');
        $(this).css('border', '1px solid #4a90e2');
        
        // Hiển thị/ẩn child-filter của show-filter hiện tại
        $(this).next('.child-filter').slideToggle(function() {
            if ($(this).is(':hidden')) {
                // Ẩn height-fil khi child-filter bị ẩn
                $('.height-fil').css('height', '');
            } else {
                // Hiển thị height-fil khi child-filter hiện
                $('.height-fil').css('height', '200px');
            }
        });
    });

    // Đóng menu thả xuống khi nhấp vào bên ngoài
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.show-filter, .child-filter').length) {
            $('.child-filter').slideUp();
            // Loại bỏ border khi nhấp bên ngoài
            $('.show-filter').css('border', '');
            // Ẩn height-fil khi nhấp bên ngoài
            $('.height-fil').css('height', '');
        }
    });


    // Hiển thị div filter-button khi nhấp vào child-nav và thay đổi text của show-filter
    // $('.child-nav a').on('click', function(e) {
    //     e.preventDefault();
    //     var text = $(this).text();
    //     var parentShowFilter = $(this).closest('.child-filter').prev('.show-filter');
    //     var currentText = parentShowFilter.text().split(' ')[0]; // Lấy text hiện tại trước dấu cách (không lấy phần sau dấu cách)
        
    //     if (currentText === 'Hãng' || currentText.includes('...')) {
    //         parentShowFilter.text(text);
    //     } else {
    //         parentShowFilter.text(currentText + ',...');
    //     }

    //     var parentFilterButton = $(this).closest('.child-filter').find('.filter-button'); // Sử dụng 'closest(.child-filter)'
    //     console.log(parentFilterButton);
    //     if (parentFilterButton.is(':visible')) {
    //         parentFilterButton.hide();
    //     } else {
    //         $('.filter-button').hide(); // Ẩn tất cả các filter-button khác
    //         parentFilterButton.show();  // Hiển thị filter-button của show-filter hiện tại
    //     }
    // });

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
    var splide = new Splide('.splide', {
        perPage: 1,
        rewind: true,
        pagination : false,
        arrows     : false,
    });

    splide.mount();
});
