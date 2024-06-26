@extends('cntt.layouts.app')

@section('content')

<div class="container pt-44">
    <div class="row">
        <div class="col-lg-12">
            <div id="breadcrumb">
                <div class="d-flex">
                    <h6 aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Switch</li>
                        </ol>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="desc-product">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-6">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @if(!empty($images))
                                    @foreach($images as $val)
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" alt="{{ $val->alt }}" title="{{ $val->title }}">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                                
                            </div>
                            <div class="col-lg-6">
                            <h1 class="h2">{{ $product->name }}</h1>
                                <p class="py-2">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <span class="list-inline-item text-dark">Rating 4.8 | 36 Comments</span>
                                </p>
                                <figure class="text-center">
                                    <img class="card-img img-fluid" src="{{ \App\Http\Helpers\Helper::getPath($product->image) }}" alt="{{ $product->alt_img }}" title="{{ $product->title_img }}" style="width: 70%">
                                </figure>
                                <div class="mt-3 mb-3">
                                    <p>Slug: {{ $product->slug}}</p>
                                    <p>Tiêu đề SEO: {{ $product->title_seo}}</p>
                                    <p>Từ khóa SEO: {{ $product->keyword_seo}}</p>
                                    <p>Chi tiết SEO: {{ $product->des_seo}}</p>
                                </div>
                                <form action="" method="GET">
                                    <input type="hidden" name="product-title" value="Activewear">
                                    <div class="row">
                                        <div class="col-auto">
                                            <p style="margin-top: 4px">✓ Giá List: <strong>${{$product->price}}</strong></p>
                                        </div>
                                        <div class="col-auto">
                                            <ul class="list-inline pb-3">
                                                <li class="list-inline-item text-right">
                                                    ✓ Số lượng
                                                    <input type="hidden" name="product-quanity" id="product-quanity" value="1">
                                                </li>
                                                <li class="list-inline-item"><span class="btn btn-success" id="btn-minus">-</span></li>
                                                <li class="list-inline-item"><span class="badge bg-secondary" id="var-value">1</span></li>
                                                <li class="list-inline-item"><span class="btn btn-success" id="btn-plus">+</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row pb-3">
                                        <div class="col d-grid">
                                            <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">Mua sản phẩm</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="mt-3 mb-3">
                                    <p>{!! $product->content !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<section class="py-3">
    <div class="container">
        <div class="row text-left p-2 pb-3">
            <h4>Sản phẩm liên quan</h4>
        </div>
        <!--Start Carousel Wrapper-->
        <div class="row filtering">
            @if(!empty($relatedProducts))
            @foreach($relatedProducts as $val)
            <div class="col-md-3 pb-3" style="width: 324px; padding: 0.5rem">
                <div class="card mb-4 product-wap rounded-0">
                    <a class="a-img" href="{{ $val->slug }}">
                        <img src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" class="img-fluid">
                    </a>
                    <div class="card-body">
                        <a href="" class="h3 text-decoration-none">{{ $val->name }}</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
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
    $('.filtering').slick({
        slidesToShow: 4,
        slidesToScroll: 4
    });

    var filtered = false;

    $('.js-filter').on('click', function() {
        if (filtered === false) {
            $('.filtering').slick('slickFilter', ':even');
            $(this).text('Unfilter Slides');
            filtered = true;
        } else {
            $('.filtering').slick('slickUnfilter');
            $(this).text('Filter Slides');
            filtered = false;
        }
    });
</script>
@endsection