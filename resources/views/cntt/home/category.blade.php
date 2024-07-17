@extends('cntt.layouts.app')

@section('content')
<div class="pt-44" id="breadcrumb">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                @foreach ($allParents as $parent)
                <li class="breadcrumb-item"><a href="{{ asset($parent->slug) }}">{{ $parent->name }}</a></li>
                @endforeach
                <li class="breadcrumb-item">{{ $category->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<div class="filter">
    <div class="container">
        <div class="row mt-4">
            <h1>Chọn theo tiêu chí</h1>
        </div>
        @php
        $agent = new Jenssegers\Agent\Agent();
        @endphp
        <!-- Header -->
        <!-- begin navbar mobile -->
        @if($agent->isMobile())
        @if(!empty($filterCate))
        <div class="mobile-filter ft-fixed mt-4">
            <div class="container" style="padding: 0;">
                <div class="splide">
                    <div class="splide__track">
                        <div class="splide__list">
                            @foreach ($filterCate as $filter)
                            <div class="splide__slide">
                                <button class="filter-item show-filter" aria-current="page">{{ $filter->name }} <i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($filterCate as $filter)
            <div class="child-filter">
                <ul>
                    @foreach ($filter->valueFilters as $val)
                    <li class="nav-item child-nav">
                        <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">{{$val->key_word}}</button>
                    </li>
                    @endforeach
                </ul>
                <div class="filter-button filter-button-sticky">
                    <button href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</button>
                    <button href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</button>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        @else
        @if(!empty($filterCate))
        <div class="row web-filter mt-4">
            <ul class="nav nav-filter ft-fixed">
                <div class="container cont-fixed">
                    @foreach ($filterCate as $fil)
                    <li class="nav-item">
                        <button class="filter-item show-filter" aria-current="page">
                            {{ $fil->name }} <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        @if ($fil->is_direction == 0)
                        <ul class="child-filter">
                            @foreach ($fil->valueFilters as $item)
                            <li class="nav-item child-nav">
                                <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">{{ $item->key_word }}</button>
                            </li>
                            @endforeach
                            <div class="filter-button filter-button-sticky">
                                <button href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</button>
                                <button href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</button>
                            </div>
                        </ul>
                        @elseif ($fil->is_direction == 1)
                        <ul class="child-filter filter-show-right">
                            @foreach ($fil->valueFilters as $item)
                            <li class="nav-item child-nav">
                                <button class="btn-child-filter" aria-current="page" href="javascript:void(0)">{{ $item->key_word }}</button>
                            </li>
                            @endforeach
                            <div class="filter-button filter-button-sticky">
                                <button href="javascript:void(0)" class="btn-filter-close">Bỏ chọn</button>
                                <button href="javascript:filterPros();" class="btn-filter-readmore">Xem <b class="total-reloading">15</b> kết quả</button>
                            </div>
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </div>
            </ul>
        </div>
        @endif
        @endif
    </div>
</div>
<div class="container">
    <div class="show-prod-cate">
        <div class="row mt-4" id="product-data">
            @include('cntt.home.partials.products', ['products' => $products])
        </div>
        <nav class="d-flex justify-content-center">
            {{ $products->links() }}
        </nav>
    </div>
    <div class="cate-prod mt-2">
        <div class="row">
            <div class="col-md-9 res-w100">
                <div class="content-cate mb-4">
                    <div>
                        {!! $category->content !!}
                    </div>
                    <div class="align-items-center justify-content-center btn-show-more show-more pb-4">
                        <button class="btn-link">Xem thêm <i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 res-dnone">
                @if(!$prOutstand->isEmpty())
                <div class="outstand-prod mb-4">
                    <div class="bg-prod d-flex align-items-center">
                        <h2>Sản phẩm nổi bật</h2>
                    </div>
                    <div class="title-outstand-prod">
                        @foreach($prOutstand as $data)
                        <div class="row mt-3">
                            <div class="col-md-4 col-4" style="padding:0;">
                                <a class="btn-outstand" href="{{ $data->slug }}">
                                    <img src="{{ \App\Http\Helpers\Helper::getPath($data->image) }}" class="card-img-top" alt="{{ $data->alt_img }}" title="{{ $data->title_img }}">
                                </a>
                            </div>
                            <div class="col-md-8 col-8 d-flex flex-column bd-highlight" style="height: 100px; overflow: hidden;">
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
                        <div class="align-items-center justify-content-center nav-mb outstand-show-more btn-show-more pb-4">
                            <button class="btn-link">Xem thêm <i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                    </div>
                </div>
                @endif
                <!-- Hotline -->
                <div class="support-prod new-prod mb-4">
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
    .new-prod {
        position: sticky;
        top: 116px;
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
    var splide = new Splide('.splide', {
        perPage: 1,
        rewind: true,
        pagination: false,
        arrows: false,
    });

    splide.mount();
</script>
@endsection