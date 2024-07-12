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
                <li class="breadcrumb-item"><a href="{{ asset('blogs') }}">Blogs</a></li>
                <li class="breadcrumb-item"><a href="{{ asset($parentIds->slug) }}">{{ $parentIds->name }}</a></li>
                @if($parentIds->id != $titleCate->id)
                <li class="breadcrumb-item"><a href="{{ asset($titleCate->slug) }}">{{ $titleCate->name }}</a></li>
                @endif
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
                <div class="header mb-4">
                    <span>Chuyên mục chính</span>
                </div>
                <ul class="highlight_topic">
                    @foreach($cateMenu as $val)
                    @if($val->children->isNotEmpty())
                    <li>
                        <label>
                            <img src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" alt="Android" width="36" height="36">
                            <h3>
                                <a href="{{ asset('blogs/'.$val->slug) }}">{{ $val->name }}</a>
                            </h3>
                            <i class="fa-solid fa-chevron-down"></i>
                        </label>
                        <div class="subtopic hide">
                            @foreach($val->children as $child)
                            <a href="{{ asset('blogs/'.$val->slug.'/'.$child->slug) }}">✓ {{ $child->name }}</a>
                            @endforeach
                        </div>
                    </li>
                    @else
                    <li>
                        <label>
                            <img src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" alt="Android" width="36" height="36">
                            <h3>
                                <a href="{{ asset('blogs/'.$val->slug) }}">{{ $val->name }}</a>
                            </h3>
                        </label>
                    </li>
                    @endif
                    @endforeach
                </ul>
                <!--  -->
                <div class="header mb-4">
                    <span>Bài viết cùng danh mục</span>
                </div>
                <div class="hot-news">
                    @foreach($sameCate as $val)
                    <div class="media">
                        <div class="media-left">
                            <a href="{{ asset('blogs/'.$val->slug) }}">
                                <img src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
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