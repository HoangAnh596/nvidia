@extends('cntt.layouts.app')

@section('content')

<!-- Start Banner Hero -->
<div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        @php
        $totalSlider = $sliders->count();
        @endphp

        @if($totalSlider > 0)
        @for($i = 0; $i < $totalSlider; $i++)
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}">
            </li>
            @endfor
            @endif
    </ol>
    <div class="carousel-inner">
        @if(!empty($sliders))
        @foreach($sliders as $index => $slider)
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }} {{ $slider->is_color == 1 ? 'wh-carousel' : 'bl-carousel' }}">
            <div class="container">
                <div class="h-90"></div>
                <div class="row">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{ asset($slider->image) }}" alt="{{ $slider->name }}">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left align-self-center">
                            <h1>{{ $slider->name }}</h1>
                            <h3>{{ $slider->title }}</h3>
                            <p class="p-25">{{ $slider->description }}</p>
                            <a class="btn-carousel" href="{{ asset($slider->url) }}">{{ $slider->url_text }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
        <i class="fas fa-chevron-left"></i>
    </a>
    <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
        <i class="fas fa-chevron-right"></i>
    </a>
</div>
<!-- End Banner Hero -->

<!-- Start Featured Product -->
<!-- Begin Danh mục sản phẩm -->
<section class="container">
    <div class="row hp-category justify-content-center">
        @if(!empty($categories))
        @foreach($categories as $item)
        <div class="col-lg-5 col-xs-6 col-md-4 col-sm-6">
            <a class="d-flex justify-content-center flex-fill mt-3" href="{{ asset($item->slug) }}" title="{{ $item->name }}">
                <img class="rounded-circle img-fluid border lazyload" src="{{ asset($item->image) }}" data-src="{{ asset($item->image) }}" title="{{ $item->title_img }}" alt="{{ $item->alt_img }}">
            </a>
            <h2 class="mt-3 mb-3 d-flex flex-fill justify-content-center">
                <a href="{{ asset($item->slug) }}" title="{{ $item->name }}">{{ $item->name }}</a>
            </h2>
        </div>
        @endforeach
        @endif
    </div>
</section>
<!-- End Danh mục sản phẩm -->

<!-- Begin Sản phẩm nổi bật -->
<section class="product-categories">
    <div class="container">
@if(!empty($categoriesWithProducts))
@foreach ($categoriesWithProducts as $data)
        <div class="row bg-cate mb-3">
            @if(!empty($data['products']))
            <div class="col-md-3 text-cate" style="padding-left: 0;">
                <a class="btn-link ft-sw" href="{{ asset($data['category']->slug) }}" title="{{ $data['category']->name }}">
                    <h2>{{ $data['category']->name }}</h2>
                </a>
            </div>
            <div class="col-md-9 d-flex align-items-center justify-content-end" style="padding-right: 0;">
                <ul class="nav nav-mb">
                    @foreach($data['category']->children as $child)
                    @if($child->is_menu == 1)
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="{{ asset('/' . $child->slug) }}">{{ $child->name }}</a>
                    </li>
                    @endif
                    @endforeach
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="{{ asset($data['category']->slug) }}" title="xem thêm">Xem thêm</a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
        <div class="row custom-row mb-4">
            @if(!empty($data['products']))
            @foreach($data['products'] as $product)
            <div class="col-w-5 col-xs-6 col-md-4 col-sm-6 mb-custom">
                <div class="card h-100">
                    @php
                    $mainImage = $product->product_images->firstWhere('main_img', 1);
                    @endphp

                    @if($mainImage)
                    @php
                    $imagePath = $mainImage->image;
                    $directory = dirname($imagePath);
                    $filename = basename($imagePath);
                    $newDirectory = $directory . '/small';
                    $newImagePath = $newDirectory . '/' . $filename;
                    @endphp
                    <a class="btn-img" href="{{ asset('/' . $product->slug) }}">
                        <img class="card-img-top img-size" src="{{ asset($newImagePath) }}" alt="{{ $mainImage->alt }}" title="{{ $mainImage->title }}">
                    </a>
                    <!-- srcset="/uploads/200_image.jpg 200w, /uploads/400_image.jpg 400w, /uploads/800_image.jpg 800w" -->
                    @else
                    <a class="btn-img" href="{{ asset('/' . $product->slug) }}">
                        <img class="card-img-top lazyload img-size" src="{{ asset('storage/images/small/image-coming-soon.jpg') }}" data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" width="206" height="206" alt="Image Coming Soon" title="Image Coming Soon">
                    </a>
                    @endif
                    <div class="card-body">
                        <div class="text-dark">
                            <a href="{{ asset('/' . $product->slug) }}" class="text-decoration-none btn-link">{{ $product->name }}</a>
                        </div>
                        <ul class="list-unstyled d-flex justify-content-between align-items-center total-review-home">
                            <li>
                                @if($product->price == 0)
                                <span class="lien-he-price">Liên hệ</span>
                                @else
                                <a href="{{ asset('/' . $product->slug) }}" class="text-decoration-none text-danger">{{ number_format($product->price, 0, ',', '.') }}đ </a>
                                @endif
                            </li>
                            <li class="text-muted text-right">
                                <i class="text-warning fa fa-star"></i>
                                <span>
                                    @if ($product->totalCmt > 0)
                                    {{ number_format($product->average_star, 1) }} ({{ $product->totalCmt }})
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        @endforeach
        @endif
    </div>
</section>
<!-- End Sản phẩm nổi bật -->

<!-- Begin Tin tức bài viết -->
<section>
    <div class="container">
        <div class="row bg-cate mt-2">
            <div class="col-md-3 text-cate" style="padding-left: 0;">
                <a class="btn-link ft-sw" href="{{ asset('/blogs') }}">Tin Tức Công Nghệ</a>
            </div>
            <div class="col-md-9 d-flex align-items-center justify-content-end" style="padding-right: 0;">
                <ul class="nav nav-mb">
                    @foreach($cateBlogs as $child)
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="{{ asset('/blogs/' . $child->slug) }}">{{ $child->name }}</a>
                    </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="{{ asset('/blogs') }}">Xem thêm</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container-fluid px-0 mt-4">
            <div class="owl-carousel owl-theme">
                @if(!empty($blogs))
                @foreach($blogs as $val)
                <div class="item">
                    <div class="card h-100 card-new">
                        <a class="btn-img-new" href="{{ asset('/blogs/' . $val->slug) }}">
                            <img class="card-img-top lazyload img-size" src="{{ asset($val->image) }}" data-src="{{ asset($val->image) }}" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
                        </a>
                        <div class="new-body">
                            <a href="{{ asset('/blogs/' . $val->slug) }}" class="text-decoration-none text-dark">
                                <h4>{{ $val->name }}</h4>
                            </a>
                        </div>
                        <p>{{ $val->desc }}</p>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
<!-- End Tin tức bài viết -->

<!-- Begin service -->
<section class="service-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>Tại sao chọn chúng tôi</h2>
            <span class="decor"></span>
        </div>
        <div class="row">
            <div class="service-item col-lg-4 col-md-4 sm-6">
                <div class="inner-box">
                    <div class="icon_box">
                        <img width="40" height="40" src="{{ asset('storage/images/ui_images/icon-san-pham.png') }}" alt="sản phẩm chính hãng">
                    </div>
                    <p class="why_us">Sản phẩm chính hãng</p>
                    <div class="text">
                        <p>Sản phẩm chính hãng từ nhà sản xuất</p>
                    </div>
                </div>
            </div>
            <div class="service-item col-lg-4 col-md-4 sm-6">
                <div class="inner-box">
                    <div class="icon_box">
                        <img width="40" height="40" src="{{ asset('storage/images/ui_images/icon-bao-hanh.png') }}" alt="Bảo hành chính hãng">
                    </div>
                    <p class="why_us">Bảo hành chính hãng</p>
                    <div class="text">
                        <p>Bảo hành sản phẩm chính hãng</p>
                    </div>
                </div>
            </div>
            <div class="service-item col-lg-4 col-md-4 sm-6">
                <div class="inner-box">
                    <div class="icon_box">
                        <img width="40" height="40" alt="Tư vấn tin cậy" src="{{ asset('storage/images/ui_images/icon-tu-van.png') }}">
                    </div>
                    <p class="why_us">Tư vấn tin cậy</p>
                    <div class="text">
                        <p>Tư vấn, giải đáp mọi thắc mắc</p>
                    </div>
                </div>
            </div>

            <div class="service-item col-lg-4 col-md-4 sm-6">
                <div class="inner-box">
                    <div class="icon_box">
                        <img width="40" height="40" alt="Giá cạnh tranh" src="{{ asset('storage/images/ui_images/icon-gia.png') }}">
                    </div>
                    <p class="why_us">Giá cả cạnh tranh</p>
                    <div class="text">
                        <p>Giá cạnh tranh, thấp nhất thị trường</p>
                    </div>
                </div>
            </div>

            <div class="service-item col-lg-4 col-md-4 sm-6">
                <div class="inner-box">
                    <div class="icon_box">
                        <img width="40" height="40" alt="Phục vụ chu đáo" src="{{ asset('storage/images/ui_images/icon-phuc-vu.png') }}">
                    </div>
                    <p class="why_us">Phục vụ chu đáo</p>
                    <div class="text">
                        <p>Đem đến sự hài lòng cho quý khách</p>
                    </div>
                </div>
            </div>

            <div class="service-item col-lg-4 col-md-4 sm-6">
                <div class="inner-box">
                    <div class="icon_box">
                        <img width="40" height="40" alt="Dịch vụ hoàn hảo" src="{{ asset('storage/images/ui_images/icon-dich-vu.png') }}">
                    </div>
                    <p class="why_us">Dịch vụ hoàn hảo</p>
                    <div class="text">
                        <p>Dịch vụ hoàn hảo từ A-Z</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End service -->

<!-- Begin service -->
<section class="partner-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>Đối tác của chúng tôi</h2>
            <span class="decor"></span>
        </div>
        <div class="partner-autoplay">
            @foreach($partners as $partner)
                <a href="{{ asset($partner->url) }}" class="img-partner" target="@if($partner->is_tab == 1) _blank @endif">
                    <img src="{{ asset($partner->image) }}" alt="{{ $partner->title }}">
                </a>
            @endforeach
        </div>
    </div>
</section>
<!-- End service -->
@endsection

@section('css')
<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
<style>
    .container-fluid {
        padding-left: 0;
        padding-right: 0;
    }

    .owl-carousel .item {
        padding: 4px;
        /* Khoảng cách giữa các item */
    }

    .owl-carousel .card {
        width: 100%;
        height: auto;
    }

    .owl-carousel .owl-nav button.owl-prev,
    .owl-carousel .owl-nav button.owl-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: #76b900;
        color: white;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .owl-carousel .owl-nav button.owl-prev:hover,
    .owl-carousel .owl-nav button.owl-next:hover {
        background-color: #76b900;
    }

    .owl-carousel .owl-nav button.owl-prev {
        left: -35px;
    }

    .owl-carousel .owl-nav button.owl-next {
        right: -35px;
    }

    .owl-carousel .owl-stage-outer {
        padding-bottom: 20px;
    }

    .owl-theme .owl-nav {
        margin-top: 0px;
    }

    .owl-theme .owl-dots .owl-dot.active span,
    .owl-theme .owl-dots .owl-dot:hover span {
        background: #76b900;
    }

    @media (max-width: 768px) {

        .owl-carousel .owl-nav button.owl-prev,
        .owl-carousel .owl-nav button.owl-next {
            width: 24px;
            height: 24px;
        }

        .owl-carousel .owl-nav button.owl-prev {
            left: 0;
        }

        .owl-carousel .owl-nav button.owl-next {
            right: 0;
        }

        .owl-carousel .item {
            padding: 0px;
            /* Khoảng cách giữa các item */
        }
    }
</style>
@endsection
@section('js')
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.partner-autoplay').slick({
            slidesToShow: 8,
            slidesToScroll: 3,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
            infinite: true,
            responsive: [
                {
                    breakpoint: 1200,  // Khi kích thước màn hình <= 480px
                    settings: {
                        slidesToShow: 7,  // Hiển thị 3 slide
                        slidesToScroll: 1 // Scroll 1 slide mỗi lần
                    }
                },
                {
                    breakpoint: 1024,  // Khi kích thước màn hình <= 480px
                    settings: {
                        slidesToShow: 5,  // Hiển thị 3 slide
                        slidesToScroll: 1 // Scroll 1 slide mỗi lần
                    }
                },
                {
                    breakpoint: 768,  // Khi kích thước màn hình <= 480px
                    settings: {
                        slidesToShow: 3,  // Hiển thị 3 slide
                        slidesToScroll: 1 // Scroll 1 slide mỗi lần
                    }
                }
            ]
        });
        $(".owl-carousel").owlCarousel({
            items: 4, // Số lượng item hiển thị
            loop: true,
            margin: 6,
            nav: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>', // Nút Previous
                '<i class="fas fa-chevron-right"></i>' // Nút Next
            ],
            responsive: {
                0: {
                    items: 2
                },
                800: {
                    items: 3
                },
                1100: {
                    items: 4
                }
            }
        });
    });
</script>
@endsection