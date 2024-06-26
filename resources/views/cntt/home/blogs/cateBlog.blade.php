@extends('cntt.layouts.app')
@section('content')
<div class="breadcrumb bgf5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            </div>
        </div>
    </div>
</div>
<section id="news-list">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="collection-title-news">
                    <span>
                        {{ $titleCate->name }}
                    </span>
                </div>
                @foreach($news as $item)
                <div class="row list-news">
                    <div class="col-lg-5">
                        <div class="media-left">
                            <a href="{{ asset('blogs/'.$item->slugParent.'/'.$item->slug) }}">
                                <img src="{{ \App\Http\Helpers\Helper::getPath($item->image) }}" alt="{{ $item->alt_img }}" title="{{ $item->title_img }}">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 padding-left-0">
                        <div class="media-body">
                            <a href="{{ asset('blogs/'.$item->slugParent.'/'.$item->slug) }}">{{ $item->name }}</a>
                            <span class="media-desc">{{ $item->desc }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <!--  -->
                <div class="header">
                    <span>Chuyên mục chính</span>
                </div>
                <!--  -->
                <div class="header">
                    <span>Bài viết Xem nhiều nhất</span>
                </div>
                <!--  -->
                <div class="header">
                    <span>Bài viết nổi bật</span>
                </div>
                <div class="header bgeee">
                    <span>Sản phẩm liên quan</span>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<style>
    .bgf5 {
        background: #f5f5f5 !important;
    }

    #breadcrumb {
        background: none;
        float: left;
        margin: 5px 0;
    }

    #breadcrumb span {
        line-height: 28px;
        position: relative;
        padding: 5px 0;
    }

    #breadcrumb>div>span>a>span {
        color: #333;
    }

    .collection-title-news span {
        font-size: 18px;
        color: #0068d9;
        padding: 8px 10px 8px 20px;
        display: block;
        float: left;
        width: 100%;
        border: #ccc solid 1px;
        border-left-width: 5px;
        margin: 0 0 15px;
        font-weight: 600;
    }

    #news-list .header {
        float: left;
        display: block;
        margin-bottom: 20px;
        width: 100%;
    }

    .header span {
        font-size: 18px;
        color: #333;
        padding: 8px 10px 8px 20px;
        display: block;
        float: left;
        width: 100%;
        border-left: 5px solid #0068d9;
        font-weight: bold;
    }

    .news_cate_hot {
        display: block;
        float: left;
        width: 100%;
        padding: 0;
    }

    .news_cate_hot li {
        list-style: none;
        display: inline-block;
    }

    .news_cate_hot li a {
        font-size: 0.9rem !important;
        color: #333;
        display: block;
        padding: 7px 5px;
        font-weight: 500 !important;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top: 10px;
        text-decoration: none;
    }

    .list-news .media-left {
        border: 1px solid #ddd;
        padding: 5px;
    }

    .list-news .media-left a {
        position: relative;
        display: block;
        width: 100%;
        height: 190px;
        overflow: hidden;
    }

    .list-news .media-left a img {
        transition: all ease .4s;
        object-fit: cover;
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
    }

    .list-news {
        margin-bottom: 20px;
    }

    #news-list .media-body a {
        font-size: 18px !important;
        color: #404041;
        line-height: 28px;
        margin-bottom: 10px;
        display: block;
        font-weight: bold !important;
        text-decoration: none;
    }

    .most-view {
        float: left;
        width: 100%;
        display: block;
        padding: 0;
    }

    .most-view li {
        list-style: none;
        line-height: 22px;
        margin: 10px 0;
    }

    .most-view li::before {
        content: "\2022";
        color: #0068d9;
        font-weight: 700;
        display: inline-block;
        width: 1em;
    }

    .most-view li a {
        color: #333;
        font-size: 1rem !important;
        text-decoration: none;
    }

    .hot-news {
        float: left;
        width: 100%;
        display: block;
    }

    .hot-news .media:first-child {
        margin-top: 10px;
    }

    .hot-news .media {
        display: block;
        width: 100%;
        float: left;
        margin-bottom: 15px;
    }

    .hot-news .media .media-left {
        width: 35%;
        float: left;
        margin-right: 10px;
    }

    img,
    table,
    iframe {
        max-width: 100%;
    }

    img,
    input,
    button {
        border: none;
    }

    img {
        vertical-align: middle;
    }

    .hot-news .media .media-right a {
        color: #333;
        font-size: 1rem !important;
        text-decoration: none;
    }

    .bgeee {
        background-color: #eee;
    }

    .related-products {
        float: left;
        width: 100%;
        border: 1px solid #eee;
        border-bottom: none;
    }

    .related-products .media-products {
        float: left;
        width: 100%;
        border-bottom: 1px solid #eee;
        padding: 10px;
    }

    .related-products .media-products .media-left {
        width: 35%;
        float: left;
        margin-right: 10px;
    }

    .related-products .media-right a {
        color: #333;
        font-size: 1rem !important;
        display: block;
        text-decoration: none;
    }

    .related-products .media-right .new-price {
        display: inline-block;
        padding: 2px 20px;
        background: #0068d9;
        color: #fff;
        font-size: 0.9rem;
        border-radius: 3px;
        margin-top: 7px;
    }

    @media (min-width: 992px) {
        .padding-left-0 {
            padding-left: 0 !important;
        }
    }
</style>
@endsection