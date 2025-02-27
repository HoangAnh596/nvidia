@extends('cntt.layouts.app')

@section('content')
<div class="bgeee" id="breadcrumb">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                @foreach ($allParents as $parent)
                <li class="breadcrumb-item"><a href="{{ asset($parent->slug) }}">{{ $parent->name }}</a></li>
                @endforeach
                <li class="breadcrumb-item">{{ $mainCate->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container">
    <div class="header-server">
        <div class="title-may-chu-server">
            <h1>Máy Chủ</h1>
        </div>
        <ul id="brands_server_carousel" class="brand-server owl-carousel owl-loaded owl-drag">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    <div class="owl-item">
                        <li><a href="{{ asset('server-cisco') }}" title="Máy Chủ Cisco"><img src="{{ asset('cntt/img/server/may-chu-hang-cisco.png') }}" alt="Máy chủ thương hiệu Cisco"></a></li>
                    </div>
                    <div class="owl-item">
                        <li><a href="{{ asset('server-lenovo') }}" title="Máy Chủ Lenovo ThinkSystem"><img src="{{ asset('cntt/img/server/may-chu-hang-lenovo-thinksystem.png') }}" alt="Máy chủ thương hiệu Lenovo ThinkSystem"></a></li>
                    </div>
                    <div class="owl-item">
                        <li><a href="{{ asset('server-supermicro') }}" title="Máy Chủ Supermicro"><img src="{{ asset('cntt/img/server/may-chu-hang-supermicro.png') }}" alt="Máy chủ thương hiệu Supermicro"></a></li>
                    </div>
                    <div class="owl-item">
                        <li><a href="{{ asset('server-nvidia') }}" title="Máy Chủ NVIDIA"><img src="{{ asset('cntt/img/server/may-chu-hang-nvidia.png') }}" alt="Máy chủ thương hiệu NVIDIA"></a></li>
                    </div>
                    <div class="owl-item">
                        <li><a href="{{ asset('server-intel') }}" title="Máy Chủ Intel"><img src="{{ asset('cntt/img/server/may-chu-hang-intel.png') }}" alt="Máy chủ thương hiệu intel"></a></li>
                    </div>
                    <div class="owl-item">
                        <li><a href="{{ asset('server-fujitsu') }}" title="Máy Chủ Fujitsu"><img src="{{ asset('cntt/img/server/may-chu-hang-fujitsu.png') }}" alt="Máy chủ thương hiệu fujitsu"></a></li>
                    </div>
                    <div class="owl-item">
                        <li><a href="{{ asset('server-dell') }}" title="Máy Chủ Dell"><img src="{{ asset('cntt/img/server/may-chu-hang-dell-emc.png') }}" alt="Máy chủ thương hiệu Dell"></a></li>
                    </div>
                    <div class="owl-item">
                        <li><a href="{{ asset('server-hpe') }}" title="Máy Chủ HPE"><img src="{{ asset('cntt/img/server/may-chu-hang-hpe.png') }}" alt="Máy chủ thương hiệu HP"></a></li>
                    </div>
                    <div class="owl-item">
                        <li><a href="{{ asset('server-h3c') }}" title="Máy Chủ H3C"><img src="{{ asset('cntt/img/server/may-chu-hang-h3c.png') }}" alt="Máy chủ thương hiệu H3C"></a></li>
                    </div>
                </div>
            </div>
            <div class="owl-nav"><span class="owl-prev"><i class="arrow left"></i></span><span class="owl-next"><i class="arrow right"></i></span></div>
            <div class="owl-dots disabled"></div>
        </ul>
    </div>
</div>

<div class="filter">
    <div class="container">
        @php
        $agent = new Jenssegers\Agent\Agent();
        @endphp
        <!-- Header -->
        <!-- begin navbar mobile -->
        @if($agent->isMobile())
        @if(!empty($filterCate))
        <div class="mobile-filter ft-fixed mt-3" data-url="{{ route('home.filters') }}">
            <div class="container" style="padding: 0;">
                <div class="splide">
                    <div class="splide__track">
                        <div class="splide__list">
                            <div class="splide__slide">
                                <button class="filter-item show-filter-mb" name="bộ lọc" aria-current="page">
                                    Bộ lọc
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13.2" height="15.2" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"></path>
                                    </svg>
                                </button>
                            </div>
                            @foreach ($filterCate as $filter)
                            <div class="splide__slide">
                                <button class="filter-item show-filter-mb" name="{{ $filter->slug }}" data-filter-id="{{ $filter->id }}" aria-current="page">{{ $filter->name }} <i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($filterCate as $filter)
            <div class="child-filter-mb" data-target="{{ $filter->id }}">
                <ul style="margin:0">
                    @foreach ($filter->valueFilters as $val)
                    <li class="nav-item child-nav" style="padding-bottom: 6px;">
                        <button class="btn-child-filter-mb" id="{{ $val->id }}" aria-current="page" href="javascript:void(0)">{{$val->key_word}}</button>
                    </li>
                    @endforeach
                    <div class="filter-button-mb filter-button-sticky">
                        <button href="javascript:void(0)" class="btn-filter-close-mb">Bỏ chọn</button>
                        <button href="javascript:filterPros();" class="btn-filter-readmore-mb">Xem <b class="total-reloading"> @if(!empty($total)) {{ $total }} @endif</b> kết quả</button>
                    </div>
                </ul>
            </div>
            @endforeach
        </div>
        @endif
        @else
        @if(!empty($filterCate))
        <div class="row web-filter mt-3" data-url="{{ route('home.filters') }}">
            <ul class="nav nav-filter">
                <div class="container cont-fixed">
                    <li class="nav-item">
                        <button class="filter-item show-filter top-filter" name="bộ lọc" aria-current="page">
                            Bộ lọc
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14.4" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                                <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"></path>
                            </svg>
                        </button>
                    </li>
                    <?php $countFilter = 0 ?>
                    @foreach ($filterCate as $fil)
                    <?php $countFilter++;
                    $countFilter ?>
                    <li class="nav-item">
                        @if($fil->top_filter == 1)
                        <button class="filter-item show-filter top-filter" name="{{ $fil->slug }}" aria-current="page">
                            {{ $fil->name }} <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        @elseif($fil->special == 1)
                        <button class="filter-item show-filter special-filter" name="{{ $fil->slug }}" aria-current="page">
                            {{ $fil->name }} <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        @else
                        <button class="filter-item show-filter" name="{{ $fil->slug }}" aria-current="page">
                            {{ $fil->name }} <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        @endif
                        @if ($countFilter > 4 && $countFilter < 8)
                            <ul class="child-filter filter-show-right">
                            <div class="arrow-filter-right"></div>
                            @if($fil->special == 1)
                            @foreach ($fil->valueFilters as $item)
                    <li class="nav-item child-nav">
                        <a class="btn-child-filter" id="{{ $item->id }}" data-href="{{ $item->search }}" href="{{ $cateParent->slug }}?{{ $fil->slug }}={{ $item->id }}" data-type="filters">{{ $item->key_word }}</a>
                    </li>
                    @endforeach
                    @endif
                    @foreach ($fil->valueFilters as $item)
                    <li class="nav-item child-nav">
                        <a class="btn-child-filter" id="{{ $item->id }}" data-href="{{ $item->search }}" href="{{ $cateParent->slug }}-{{ $item->search }}" data-type="filters">{{ $item->key_word }}</a>
                    </li>
                    @endforeach
                    <div class="filter-button filter-button-sticky">
                        <button href="javascript:void(0)" id="{{ $fil->id }}" class="btn-filter-close">Bỏ chọn</button>
                        <button href="javascript:filterPros();" id="{{ $fil->id }}" class="btn-filter-readmore">Xem <b class="total-reloading"> @if(!empty($total)) {{ $total }} @endif</b> kết quả</button>
                    </div>
            </ul>
            @else
            <ul class="child-filter">
                <div class="arrow-filter"></div>
                @if($fil->special == 1)
                @foreach ($fil->valueFilters as $item)
                <li class="nav-item child-nav">
                    <a class="btn-child-filter" id="{{ $item->id }}" data-href="{{ $item->search }}" href="{{ $cateParent->slug }}?{{ $fil->slug }}={{ $item->id }}" data-type="filters">{{ $item->key_word }}</a>
                </li>
                @endforeach
                @else
                @foreach ($fil->valueFilters as $item)
                <li class="nav-item child-nav">
                    <a class="btn-child-filter" id="{{ $item->id }}" data-href="{{ $item->search }}" href="{{ $cateParent->slug }}-{{ $item->search }}" data-type="filters">{{ $item->key_word }}</a>
                </li>
                @endforeach
                @endif
                <div class="filter-button filter-button-sticky">
                    <button href="javascript:void(0)" id="{{ $fil->id }}" class="btn-filter-close">Bỏ chọn</button>
                    <button href="javascript:filterPros();" id="{{ $fil->id }}" class="btn-filter-readmore">Xem <b class="total-reloading"> @if(!empty($total)) {{ $total }} @endif</b> kết quả</button>
                </div>
            </ul>
            @endif
            </li>
            @endforeach
        </div>
        @endif
        @endif
    </div>
</div>

<div class="container">
    @if(!empty($productFilters))
    <div class="row custom-row mt-3" id="product-data">
        @include('cntt.home.partials.products', ['products' => $productFilters])
    </div>
    <nav class="d-flex justify-content-center mt-3">
        {{ $productFilters->links() }}
    </nav>
    @else
    <div class="row custom-row" id="product-data">
        @foreach ($dataPro as $parentId => $group)
        <div class="mt-3 d-flex justify-content-between align-items-center">
            <a href="{{ asset($group['category_slug']) }}">
                <h2>{{ $group['category_name'] }}</h2>
            </a>
            <a class="btn-all" href="{{ asset($group['category_slug']) }}">Xem tất cả</a>
        </div>
        @include('cntt.home.partials.pro', ['gr' => $group])
        @endforeach
    </div>
    <nav class="d-flex justify-content-center mt-3">
        {{ $childCategories->links() }}
    </nav>
    @endif
    <div class="cate-prod mt-3">
        <div class="row">
            <div class="col-lg-8">
                <div class="content-cate mb-3">
                    <div>
                        {!! $mainCate->content !!}
                    </div>
                    <div class="align-items-center justify-content-center btn-show-more show-more pb-3">
                        <button class="btn-link">Xem thêm <i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                </div>
                @if ($mainCate->questionCate->isNotEmpty())
                <div class="box-question mb-3" id="boxFAQ">
                    <p class="title">Câu hỏi thường gặp</p>
                    <div class="accordion">
                        @foreach($mainCate->questionCate as $question)
                        <div class="mb-1">
                            <div class="b-button button__show-faq">
                                <p>{{ $question->title }}</p>
                                <div class="icon"><svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                        <path d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="accordion__content">
                                <div class="content-wrapper">{!! $question->content !!}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <!-- res-w100, res-dnone, outstand-prod -->
            <div class="col-lg-4">
                @if(!$newsQuery->isEmpty())
                <div class="outstand-prod mb-3">
                    <div class="head-blog mb-3">
                        <span>Tin tức, dịch vụ & giải pháp máy chủ</span>
                    </div>
                    <div class="title-outstand-prod">
                        @foreach($newsQuery as $data)
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a class="btn-img-outs" href="{{ asset('/blogs/' . $data->slug) }}">
                                    <img class="img-size" loading="lazy" src="{{ asset($data->image) }}" alt="{{ $data->alt_img }}" title="{{ $data->title_img }}">
                                </a>
                            </div>
                            <div class="col-md-8 mb-3 text-outstand">
                                <a class="btn-link" href="{{ asset('/blogs/' . $data->slug) }}">{{ $data->name }}</a>
                            </div>
                        </div>
                        @endforeach
                        <p class="see-more-news text-center">
                            <a target="_black" title="Xem thêm các tin tức, dịch vụ và giải pháp máy chủ tại Nvidia" href="{{ asset('/blogs/' . $newsQuery->first()->cateNews->slug) }}">Xem thêm các bài viết</a>
                        </p>
                    </div>
                </div>
                @endif
                <!-- Hotline -->
                <div class="support-prod new-prod mb-3">
                    <div class="bg-prod d-flex align-items-center">
                        <h2>Thông tin liên hệ</h2>
                    </div>
                    <div class="title-outstand-prod">
                        <div class="top-heading">Hỗ trợ kinh doanh <i class="fa-solid fa-money-check-dollar"></i></div>
                        <div class="contact-infor">
                            @foreach($phoneInfors as $val)
                            @if($val->role == 0)
                            <span class="user-heading"><i class="fa-solid fa-user-check"></i> {{ $val->name }}</span>
                            <div class="sp-online">
                                <span title="Mobile"><i class="fa-solid fa-headset"></i> {{ $val->phone }}</span>

                                <a href="{{ $val->skype }}" title="Chat với {{ $val->name }} qua Skype">
                                    <span class="i-skype"></span>
                                </a>
                                <a href="https://zalo.me/{{ $val->zalo }}" title="Chat {{ $val->name }} qua Zalo">
                                    <span class="i-zalo"></span>
                                </a>
                                <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }}" title="Gửi mail tới: {{ $val->name }}">
                                    <span class="i-gmail"></span>
                                </a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <div class="mt-3 top-heading">Hỗ trợ kỹ thuật <i class="fa-solid fa-gear"></i></div>
                        <div class="contact-infor">
                            @foreach($phoneInfors as $val)
                            @if($val->role == 1)
                            <span class="user-heading"><i class="fa-solid fa-user-check"></i> {{ $val->name }}</span>
                            <div class="sp-online">
                                <span title="Mobile"><i class="fa-solid fa-headset"></i> {{ $val->phone }}</span>

                                <a href="{{ $val->skype }}" title="Chat với {{ $val->name }} qua Skype">
                                    <span class="i-skype"></span>
                                </a>
                                <a href="https://zalo.me/{{ $val->zalo }}" title="Chat {{ $val->name }} qua Zalo">
                                    <span class="i-zalo"></span>
                                </a>
                                <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }}" title="Gửi mail tới: {{ $val->name }}">
                                    <span class="i-gmail"></span>
                                </a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('cntt/css/category.css')}}">
<link rel="stylesheet" href="{{asset('cntt/css/content.css')}}">
<link rel="stylesheet" href="{{asset('cntt/css/catePro.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
<style>
    .owl-carousel {
        z-index: unset;
    }

    .owl-nav,
    .owl-dots {
        display: none;
    }
</style>
@endsection
@section('js')
<script src="{{ asset('cntt/js/category.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script type="text/javascript">
    $(".owl-carousel").owlCarousel({
        items: 6, // Số lượng item hiển thị
        loop: true,
        margin: 15,
        nav: true,
        autoplay: true, // Bật tự động chạy slide
        autoplayTimeout: 3000, // Chuyển slide mỗi 3 giây
        autoplayHoverPause: true, // Tạm dừng khi di chuột vào
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            800: {
                items: 4
            },
            1100: {
                items: 6
            }
        }
    });
    // Nhúng danh sách slugs từ backend vào frontend
    var validSlugs = <?php echo json_encode($slugs); ?>;

    function getValidSlugFromUrl(validSlugs) {
        var currentUrl = window.location.href.split('?')[0];
        for (var i = 0; i < validSlugs.length; i++) {
            if (currentUrl.includes(validSlugs[i])) {
                return validSlugs[i];
            }
        }
        return null;
    }
    // Lấy slug hợp lệ từ URL
    var slug = getValidSlugFromUrl(validSlugs);
    document.addEventListener('DOMContentLoaded', function() {
        // Kiểm tra kích thước màn hình khi trang tải
        if (window.innerWidth < 1200) {
            // Tìm phần tử Splide
            var splideElement = document.querySelector('.splide');

            // Chỉ khởi tạo Splide nếu phần tử Splide tồn tại
            if (splideElement) {
                new Splide(splideElement, {
                    perPage: 1,
                    rewind: true,
                    pagination: false,
                    arrows: false,
                }).mount();
            }
        }
        var selectedFiltersMb = {};
        $(document).on('click', '.show-filter-mb', function(e) {
            e.preventDefault();
            var $showFilter = $(this); // Lấy nút show-filter được nhấp
            var index = $('.show-filter-mb').index($showFilter); // Lấy chỉ số của nút show-filter được nhấp
            var $childFilter = $('.child-filter-mb').eq(index); // Lấy child-filter tương ứng

            // Kiểm tra xem child-filter hiện đang hiển thị hay ẩn
            if ($childFilter.is(':visible')) {
                $childFilter.hide(); // Nếu đang hiển thị, thì ẩn đi
                $showFilter.removeClass('border-blue'); // Xóa border-blue nếu đang ẩn
            } else {
                // Ẩn tất cả các child-filter khác và xóa border-blue từ các show-filter không có btn-child-filter nào được chọn
                $('.child-filter-mb').each(function(i) {
                    var $siblingChildFilter = $(this);
                    var $siblingShowFilter = $('.show-filter-mb').eq(i);

                    // Kiểm tra nếu child-filter hiện tại đang hiển thị và không có btn-child-filter-mb nào được chọn
                    if ($siblingChildFilter.is(':visible') && $siblingChildFilter.find('.btn-child-filter-mb.border-blue').length === 0) {
                        $siblingChildFilter.hide(); // Ẩn child-filter hiện tại
                        $siblingShowFilter.removeClass('border-blue'); // Xóa border-blue từ nút show-filter-mb tương ứng
                    }
                });

                $childFilter.show(); // Hiển thị child-filter tương ứng
                $showFilter.addClass('border-blue'); // Thêm border-blue cho nút hiện tại
            }
        });

        // Đóng menu thả xuống khi nhấp vào bên ngoài
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.show-filter-mb, .child-filter-mb').length) {
                $('.child-filter-mb').slideUp(); // Ẩn tất cả các child-filter
                $('.show-filter-mb').each(function() {
                    var $showFilter = $(this);
                    var index = $('.show-filter-mb').index($showFilter); // Lấy chỉ số của nút show-filter
                    var $childFilter = $('.child-filter-mb').eq(index); // Lấy child-filter tương ứng

                    // Kiểm tra nếu không có btn-child-filter-mb nào được chọn
                    if ($childFilter.find('.btn-child-filter-mb.border-blue').length === 0) {
                        $showFilter.removeClass('border-blue'); // Xóa border-blue nếu không có btn-child-filter nào được chọn
                    }
                });
            }
        });

        // Thêm hoặc loại bỏ lớp border-blue khi nhấp vào btn-child-filter
        $('.btn-child-filter-mb').on('click', function(e) {
            e.preventDefault();
            var $btnChildFilter = $(this);
            $btnChildFilter.toggleClass('border-blue');
            $(this).closest('.child-filter-mb').find('.filter-button-mb').show();

            // Lấy giá trị data-target của .child-filter để tìm .show-filter tương ứng
            var targetId = $(this).closest('.child-filter-mb').data('target');

            // Tìm phần tử .show-filter trong tất cả các phần tử .splide__slide
            var $showFilter = $('.splide__slide').find('.show-filter-mb').filter(function() {
                return $(this).data('filter-id') === targetId;
            });
            var filterName = $showFilter.attr('name');
            var filterValue = $btnChildFilter.attr('id');

            if ($btnChildFilter.hasClass('border-blue')) {
                // Nếu được chọn, thêm giá trị vào danh sách các bộ lọc đã chọn
                if (!selectedFiltersMb[filterName]) {
                    selectedFiltersMb[filterName] = [];
                }
                selectedFiltersMb[filterName].push(filterValue);
            } else {
                // Nếu bị bỏ chọn, xóa giá trị khỏi danh sách các bộ lọc đã chọn
                var index = selectedFiltersMb[filterName].indexOf(filterValue);
                if (index > -1) {
                    selectedFiltersMb[filterName].splice(index, 1);
                }
                if (selectedFiltersMb[filterName].length === 0) {
                    delete selectedFiltersMb[filterName]; // Xóa bộ lọc nếu không còn giá trị nào
                }
            }

            // Gọi AJAX để gửi các bộ lọc đã chọn tới backend
            var filterUrlMb = $('.mobile-filter').data('url');
            $.ajax({
                url: filterUrlMb, // Đổi URL thành route xử lý filter của bạn
                type: 'GET',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    filters: selectedFiltersMb
                },
                success: function(response) {
                    // Xử lý phản hồi từ backend (ví dụ: cập nhật danh sách sản phẩm)
                    var $resultCount = $('.total-reloading');
                    var $readMoreButton = $('.btn-filter-readmore-mb');

                    $resultCount.text(response.count);

                    if (response.count === 0) {
                        $readMoreButton.prop('disabled', true); // Vô hiệu hóa nút nếu total bằng 0
                        $readMoreButton.addClass('disabled'); // Thêm lớp 'disabled' để áp dụng CSS
                    } else {
                        $readMoreButton.prop('disabled', false); // Kích hoạt nút nếu total khác 0
                        $readMoreButton.removeClass('disabled'); // Xóa lớp 'disabled' nếu có
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // Ẩn tất cả các child-filter khi người dùng cuộn trang
        $(window).on('scroll', function() {
            $('.child-filter-mb').hide();
            $('.show-filter-mb').each(function() {
                var $showFilter = $(this);
                var $childFilter = $showFilter.next('.child-filter-mb');
                if ($childFilter.find('.btn-child-filter-mb.border-blue').length === 0) {
                    $showFilter.removeClass('border-blue'); // Xóa border-blue nếu không có btn-child-filter nào được chọn
                }
            });
        });

        // Xử lý nút "Bỏ chọn"
        $('.btn-filter-close-mb').on('click', function() {
            // Tìm .child-filter tương ứng với nút "Bỏ chọn"
            var $childFilter = $(this).closest('.child-filter-mb');
            // Lấy targetId từ .child-filter
            var targetId = $childFilter.data('target');

            // Tìm .show-filter tương ứng với targetId
            var $showFilter = $('.show-filter-mb').filter(function() {
                return $(this).data('filter-id') == targetId;
            });
            var filterName = $showFilter.attr('name');
            delete selectedFiltersMb[filterName]; // Xóa bộ lọc đã chọn
            $childFilter.find('.btn-child-filter-mb').removeClass('border-blue'); // Xóa border-blue từ tất cả btn-child-filter
            $childFilter.hide();
            $showFilter.removeClass('border-blue'); // Xóa border-blue từ show-filter tương ứng
            // Cập nhật URL
            var queryParams = Object.keys(selectedFiltersMb).map(function(key) {
                return key + '=' + selectedFiltersMb[key].join(',');
            }).join('&');

            var currentUrl = window.location.href.split('?')[0]; // Lấy URL hiện tại mà không có query parameters
            var newUrl = currentUrl + (queryParams ? '?' + queryParams : '');
            window.location.href = newUrl;
        });

        // Xử lý nút "Xem kết quả"
        $('.btn-filter-readmore-mb').on('click', function() {
            var queryParams = Object.keys(selectedFiltersMb).map(function(key) {
                return key + '=' + selectedFiltersMb[key].join(',');
            }).join('&'); // Chuyển đổi đối tượng bộ lọc đã chọn thành chuỗi query parameters

            var currentUrl = window.location.href.split('?')[0];
            var newUrl = currentUrl + '?' + queryParams;
            window.location.href = newUrl; // Chuyển hướng đến URL mới
        });

        // Khởi tạo trạng thái ban đầu từ query parameters
        function initFiltersMbFromUrl() {
            var queryParams = new URLSearchParams(window.location.search);

            queryParams.forEach(function(value, key) {
                var values = value.split(',');
                selectedFiltersMb[key] = values;

                // Tìm và thêm class border-blue cho nút show-filter-mb tương ứng
                var $showFilter = $('.show-filter-mb[name="' + key + '"]');
                $showFilter.addClass('border-blue');
                values.forEach(function(id) {
                    var $btnChildFilter = $('.btn-child-filter-mb[id="' + id + '"]');
                    $btnChildFilter.addClass('border-blue');
                });
                // Hiển thị filter-button nếu có bất kỳ btn-child-filter nào được chọn
                var $childFilter = $('.child-filter-mb[data-target="' + key + '"]');
                if (values.length > 0) {
                    $childFilter.show();
                    $childFilter.find('.filter-button-mb').show();
                }
            });
        }

        initFiltersMbFromUrl();
    });

    // Kiểm tra kích thước màn hình khi cửa sổ thay đổi kích thước
    window.addEventListener('resize', function() {
        if (window.innerWidth < 1200) {
            // Tìm phần tử Splide
            var splideElement = document.querySelector('.splide');

            // Chỉ khởi tạo Splide nếu phần tử Splide tồn tại và chưa được khởi tạo
            if (splideElement && !splideElement.classList.contains('is-initialized')) {
                new Splide(splideElement, {
                    perPage: 1,
                    rewind: true,
                    pagination: false,
                    arrows: false,
                }).mount();

                // Đánh dấu phần tử đã được khởi tạo
                splideElement.classList.add('is-initialized');
            }
        }
    });
</script>
@endsection