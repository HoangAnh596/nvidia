@section('css')
<link rel="stylesheet" href="{{ asset('cntt/css/blog.css') }}">
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

@extends('cntt.layouts.app')
@section('content')
<div class="pt-44">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                @foreach ($allParents as $parent)
                    <li class="breadcrumb-item"><a href="{{ asset('/blogs/' . $parent->slug) }}">{{ $parent->name }}</a></li>
                @endforeach
                <li class="breadcrumb-item">{{ $titleCate->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<section id="news-list">
    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-lg-8">
                <div class="collection-title-news">
                    <span>
                        {{ $titleCate->name }}
                    </span>
                </div>
                @foreach($news as $item)
                <div class="row list-news mb-4">
                    <div class="col-md-5">
                        <div class="media-left">
                            <a href="{{ asset('blogs/'.$item->slug) }}">
                                <img class="lazyload" src="{{ asset($item->image) }}" data-src="{{ asset($item->image) }}" alt="{{ $item->alt_img }}" title="{{ $item->title_img }}">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7 padding-left-0">
                        <div class="media-body">
                            <a href="{{ asset('blogs/'.$item->slug) }}">{{ $item->name }}</a>
                            <span class="media-desc">{{ $item->desc }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <!--  -->
                <div class="head-blog mb-4">
                    <span>Chuyên mục chính</span>
                </div>
                <ul class="news_cate_hot">
                    @foreach($cateMenu as $val)
                    <li>
                        <a href="{{ asset('blogs/'.$val->slug) }}">✓ {{ $val->name }}</a>
                    </li>
                    @endforeach
                </ul>
                <!-- Bài viết xem nhiều nhất -->
                @if(!$viewer->isEmpty())
                <div class="head-blog mb-4">
                    <span>Bài viết Xem nhiều nhất</span>
                </div>
                <ul class="most-view">
                    @foreach($viewer as $item)
                    <li>
                        <a href="{{ asset('blogs/'.$item->slug) }}">{{ $item->name }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
                <!-- Bài viết nổi bật -->
                @if(!$outstand->isEmpty())
                <div class="head-blog mb-4">
                    <span>Bài viết nổi bật</span>
                </div>
                <div class="hot-news">
                    @foreach($outstand as $val)
                    <div class="media">
                        <div class="media-left">
                            <a href="{{ asset('blogs/'.$val->slug) }}">
                                <img class="lazyload" src="{{ asset($val->image) }}" data-src="{{ asset($val->image) }}" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
                            </a>
                        </div>
                        <div class="media-right">
                            <a href="{{ asset('blogs/'.$val->slug) }}">{{ $val->name }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                <!-- Sản phẩm liên quan -->
                @if(!empty($relatedPro))
                <div class="head-blog bgeee mb-4">
                    <span>Sản phẩm liên quan</span>
                </div>
                <div class="related-products">
                    @foreach($relatedPro as $value)
                    <div class="media-products">
                        <div class="media-left">
                            <a href="{{ asset('/'.$value->slug) }}">
                                <img class="lazyload" src="{{ asset($value->image) }}" data-src="{{ asset($value->image) }}" alt="{{ $value->alt_img }}" title="{{ $value->title_img }}">
                            </a>
                        </div>
                        <div class="media-right">
                            <a href="{{ asset('/'.$value->slug) }}">{{ $value->name }}</a>
                            <span class="new-price">Liên hệ</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection