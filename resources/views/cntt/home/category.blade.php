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
<div class="container">
    <div class="row mt-3">
        @foreach($products as $val)
        @include('cntt.home.partials.products', ['val' => $val])
        @endforeach
        <div class="d-flex align-items-center justify-content-center nav-mb" style="padding-bottom:12px;">
            <a class="btn-link">Xem thêm sản phẩm</a>
        </div>
    </div>
    <div class="cate-prod mt-3">
        <div class="row">
            <div class="col-md-8">
                <div class="content-cate">
                    <div>
                        {!! $categoryParentFind->content !!}
                    </div>
                    <div class="align-items-center justify-content-center btn-show-more show-more" style="padding-bottom:12px;">
                        <a class="btn-link">Xem thêm <i class="fa-solid fa-chevron-down"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="outstand-prod">
                    <div class="bg-prod d-flex align-items-center">
                        <h2>Sản phẩm nổi bật</h2>
                    </div>
                    <div class="title-outstand-prod">
                        @foreach($prOutstand as $data)
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <a class="btn-outstand" href="{{ $data->slug }}">
                                    <img src="{{ \App\Http\Helpers\Helper::getPath($data->image) }}" class="card-img-top" alt="{{ $data->alt_img }}" title="{{ $data->title_img }}">
                                </a>
                            </div>
                            <div class="col-md-8 d-flex flex-column bd-highlight" style="height: 100px;">
                                <div class="bd-highlight">
                                    <a class="btn-link" href="{{ $data->slug }}">{{ $data->name }}</a>
                                </div>
                                <div class="bd-highlight">
                                    <a href="{{ $data->slug }}" class="text-decoration-none text-danger">{{ number_format($val->price, 0, ',', '.') }}đ</a>
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
                                        <li class="text-muted text-right">Yêu thích <i class="fa-solid fa-heart icon-heart"></i></li>
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
                <div class="outstand-prod">
                    <div class="bg-prod d-flex align-items-center">
                        <h2>Bạn cần báo giá tốt nhất</h2>
                    </div>
                    <div class="title-outstand-prod">
                        @foreach($prOutstand as $data)
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <a class="btn-outstand" href="{{ $data->slug }}">
                                    <img src="{{ \App\Http\Helpers\Helper::getPath($data->image) }}" class="card-img-top" alt="{{ $data->alt_img }}" title="{{ $data->title_img }}">
                                </a>
                            </div>
                            <div class="col-md-8 d-flex flex-column bd-highlight" style="height: 100px;">
                                <div class="bd-highlight">
                                    <a class="btn-link" href="{{ $data->slug }}">{{ $data->name }}</a>
                                </div>
                                <div class="bd-highlight">
                                    <a href="{{ $data->slug }}" class="text-decoration-none text-danger">{{ number_format($val->price, 0, ',', '.') }}đ</a>
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
                                        <li class="text-muted text-right">Yêu thích <i class="fa-solid fa-heart icon-heart"></i></li>
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
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
</style>
@endsection
@section('js')

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