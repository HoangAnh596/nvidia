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
                        <img class="img-fluid" src="{{asset('img/banner_img_01.jpg')}}" alt="">
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
                        <img class="img-fluid" src="{{asset('img/banner_img_02.jpg')}}" alt="">
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
                        <img class="img-fluid" src="{{asset('img/banner_img_03.jpg')}}" alt="">
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
                        <img class="img-fluid" src="{{asset('img/banner_img_03.jpg')}}" alt="">
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
    <div class="row hp-category">
        @foreach($categories as $item)
        <div class="col-lg-5 col-xs-6 col-md-6">
            <a class="d-flex justify-content-center flex-fill mt-4" href="{{ $item->slug }}" title="{{ $item->name }}">
            </a>
            <h2 class="mt-4 mb-3 d-flex flex-fill justify-content-center">
                <a href="{{ $item->slug }}" title="{{ $item->name }}">{{ $item->name }}</a>
            </h2>
        </div>
        @endforeach
    </div>
</section>
<!-- End Danh mục sản phẩm -->

<!-- Begin Sản phẩm nổi bật -->
@if(!empty($categoriesWithProducts))
@foreach ($categoriesWithProducts as $data)
<section>
    <div class="container">
        <div class="row bg-cate">
            <div class="col-md-3 text-cate" style="padding-left: 0;">
                <a class="btn-link ft-sw" href="" title="{{ $data['category']->name }}">{{ $data['category']->name }}</a>
            </div>
            <div class="col-md-9 d-flex align-items-center justify-content-end" style="padding-right: 0;">
                <ul class="nav nav-mb">
                    @foreach($data['category']->children as $child)
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="{{ $child->slug }}">{{ $child->name }}</a>
                    </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="" title="xem thêm">Xem thêm</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-4">
            @if(!empty($data['products']))
            @foreach($data['products'] as $value)
            <div class="col-lg-5 col-xs-6 col-md-6 mb-4">
                <div class="card h-100">
                    <a class="btn-img" href="{{ $value->slug }}" title="{{ $value->name }}">
                        <img src="{{ \App\Http\Helpers\Helper::getPath($value->image) }}" class="card-img-top" alt="{{ $value->alt_img }}" title="{{ $value->title_img }}">
                    </a>
                    <div class="card-body">
                        <div>
                            <a href="{{ $value->slug }}" class="text-decoration-none text-danger">{{ number_format($value->price, 0, ',', '.') }}đ</a>
                        </div>
                        <div class="text-dark">
                            <a href="{{ $value->slug }}" class="text-decoration-none" title="{{ $value->name }}">{{ $value->name }}</a>
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
        <div class="row bg-cate">
            <div class="col-md-3 text-cate" style="padding-left: 0;">
                <a class="btn-link ft-sw" href="/blogs">Tin Tức Công Nghệ</a>
            </div>
            <div class="col-md-9 d-flex align-items-center justify-content-end" style="padding-right: 0;">
                <ul class="nav nav-mb">
                    <li class="nav-item">
                        <a class="btn-link" aria-current="page" href="/blogs">Xem thêm</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mt-4">
            @if(!empty($blogs))
            @foreach($blogs as $val)
            <div class="col-12 col-md-3 mb-4">
                <div class="card h-100 card-new">
                    <a class="btn-img-new" href="/blogs/{{ $val->slug }}">
                        <img src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" class="card-img-top" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
                    </a>
                    <div class="card-body">
                        <a href="/blogs/{{ $val->slug }}" class="text-decoration-none text-dark">{{ $val->name }}</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

<!-- End Tin tức bài viết -->
@endsection