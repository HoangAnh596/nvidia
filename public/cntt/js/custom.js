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
});
