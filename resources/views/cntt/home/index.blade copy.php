@extends('cntt.layouts.app')

@section('content')

<!-- Start Banner Hero -->
<div id="template-mo-zay-hero-carousel mt-44" class="carousel slide" data-bs-ride="carousel">
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
                            <a class="btn-carousel" href="">Read Blog</a>
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
                            <a class="btn-carousel" href="">Learn More</a>
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
                            <a class="btn-carousel" href="">Save the Date</a>
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
                            <a class="btn-carousel" href="">Save the Date</a>
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
<!-- @yield('main') -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-8 m-auto mb-0-title">
                <h2>
                    <a class="text-cate" href="/switch">Switch</a>
                </h2>
                <p>
                    AS cung cấp các sản phẩm thiết bị chuyển mạch <trong>Switch</trong> các hãng <strong>Cisco, Aruba, Juniper ..vv</strong> <br>
                    Số 1 Tại Việt Nam - Số Lượng Stock Lớn - Giá Tốt - Hỗ Trợ Kỹ Thuật và Bảo Hành Chu Đáo - Giao Hàng Nhanh Trên Toàn Quốc.
                </p>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="li-cate">
                    @foreach($categories as $item)
                    @if($item->parent_id == 1)
                    <a href="{{ $item->slug }}">
                        {{ $item->name }}
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
            @foreach($products as $item)
            <div class="col-12 col-md-3 mb-3">
                <div class="card h-100">
                    <a class="p-3 a-img" href="{{ $item->slug }}">
                        <img src="{{ \App\Http\Helpers\Helper::getPath($item->image) }}" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body pt-0">
                        <a href="{{ $item->slug }}" class="text-decoration-none text-dark">{{ $item->name }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-8 m-auto mb-0-title">
                <h2>
                    <a class="text-cate" href="/bo-phat-wifi">Bộ Phát Wifi</a>
                </h2>
                <p>
                <strong>NASVN</strong> phân phối các bộ phát wifi cho doanh nghiệp chính hãng Cisco, Aruba, Cambium, Maipu... Giá Tốt. <br>
                Cung cấp đầy đủ các dòng Wifi 5, Wifi 6, Wifi 6E hoạt động ổn định, hiệu suất mạnh mẽ, chịu tải cao, bảo mật, <br/> 
                và khả năng quản lý tập trung dễ dàng.
                </p>

            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="li-cate">
                    @foreach($categories as $item)
                    @if($item->parent_id == 2)
                    <a href="{{$item->slug}}">
                        {{ $item->name }}
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
            @foreach($proWifi as $item)
            <div class="col-12 col-md-3 mb-3">
                <div class="card h-100">
                    <a class="p-3 a-img" href="{{ $item->slug }}">
                        <img src="{{ \App\Http\Helpers\Helper::getPath('products',$item->image) }}" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body pt-0">
                        <a href="{{ $item->slug }}" class="text-decoration-none text-dark">{{ $item->name }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End Featured Product -->

@endsection