@extends('cntt.layouts.app')

@section('content')

<!-- Start Banner Hero -->
<div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="3"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active bl-carousel">
            <div class="container">
                <div class="h-90"></div>
                <div class="row">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left align-self-center">
                            <h3>Automotive</h3>
                            <h1>NVIDIA Wins Autonomous <br>Grand Challenge at CVPR</h1>
                            <p class="p-25">
                                The End-to-End Driving at Scale award showcases the use of <br>
                                generative AI for comprehensive self-driving models.
                            </p>
                            <a class="btn-carousel" href="/">Read Blog</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item wh-carousel">
            <div class="container">
                <div class="h-90"></div>
                <div class="row">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h3>Simulation</h3>
                            <h1>NVIDIA Omniverse <br>Microservices to <br>Supercharge Physical AI</h1>
                            <p class="p-25">
                                NVIDIA Omniverse Cloud Sensor RTX generates synthetic <br>
                                data to speed AI development of autonomous vehicles, <br>
                                robotic arms, mobile robots, humanoids, and smart spaces.
                            </p>
                            <a class="btn-carousel" href="/">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item wh-carousel">
            <div class="container">
                <div class="h-90"></div>
                <div class="row">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h3>AI</h3>
                            <h1>See Jensen Huang Live at <br>HPE Discover 2024</h1>
                            <p class="p-25">
                                Tune in to see NVIDIA’s founder and CEO join Antonio Neri, <br>
                                HPE’s CEO, live on stage for the HPE Discover keynote. <br>
                                Tuesday, June 18, 9:00 a.m. PT.
                            </p>
                            <a class="btn-carousel" href="/">Save the Date</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item bl-carousel">
            <div class="container">
                <div class="h-90"></div>
                <div class="row">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h3>Data Center</h3>
                            <h1>Latest MLPerf Results <br>Showcase Unprecedented <br>Performance</h1>
                            <p class="p-25">
                                The NVIDIA platform, powered by NVIDIA Hopper GPUs and <br>
                                NVIDIA Quantum-2 InfiniBand networking, delivered <br>
                                exceptional AI training performance in the latest MLPerf <br>
                                Training benchmarks.
                            </p>
                            <a class="btn-carousel" href="/">Save the Date</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            <a class="d-flex justify-content-center flex-fill mt-3" href="{{ $item->slug }}" title="{{ $item->name }}">
                <img class="rounded-circle img-fluid border lazyload" src="{{ asset($item->image) }}" data-src="{{ asset($item->image) }}" title="{{ $item->title_img }}" alt="{{ $item->alt_img }}">
            </a>
            <h2 class="mt-3 mb-3 d-flex flex-fill justify-content-center">
                <a href="{{ $item->slug }}" title="{{ $item->name }}">{{ $item->name }}</a>
            </h2>
        </div>
        @endforeach
        @endif
    </div>
</section>
<!-- End Danh mục sản phẩm -->

<!-- Begin Sản phẩm nổi bật -->
@if(!empty($categoriesWithProducts))
@foreach ($categoriesWithProducts as $data)
<section>
    <div class="container">
        <div class="row bg-cate mt-2 mb-3">
            @if(!empty($data['products']))
            <div class="col-md-3 text-cate" style="padding-left: 0;">
                <a class="btn-link ft-sw" href="{{ asset($data['category']->slug) }}" title="{{ $data['category']->name }}">{{ $data['category']->name }}</a>
            </div>
            <div class="col-md-9 d-flex align-items-center justify-content-end" style="padding-right: 0;">
                <ul class="nav nav-mb">
                    @foreach($data['category']->children as $child)
                    @if($child->is_menu == 1)
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="{{ $child->slug }}">{{ $child->name }}</a>
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
        <div class="row custom-row">
            @if(!empty($data['products']))
            @foreach($data['products'] as $product)
            <div class="col-w-5 col-xs-6 col-md-4 col-sm-6 mb-2">
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
                    <a class="btn-img" href="{{ $product->slug }}">
                        <img class="card-img-top img-size" src="{{ asset($newImagePath) }}" alt="{{ $mainImage->alt }}" title="{{ $mainImage->title }}">
                    </a>
                    <!-- srcset="/uploads/200_image.jpg 200w, /uploads/400_image.jpg 400w, /uploads/800_image.jpg 800w" -->
                    @else
                    <a class="btn-img" href="{{ $product->slug }}">
                        <img class="card-img-top lazyload img-size" src="{{ asset('storage/images/small/image-coming-soon.jpg') }}" data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" width="206" height="206" alt="Image Coming Soon" title="Image Coming Soon">
                    </a>
                    @endif
                    <div class="card-body">
                        <div class="text-center h-30">
                            @if($product->price == 0)
                            <span class="lien-he-price">Liên hệ</span>
                            @else
                            <a href="{{ $product->slug }}" class="text-decoration-none text-danger">{{ number_format($product->price, 0, ',', '.') }}đ </a>
                            @endif
                        </div>
                        <div class="text-dark hover-gr">
                            <a href="{{ $product->slug }}" class="text-decoration-none btn-link">{{ $product->name }}</a>
                        </div>
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
            @endif
        </div>
    </div>
</section>
@endforeach
@endif
<!-- End Sản phẩm nổi bật -->

<!-- End Featured Product -->
<!-- Begin Tin tức bài viết -->
<section>
    <div class="container">
        <div class="row bg-cate mt-2">
            <div class="col-md-3 text-cate" style="padding-left: 0;">
                <a class="btn-link ft-sw" href="/blogs">Tin Tức Công Nghệ</a>
            </div>
            <div class="col-md-9 d-flex align-items-center justify-content-end" style="padding-right: 0;">
                <ul class="nav nav-mb">
                    @foreach($cateBlogs as $child)
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="{{ asset('/blogs/' . $child->slug) }}">{{ $child->name }}</a>
                    </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="/blogs">Xem thêm</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container-fluid px-0 mt-3">
            <div class="owl-carousel owl-theme">
                @if(!empty($blogs))
                @foreach($blogs as $val)
                <div class="item">
                    <div class="card h-100 card-new">
                        <a class="btn-img-new" href="/blogs/{{ $val->slug }}">
                            <img class="card-img-top lazyload img-size" src="{{ asset($val->image) }}" data-src="{{ asset($val->image) }}" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
                        </a>
                        <div class="new-body">
                            <a href="/blogs/{{ $val->slug }}" class="text-decoration-none text-dark">
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
    .owl-theme .owl-dots .owl-dot.active span,.owl-theme .owl-dots .owl-dot:hover span {
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
            padding: 0px; /* Khoảng cách giữa các item */
        }
    }
</style>
@endsection
@section('js')
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
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