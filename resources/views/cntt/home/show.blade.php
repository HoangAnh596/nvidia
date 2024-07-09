@section('css')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<link rel="stylesheet" href="{{ asset('cntt/css/product.css') }}">

@endsection
@extends('cntt.layouts.app')

@section('content')

<div class="pt-44">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '»';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                @foreach($uniqueCategories as $category)
                <li class="breadcrumb-item"><a href="{{ asset($category->slug) }}">{{ $category->name }}</a></li>
                @endforeach
            </ol>
        </nav>
    </div>
</div>
<div class="container">
        <div class="row mt-4 equal-height">
            <div class="col-lg-9">
                <div class="chi-tiet-sp">
                    <div class="row">
                        <div class="col-lg-6">
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide gallery-trigger">
                                        <img class="prod-img" src="{{ \App\Http\Helpers\Helper::getPath($product->image) }}" alt="{{ $product->alt }}" title="{{ $product->title }}">
                                    </div>
                                    @if(!empty($images))
                                    @foreach ($images as $val)
                                    <div class="swiper-slide gallery-trigger">
                                        <img class="prod-img" src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" alt="{{ $val->alt }}" title="{{ $val->title }}">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <div thumbsSlider="" class="swiper mySwiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide gallery-trigger">
                                        <img class="prod-img" src="{{ \App\Http\Helpers\Helper::getPath($product->image) }}" alt="{{ $product->alt }}" title="{{ $product->title }}">
                                    </div>
                                    @if(!empty($images))
                                    @foreach ($images as $img)
                                    <div class="swiper-slide">
                                        <img class="prod-img" src="{{ \App\Http\Helpers\Helper::getPath($img->image) }}" alt="{{ $img->alt }}" title="{{ $img->title }}">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div id="imageModal" class="modal">
                                <button class="close btn btn-success">x Đóng</button>
                                <div class="modal-content">
                                    <img class="modal-image" src="{{ \App\Http\Helpers\Helper::getPath($product->image) }}" alt="{{ $product->alt }}" title="{{ $product->title }}">
                                    @if(!empty($images))
                                    @foreach($images as $image)
                                        <img class="modal-image" src="{{ \App\Http\Helpers\Helper::getPath($image->image) }}" alt="{{ $image->alt }}" title="{{ $image->title }}">
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <!-- <div class="containerwiper">
                                @if(!empty($images))
                                <div class="swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($images as $val)
                                        <div class="swiper-slide gallery-trigger">
                                            <img class="prod-img" src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" alt="{{ $val->alt }}" title="{{ $val->title }}">
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                                @if(!empty($images->first()))
                                <div class="view-more-image">
                                    <button href="#" class="pop-gallery">
                                        <img alt="Xem {{ $images->count() }} ảnh sản phẩm" width="96" height="72" src="{{ $images->first()->image }}" data-src="{{ $images->first()->image }}" data-srcset="{{ $images->first()->image }}" srcset="{{ $images->first()->image }}">
                                        <div class="over-gallery gallery-trigger">Xem {{ $images->count() }} hình</div>
                                    </button>
                                </div>
                                @endif
                                <div id="imageModal" class="modal">
                                    <button class="close">x Đóng</button>
                                    <div class="modal-content">
                                        @foreach($images as $image)
                                            <img src="{{ $image->image }}" alt="Hình ảnh sản phẩm" class="modal-image">
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                <div class="col-viewmore-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                        <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                                    </svg>
                                    <div class="title-spec">
                                        <a href="#comment-box">
                                            49 bình luận <br> sản phẩm. </a>
                                    </div>
                                </div>
                                <div class="col-viewmore-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                    </svg>
                                    <div class="title-spec">
                                        <a href="#comment-box">
                                            49 đánh giá <br> sản phẩm. </a>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                        <div class="col-lg-6">
                            <div class="content-des">
                                <h1>{{ $product->name }}</h1>
                                <div class="product-des">{!! $product->des !!}</div>
                                <div class="fk-main">
                                    <span>✓ Mã sản phẩm:</span>
                                    <span>{{ $product->code }}</span>
                                </div>
                                <div class="fk-main">
                                    <span>✓ Tình trạng:</span>
                                    <span>@if($product->status == 1) Còn hàng @else Hết hàng @endif</span>
                                </div>
                                <!-- <div class="more-info">
                                    <a title="Video Cấu hình {{ $product->code }}" target="_blank" class="video_cauhinh" href="https://youtube.com/playlist?list=PLjFKMySyUTMwjBQLLVF_xoLtBvO2To2Au">Video Cấu Hình</a>
                                    <a title="Hướng Dẫn Cấu Hình {{ $product->code }}" target="_blank" class="huong_dan_cau_hinh" href="blogs">Hướng Dẫn Cấu Hình</a>
                                    <a title="Hỏi đáp sản phẩm {{ $product->code }}" target="_blank" class="hoi_dap_san_pham" href="https://www.facebook.com/groups/cnttshop.community">Hỏi Đáp Sản Phẩm</a>
                                </div> -->
                                <div class="price">
                                    <button title="Liên hệ để để được báo giá bán tốt nhất!" class="contact-price" onclick="showmodal('C9300-48P-E');">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-hand-index-thumb" viewBox="0 0 16 16">
                                            <path d="M6.75 1a.75.75 0 0 1 .75.75V8a.5.5 0 0 0 1 0V5.467l.086-.004c.317-.012.637-.008.816.027.134.027.294.096.448.182.077.042.15.147.15.314V8a.5.5 0 0 0 1 0V6.435l.106-.01c.316-.024.584-.01.708.04.118.046.3.207.486.43.081.096.15.19.2.259V8.5a.5.5 0 1 0 1 0v-1h.342a1 1 0 0 1 .995 1.1l-.271 2.715a2.5 2.5 0 0 1-.317.991l-1.395 2.442a.5.5 0 0 1-.434.252H6.118a.5.5 0 0 1-.447-.276l-1.232-2.465-2.512-4.185a.517.517 0 0 1 .809-.631l2.41 2.41A.5.5 0 0 0 6 9.5V1.75A.75.75 0 0 1 6.75 1zM8.5 4.466V1.75a1.75 1.75 0 1 0-3.5 0v6.543L3.443 6.736A1.517 1.517 0 0 0 1.07 8.588l2.491 4.153 1.215 2.43A1.5 1.5 0 0 0 6.118 16h6.302a1.5 1.5 0 0 0 1.302-.756l1.395-2.441a3.5 3.5 0 0 0 .444-1.389l.271-2.715a2 2 0 0 0-1.99-2.199h-.581a5.114 5.114 0 0 0-.195-.248c-.191-.229-.51-.568-.88-.716-.364-.146-.846-.132-1.158-.108l-.132.012a1.26 1.26 0 0 0-.56-.642 2.632 2.632 0 0 0-.738-.288c-.31-.062-.739-.058-1.05-.046l-.048.002zm2.094 2.025z"></path>
                                        </svg>
                                        <span>Giá bán liên hệ</span>
                                    </button>
                                    <a title="Xem giá list sản phẩm C9300-48P-E" class="check-list-btn" target="_blank" href="/gia-list?key=C9300-48P-E">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                            <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"></path>
                                        </svg> Check Giá List
                                    </a>
                                </div>
                                <a class="datasheet-prd" title="Datasheet C9300-48P-E" href="/storage/Datasheet/Cisco/Cisco-Catalyst-9300-datasheet.pdf" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-file-earmark-bar-graph" viewBox="0 0 16 16">
                                        <path d="M10 13.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-6a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v6zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z"></path>
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"></path>
                                    </svg>
                                    <span>{{ $product->code }} Datasheet</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="compare">
                        <div class="tcpr">
                            <p>So sánh với các sản phẩm Switch khác:</p>
                            <div class="sggProd">
                                <form action="javascript:void(0)">
                                    <input id="searchSggCP" value="" type="text" placeholder="Nhập Tên hoặc Mã sản phẩm để so sánh" onkeyup="SuggestCompare(421)">
                                    <button title="So sánh với sản phẩm khác" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                                        </svg>
                                    </button>
                                    <div class="autoSuggestionsList_l" id="autoSggList"></div>
                                </form>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-3">
                <div class="cam-ket-sp">
                    <div class="product-note">
                        <p class="cam_ket"><i class="uytin"></i> Cam Kết Bán Hàng</p>
                        <p>✓ Sản Phẩm Chính Hãng 100% Đầy Đủ CO/CQ</p>
                        <p>✓ Giá Cạnh Tranh Rẻ Nhất Thị Trường</p>
                        <p>✓ Ưu Đãi Lớn Cho Đại Lý Và Dự Án</p>
                        <p>✓ Bảo Hành, Đổi Trả Nhanh Chóng</p>
                        <p>✓ Giao Hàng Trên Toàn Quốc</p>
                        <p>✓ Hỗ Trợ Kỹ Thuật Chuyên Nghiệp, Nhiệt Tình</p>
                        <p>✓ Chăm Sóc Khách Hàng Trước, Trong và Sau Khi Mua Hàng Tận Tâm.</p>
                        <p class="uytin-10"><b>CNTTShop.vn</b> - 19 năm Uy tín cung cấp Thiết bị mạng &amp; Dịch vụ Mạng trên toàn quốc.</p>
                        <span class="addhn">
                            <i class="maphn"></i> NTT03, Thống Nhất Complex, Thanh Xuân, <b>Hà Nội</b>.
                            <a title="Chỉ đường đến CNTTShop.vn" href="https://www.google.com/maps/dir//C%C3%B4ng+ty+Vi%E1%BB%87t+Th%C3%A1i+D%C6%B0%C6%A1ng+-+CNTTShop.vn+-+Ph%C3%A2n+ph%E1%BB%91i+Cisco,+NTT+03,+Line+1,+Th%E1%BB%91ng+Nh%E1%BA%A5t+Complex,+%C4%90%C6%B0%E1%BB%9Dng+Nguy%E1%BB%85n+Tu%C3%A2n,+Thanh+Xu%C3%A2n,+H%C3%A0+N%E1%BB%99i,+Vi%E1%BB%87t+Nam/@21.0017807,105.808972,15z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3135ac8d687d3479:0x863cceda2da3be36!2m2!1d105.8049987!2d20.9977409?hl=vi" target="_blank" rel="noopener noreferrer"><i class="directions"></i></a>
                        </span>
                        <span class="addhnhcm">
                            <i class="maphcm"></i> Số 31B, Đường 1, Phường An Phú, Quận 2 (Thủ Đức), <b>TP HCM</b>.
                            <a title="Chỉ đường đến CNTTShop.vn" href="https://www.google.com/maps/dir//31b+%C4%90%C6%B0%E1%BB%9Dng+s%E1%BB%91+1,+An+Ph%C3%BA,+Qu%E1%BA%ADn+2,+Th%C3%A0nh+ph%E1%BB%91+H%E1%BB%93+Ch%C3%AD+Minh,+Vietnam/@10.8088314,106.7506978,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x31752641f7cf5b8b:0x5573c2cda7b199cb!2m2!1d106.7528865!2d10.8088261?hl=vi" target="_blank" rel="noopener noreferrer"><i class="directions"></i></a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
</div>
<section id="pr-detail">
    <div class="container">
        <div class="row mb-4">
            <!-- Nhóm sản phẩm đi kèm -->
            <div class="col-lg-9 mt-4">
                <div id="chi-tiet">{!! $product->content !!}</div>
            </div>

            <!-- Hotline -->
            <div class="col-lg-3 mt-4">
                <div class="support-prod new-prod">
                    <div class="bg-prod d-flex align-items-center">
                        <h2>Thông tin liên hệ</h2>
                    </div>
                    <div class="title-outstand-prod">
                        <div class="row mt-3">
                            <div><span class="top-heading">Hỗ trợ kinh doanh</span></div>
                            @foreach($phoneInfors as $val)
                            @if($val->role == 0)
                            <div class="contact-infor">
                                <span class="user-heading"> <i class="fa fa-user" aria-hidden="true"></i>{{ $val->name }}</span>
                                <div class="sp-online">
                                    <span title="Mobile"><i class="fa fa-phone" aria-hidden="true"></i>{{ $val->phone }}</span>

                                    <a href="{{ $val->skype }} " title="Chat với {{ $val->name }} qua Skype">
                                        <i class="i-skype"></i>
                                    </a>
                                    <a href="https://zalo.me/{{ $val->zalo }} " title="Chat {{ $val->name }} qua Zalo">
                                        <i class="i-zalo"></i>
                                    </a>
                                    <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }} " title="Gửi mail tới: {{ $val->name }} ">
                                        <i class="i-gmail"></i>
                                    </a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <div class="mt-3"><span class="top-heading">Hỗ trợ kỹ thuật</span></div>
                            @foreach($phoneInfors as $val)
                            @if($val->role == 1)
                            <div class="contact-infor">
                                <span class="user-heading"> <i class="fa fa-user" aria-hidden="true"></i>{{ $val->name }}</span>
                                <div class="sp-online">
                                    <span title="Mobile"><i class="fa fa-phone" aria-hidden="true"></i>{{ $val->phone }}</span>

                                    <a href="{{ $val->skype }} " title="Chat với {{ $val->name }} qua Skype">
                                        <i class="i-skype"></i>
                                    </a>
                                    <a href="https://zalo.me/{{ $val->zalo }} " title="Chat {{ $val->name }} qua Zalo">
                                        <i class="i-zalo"></i>
                                    </a>
                                    <a target="_blank" href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to={{ $val->gmail }} " title="Gửi mail tới: {{ $val->name }} ">
                                        <i class="i-gmail"></i>
                                    </a>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('js')
<!-- Link to Swiper's JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{asset('cntt/js/product.js')}}"></script>
<script type="text/javascript">
    // var swiper = new Swiper(".mySwiper", {
    //     slidesPerView: 1,
    //     spaceBetween: 30,
    //     loop: true,
    //     pagination: {
    //         el: ".swiper-pagination",
    //         clickable: true,
    //     },
    //     navigation: {
    //         nextEl: ".swiper-button-next",
    //         prevEl: ".swiper-button-prev",
    //     },
    // });

    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
</script>
@endsection