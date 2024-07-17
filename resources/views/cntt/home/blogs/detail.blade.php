@section('css')
<link rel="stylesheet" href="{{ asset('cntt/css/blog.css') }}">
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
                <li class="breadcrumb-item"><a href="{{ asset('/blogs/' . $titleCate->slug) }}">{{ $titleCate->name }}</a></li>
                <li class="breadcrumb-item">{{ $newArt->name }}</li>
            </ol>
        </nav>
    </div>
</div>
<section id="news-list">
    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-lg-8">
                <div class="news-body">
                    <h1>{{ $newArt->name }}</h1>
                    <div id="chi-tiet">{!! $newArt->content !!}</div>
                </div>
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
                <!--  -->
                <div class="head-blog mb-4">
                    <span>Bài viết cùng danh mục</span>
                </div>
                <div class="hot-news">
                    @foreach($sameCate as $val)
                    <div class="media">
                        <div class="media-left">
                            <a href="{{ asset('blogs/'.$val->slug) }}">
                                <img src="{{ asset($val->image) }}" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
                            </a>
                        </div>
                        <div class="media-right">
                            <a href="{{ asset('blogs/'.$val->slug) }}">{{ $val->name }}</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection