@extends('cntt.layouts.app')

@section('content')
<div class="pt-44" id="breadcrumb">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ asset($cateParent->slug) }}">{{ $cateParent->name }}</a></li>
                @if($categoryParentFind->id != $cateParent->id)
                <li class="breadcrumb-item active">{{ $categoryParentFind->name }}</li>
                @endif
            </ol>
        </nav>
    </div>
</div>
<div class="filter-cate">
    <div class="container">
        <div class="row bg-cate">
            <div style="padding-left: 0;">
                <h1>{{ $cateParent->name }}</h1>
            </div>
        </div>
        @if(!empty($filterCate))
        <div class="row d-flex align-items-center justify-content-end" style="padding-bottom:12px;">
            <ul class="nav nav-mb">
                @foreach($filterCate as $val)
                <li class="nav-item">
                    <a class="btn-link" aria-current="page" href="{{ $val->slug }}">{{ $val->name }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
<div class="filter">
    <div class="container">
        <div class="row">
            <div>
                <h1>Chọn theo tiêu chí</h1>
            </div>
        </div>
        <div class="mobile-filter">
            <div class="splide">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <button class="filter-item show-filter" aria-current="page">Giá <i class="fa-solid fa-chevron-down"></i></button>
                            
                            <div class="child-filter ">
                                <li class="nav-item child-nav">
                                    <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">Iphone</button>
                                </li>
                                <li class="nav-item child-nav">
                                    <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">Samsung</button>
                                </li>
                                <li class="nav-item child-nav">
                                    <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">Vivo</button>
                                </li>
                                <div class="filter-button filter-button-sticky">
                                    <button href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</button>
                                    <button href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</button>
                                </div>
                            </div>
                            <div class="height-fil"></div>
                        </div>
                        <div class="splide__slide">
                            <button class="filter-item show-filter" aria-current="page">Hãng <i class="fa-solid fa-chevron-down"></i></button>
                            
                            <div class="child-filter">
                                <li class="nav-item child-nav">
                                    <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">Iphone</button>
                                </li>
                                <li class="nav-item child-nav">
                                    <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">Samsung</button>
                                </li>
                                <li class="nav-item child-nav">
                                    <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">Vivo</button>
                                </li>
                                <div class="filter-button filter-button-sticky">
                                    <button href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</button>
                                    <button href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</button>
                                </div>
                            </div>
                            <div class="height-fil"></div>
                        </div>
                        <div class="splide__slide">
                            <button class="filter-item show-filter" aria-current="page">Ram <i class="fa-solid fa-chevron-down"></i></button>
                            <div class="child-filter" id="btn-f2">
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">3 GB</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">4 GB</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">5 GB</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">6 GB</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">8 GB</button>
                                </li>
                                <div class="filter-button filter-button-sticky">
                                    <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                                    <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                                </div>
                            </div>
                            <div class="height-fil"></div>
                        </div>
                        <div class="splide__slide">
                            <button class="filter-item show-filter" aria-current="page">Nhu cầu sử dụng <i class="fa-solid fa-chevron-down"></i></button>
                            <div class="child-filter">
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Học tập văn phòng</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Giải trí</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Đồ họa - Sáng tạo</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Chơi game</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Cho trẻ em</button>
                                </li>
                                <div class="filter-button filter-button-sticky">
                                    <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                                    <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                                </div>
                            </div>
                            <div class="height-fil"></div>
                        </div>
                        <div class="splide__slide">
                            <button class="filter-item show-filter" aria-current="page">Dung lượng sử dụng <i class="fa-solid fa-chevron-down"></i></button>
                            <div class="child-filter">
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Học tập văn phòng</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Giải trí</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Đồ họa - Sáng tạo</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Chơi game</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Cho trẻ em</button>
                                </li>
                                <div class="filter-button filter-button-sticky">
                                    <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                                    <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                                </div>
                            </div>
                        </div>
                        <div class="splide__slide splide-right">
                            <button class="filter-item show-filter" aria-current="page">Màn hình <i class="fa-solid fa-chevron-down"></i></button>
                            <div class="child-filter filter-show-right">
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Học tập văn phòng</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Giải trí</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Đồ họa - Sáng tạo</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Chơi game</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Cho trẻ em</button>
                                </li>
                                <div class="filter-button filter-button-sticky">
                                    <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                                    <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                                </div>
                            </div>
                            <div class="height-fil"></div>
                        </div>
                        <div class="splide__slide splide-right">
                            <button class="filter-item show-filter" aria-current="page">Tính năng đặc biệt<i class="fa-solid fa-chevron-down"></i></button>
                            <div class="child-filter filter-show-right">
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Kháng nước, bụi</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Hỗ trợ 5G</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Công nghệ NFC</button>
                                </li>
                                <li class="nav-item">
                                    <button class="btn-child-filter" aria-current="page">Bảo mật khuôn mặt</button>
                                </li>
                                <div class="filter-button filter-button-sticky">
                                    <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                                    <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                                </div>
                            </div>
                            <div class="height-fil"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row web-filter" style="padding-bottom:12px;">
            <ul class="nav nav-filter">
                <li class="nav-item">
                    <button class="filter-item" aria-current="page"><i class="fa-solid fa-filter"></i> Bộ lọc</button>
                </li>
                <li class="nav-item">
                    <button class="filter-item show-filter" aria-current="page">
                        <!-- <div class="arrow-filter"></div> -->
                        Hãng <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <ul class="child-filter">
                        <li class="nav-item child-nav">
                            <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">Iphone</button>
                        </li>
                        <li class="nav-item child-nav">
                            <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">Samsung</button>
                        </li>
                        <li class="nav-item child-nav">
                            <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">Vivo</button>
                        </li>
                        <div class="filter-button filter-button-sticky">
                            <button href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</button>
                            <button href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</button>
                        </div>
                    </ul>
                </li>
                <li class="nav-item">
                    <button class="filter-item show-filter" aria-current="page">Ram <i class="fa-solid fa-chevron-down"></i></button>
                    <ul class="child-filter">
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page">3 GB</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page">4 GB</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page">5 GB</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page">6 GB</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">8 GB</a>
                        </li>
                        <div class="filter-button filter-button-sticky">
                            <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                            <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                        </div>
                    </ul>
                </li>
                <li class="nav-item">
                    <button class="filter-item show-filter" aria-current="page">Nhu cầu sử dụng <i class="fa-solid fa-chevron-down"></i></button>
                    <ul class="child-filter">
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Học tập văn phòng</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Giải trí</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Đồ họa - Sáng tạo</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Chơi game</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Cho trẻ em</a>
                        </li>
                        <div class="filter-button filter-button-sticky">
                            <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                            <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                        </div>
                    </ul>
                </li>
                <li class="nav-item">
                    <button class="filter-item show-filter" aria-current="page">Dung lượng lưu trữ <i class="fa-solid fa-chevron-down"></i></button>
                    <ul class="child-filter filter-show-right">
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Học tập văn phòng</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Giải trí</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Đồ họa - Sáng tạo</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Chơi game</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Cho trẻ em</a>
                        </li>
                        <div class="filter-button filter-button-sticky">
                            <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                            <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                        </div>
                    </ul>
                </li>
                <li class="nav-item">
                    <button class="filter-item show-filter" aria-current="page">Màn hình <i class="fa-solid fa-chevron-down"></i></button>
                    <ul class="child-filter filter-show-right">
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Học tập văn phòng</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Giải trí</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Đồ họa - Sáng tạo</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Chơi game</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Cho trẻ em</a>
                        </li>
                        <div class="filter-button filter-button-sticky">
                            <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                            <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                        </div>
                    </ul>
                </li>
                <li class="nav-item">
                    <button class="filter-item show-filter" aria-current="page">Tính năng đặc biệt <i class="fa-solid fa-chevron-down"></i></button>
                    <ul class="child-filter filter-show-right">
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Học tập văn phòng</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Giải trí</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Đồ họa - Sáng tạo</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Chơi game</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-child-filter" aria-current="page" href="">Cho trẻ em</a>
                        </li>
                        <div class="filter-button filter-button-sticky">
                            <a href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</a>
                            <a href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</a>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="show-prod-cate">
        <div class="row mt-3" id="product-data">
            @include('cntt.home.partials.products', ['products' => $products])
        </div>
        <nav class="d-flex justify-content-center">
            {{ $products->links() }}
        </nav>
    </div>
    <div class="cate-prod mt-3">
        <div class="row">
            <div class="col-md-9">
                <div class="content-cate">
                    <div>
                        {!! $categoryParentFind->content !!}
                    </div>
                    <div class="align-items-center justify-content-center btn-show-more show-more" style="padding-bottom:12px;">
                        <a class="btn-link">Xem thêm <i class="fa-solid fa-chevron-down"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="outstand-prod">
                    <div class="bg-prod d-flex align-items-center">
                        <h2>Sản phẩm nổi bật</h2>
                    </div>
                    <div class="title-outstand-prod">
                        @foreach($prOutstand as $data)
                        <div class="row mt-3">
                            <div class="col-md-4" style="padding:0;">
                                <a class="btn-outstand" href="{{ $data->slug }}">
                                    <img src="{{ \App\Http\Helpers\Helper::getPath($data->image) }}" class="card-img-top" alt="{{ $data->alt_img }}" title="{{ $data->title_img }}">
                                </a>
                            </div>
                            <div class="col-md-8 d-flex flex-column bd-highlight" style="height: 100px;">
                                <div class="bd-highlight">
                                    <a class="btn-link" href="{{ $data->slug }}">{{ $data->name }}</a>
                                </div>
                                <div class="bd-highlight">
                                    <a href="{{ $data->slug }}" class="text-decoration-none text-danger">{{ number_format($data->price, 0, ',', '.') }}đ</a>
                                </div>
                                <div class="mt-auto bd-highlight">
                                    <ul class="list-unstyled d-flex justify-content-between">
                                        <li>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                        </li>
                                        <li class="text-muted text-right"><i class="fa-solid fa-heart icon-heart"></i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="align-items-center justify-content-center nav-mb outstand-show-more btn-show-more" style="padding-bottom:12px;">
                            <a class="btn-link">Xem thêm <i class="fa-solid fa-chevron-down"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Hotline -->
                <div class="support-prod new-prod">
                    <div class="bg-prod d-flex align-items-center">
                        <h2>Bạn cần báo giá tốt nhất</h2>
                    </div>
                    <div class="title-outstand-prod">
                        <div class="row mt-3">
                            <div><span class="top-heading">Hỗ trợ kinh doanh</span></div>
                            @foreach($phoneInfors as $val)
                            @if($val->role == 0)
                            <div class="contact-infor">
                                <span class="user-heading"> <i class="fa fa-user" aria-hidden="true"></i>{{ $val->name }}</span>
                                <div class="sp-online">
                                    <span title="Mobile"><i class="fa fa-phone" aria-hidden="true"></i>{{ $val->phone }}</span>

                                    <a href="{{ $val->skype }} " title="Chat với {{ $val->name }} qua Skype">
                                        <i class="i-skype"></i>
                                    </a>
                                    <a href="https://zalo.me/{{ $val->zalo }} " title="Chat {{ $val->name }} qua Zalo">
                                        <i class="i-zalo"></i>
                                    </a>
                                    <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }} " title="Gửi mail tới: {{ $val->name }} ">
                                        <i class="i-gmail"></i>
                                    </a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <div class="mt-3"><span class="top-heading">Hỗ trợ kỹ thuật</span></div>
                            @foreach($phoneInfors as $val)
                            @if($val->role == 1)
                            <div class="contact-infor">
                                <span class="user-heading"> <i class="fa fa-user" aria-hidden="true"></i>{{ $val->name }}</span>
                                <div class="sp-online">
                                    <span title="Mobile"><i class="fa fa-phone" aria-hidden="true"></i>{{ $val->phone }}</span>

                                    <a href="{{ $val->skype }} " title="Chat với {{ $val->name }} qua Skype">
                                        <i class="i-skype"></i>
                                    </a>
                                    <a href="https://zalo.me/{{ $val->zalo }} " title="Chat {{ $val->name }} qua Zalo">
                                        <i class="i-zalo"></i>
                                    </a>
                                    <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }} " title="Gửi mail tới: {{ $val->name }} ">
                                        <i class="i-gmail"></i>
                                    </a>
                                </div>
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

<style>
    .nested {
        display: none;
        margin-left: 1rem;
    }

    .caret {
        cursor: pointer;
        user-select: none;
        float: right;
    }

    .caret-down::before {
        transform: rotate(90deg);
        /* Down-pointing triangle */
    }

    .active {
        display: block;
        color: blue;
    }

    .new-prod {
        position: sticky;
        top: 50px;
        left: 0;
        width: 100%;
        z-index: 999;
    }
</style>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
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
</script>
@endsection