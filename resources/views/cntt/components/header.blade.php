<div class="header">
    @php
    $agent = new Jenssegers\Agent\Agent();
    @endphp
    <!-- Header -->
    <!-- begin navbar mobile -->
    @if($agent->isMobile())
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-mobile">
        <!-- css mobilde if fixed add class nav-fixed -->
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="">
                    <i class="fa-solid fa-bars"></i>
                </span>
            </button>
            <a class="navbar-brand" href="{{ asset('/') }}" title="Artificial Intelligence Computing Leadership from NVIDIA" alt="Artificial Intelligence Computing Leadership from NVIDIA" aria-labelledby="nvidia_logo_desktop"> <svg enable-background="new 0 0 974.7 179.7" version="1.1" viewBox="0 0 974.7 179.7" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="110" height="44">
                    <title>Artificial Intelligence Computing Leadership from NVIDIA</title>
                    <path d="m962.1 144.1v-2.7h1.7c0.9 0 2.2 0.1 2.2 1.2s-0.7 1.5-1.8 1.5h-2.1m0 1.9h1.2l2.7 4.7h2.9l-3-4.9c1.5 0.1 2.7-1 2.8-2.5v-0.4c0-2.6-1.8-3.4-4.8-3.4h-4.3v11.2h2.5v-4.7m12.6-0.9c0-6.6-5.1-10.4-10.8-10.4s-10.8 3.8-10.8 10.4 5.1 10.4 10.8 10.4 10.8-3.8 10.8-10.4m-3.2 0c0.2 4.2-3.1 7.8-7.3 8h-0.3c-4.4 0.2-8.1-3.3-8.3-7.7s3.3-8.1 7.7-8.3 8.1 3.3 8.3 7.7c-0.1 0.1-0.1 0.2-0.1 0.3z"></path>
                    <path d="m578.2 34v118h33.3v-118h-33.3zm-262-0.2v118.1h33.6v-91.7l26.2 0.1c8.6 0 14.6 2.1 18.7 6.5 5.3 5.6 7.4 14.7 7.4 31.2v53.9h32.6v-65.2c0-46.6-29.7-52.9-58.7-52.9h-59.8zm315.7 0.2v118h54c28.8 0 38.2-4.8 48.3-15.5 7.2-7.5 11.8-24.1 11.8-42.2 0-16.6-3.9-31.4-10.8-40.6-12.2-16.5-30-19.7-56.6-19.7h-46.7zm33 25.6h14.3c20.8 0 34.2 9.3 34.2 33.5s-13.4 33.6-34.2 33.6h-14.3v-67.1zm-134.7-25.6l-27.8 93.5-26.6-93.5h-36l38 118h48l38.4-118h-34zm231.4 118h33.3v-118h-33.3v118zm93.4-118l-46.5 117.9h32.8l7.4-20.9h55l7 20.8h35.7l-46.9-117.8h-44.5zm21.6 21.5l20.2 55.2h-41l20.8-55.2z"></path>
                    <path fill="#76B900" d="m101.3 53.6v-16.2c1.6-0.1 3.2-0.2 4.8-0.2 44.4-1.4 73.5 38.2 73.5 38.2s-31.4 43.6-65.1 43.6c-4.5 0-8.9-0.7-13.1-2.1v-49.2c17.3 2.1 20.8 9.7 31.1 27l23.1-19.4s-16.9-22.1-45.3-22.1c-3-0.1-6 0.1-9 0.4m0-53.6v24.2l4.8-0.3c61.7-2.1 102 50.6 102 50.6s-46.2 56.2-94.3 56.2c-4.2 0-8.3-0.4-12.4-1.1v15c3.4 0.4 6.9 0.7 10.3 0.7 44.8 0 77.2-22.9 108.6-49.9 5.2 4.2 26.5 14.3 30.9 18.7-29.8 25-99.3 45.1-138.7 45.1-3.8 0-7.4-0.2-11-0.6v21.1h170.2v-179.7h-170.4zm0 116.9v12.8c-41.4-7.4-52.9-50.5-52.9-50.5s19.9-22 52.9-25.6v14h-0.1c-17.3-2.1-30.9 14.1-30.9 14.1s7.7 27.3 31 35.2m-73.5-39.5s24.5-36.2 73.6-40v-13.2c-54.4 4.4-101.4 50.4-101.4 50.4s26.6 77 101.3 84v-14c-54.8-6.8-73.5-67.2-73.5-67.2z"></path>
                </svg>
            </a>
            <div class="d-flex align-self-center search-abort">
                <a class="nav-icon" id="searchToggleMenu" data-bs-toggle="modal" data-bs-target="#templatemo_search" style="width: 30px;">
                    <i class="fa fa-fw fa-search mr-10" id="faSearch"></i>
                    <i class="fa-solid fa-xmark mr-10" id="faXmark" style="display: none;"></i>
                </a>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <?php $countMb = 0 ?>
                @foreach ($globalMenus as $item)
                <?php $countMb++;
                $countMb ?>
                @if($item->children->isNotEmpty())
                <li class="nav-item nav-item-mobile">
                    <a href="@if($item->is_click == 1){{ asset($item->url) }}@else javascript:void(0) @endif" target="@if($item->is_tab == 1) _blank @endif">{{ $item->name }}</a>
                    <a class="active nav-link-mb" id="nav-link-mb-{{ $item->id }}" aria-current="page" data-id="{{ $item->id }}">
                        <i class="fa-solid fa-chevron-down icon-down"></i>
                        <i class="fa-solid fa-chevron-up icon-up"></i>
                    </a>

                    <ul class="dropdown-content-mobile bg-mb-{{ $item->id }}" id="dropdown-content-{{ $item->id }}">
                        @foreach ($item->children as $child)
                        @include('cntt.components.partials.child-mobile', ['child' => $child])
                        @endforeach
                    </ul>
                </li>
                @else
                <li class="nav-item nav-item-mobile">
                    <a href="@if($item->is_click == 1){{ asset($item->url) }}@else javascript:void(0) @endif" target="@if($item->is_tab == 1) _blank @endif">{{ $item->name }}</a>
                </li>
                @endif
                @endforeach
                <li class="nav-item nav-item-mobile">
                    <a aria-current="page" href="javascript:void(0)">Shop</a>
                    <!-- <a aria-current="page" href="{{ asset('/shop') }}" target="_blank">Shop</a> -->
                </li>
                <li class="nav-item nav-item-mobile">
                    <a aria-current="page" href="javascript:void(0)">Driviers</a>
                    <!-- <a aria-current="page" href="{{ asset('/download') }}" target="_blank">Driviers</a> -->
                </li>
                <li class="nav-item nav-item-mobile">
                    <a aria-current="page" href="javascript:void(0)">Support</a>
                    <!-- <a aria-current="page" href="{{ asset('/support') }}" target="_blank">Support</a> -->
                </li>
            </ul>
        </div>
    </nav>
    <!-- end navbar mobile -->
    @else
    <!-- Begin navbar web -->
    <nav class="navbar navbar-expand-lg navbar-light global-nav fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ asset('/') }}" title="Artificial Intelligence Computing Leadership from NVIDIA" alt="Artificial Intelligence Computing Leadership from NVIDIA" aria-labelledby="nvidia_logo_desktop"> <svg enable-background="new 0 0 974.7 179.7" version="1.1" viewBox="0 0 974.7 179.7" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" width="110" height="44">
                    <title>Artificial Intelligence Computing Leadership from NVIDIA</title>
                    <path d="m962.1 144.1v-2.7h1.7c0.9 0 2.2 0.1 2.2 1.2s-0.7 1.5-1.8 1.5h-2.1m0 1.9h1.2l2.7 4.7h2.9l-3-4.9c1.5 0.1 2.7-1 2.8-2.5v-0.4c0-2.6-1.8-3.4-4.8-3.4h-4.3v11.2h2.5v-4.7m12.6-0.9c0-6.6-5.1-10.4-10.8-10.4s-10.8 3.8-10.8 10.4 5.1 10.4 10.8 10.4 10.8-3.8 10.8-10.4m-3.2 0c0.2 4.2-3.1 7.8-7.3 8h-0.3c-4.4 0.2-8.1-3.3-8.3-7.7s3.3-8.1 7.7-8.3 8.1 3.3 8.3 7.7c-0.1 0.1-0.1 0.2-0.1 0.3z"></path>
                    <path d="m578.2 34v118h33.3v-118h-33.3zm-262-0.2v118.1h33.6v-91.7l26.2 0.1c8.6 0 14.6 2.1 18.7 6.5 5.3 5.6 7.4 14.7 7.4 31.2v53.9h32.6v-65.2c0-46.6-29.7-52.9-58.7-52.9h-59.8zm315.7 0.2v118h54c28.8 0 38.2-4.8 48.3-15.5 7.2-7.5 11.8-24.1 11.8-42.2 0-16.6-3.9-31.4-10.8-40.6-12.2-16.5-30-19.7-56.6-19.7h-46.7zm33 25.6h14.3c20.8 0 34.2 9.3 34.2 33.5s-13.4 33.6-34.2 33.6h-14.3v-67.1zm-134.7-25.6l-27.8 93.5-26.6-93.5h-36l38 118h48l38.4-118h-34zm231.4 118h33.3v-118h-33.3v118zm93.4-118l-46.5 117.9h32.8l7.4-20.9h55l7 20.8h35.7l-46.9-117.8h-44.5zm21.6 21.5l20.2 55.2h-41l20.8-55.2z"></path>
                    <path fill="#76B900" d="m101.3 53.6v-16.2c1.6-0.1 3.2-0.2 4.8-0.2 44.4-1.4 73.5 38.2 73.5 38.2s-31.4 43.6-65.1 43.6c-4.5 0-8.9-0.7-13.1-2.1v-49.2c17.3 2.1 20.8 9.7 31.1 27l23.1-19.4s-16.9-22.1-45.3-22.1c-3-0.1-6 0.1-9 0.4m0-53.6v24.2l4.8-0.3c61.7-2.1 102 50.6 102 50.6s-46.2 56.2-94.3 56.2c-4.2 0-8.3-0.4-12.4-1.1v15c3.4 0.4 6.9 0.7 10.3 0.7 44.8 0 77.2-22.9 108.6-49.9 5.2 4.2 26.5 14.3 30.9 18.7-29.8 25-99.3 45.1-138.7 45.1-3.8 0-7.4-0.2-11-0.6v21.1h170.2v-179.7h-170.4zm0 116.9v12.8c-41.4-7.4-52.9-50.5-52.9-50.5s19.9-22 52.9-25.6v14h-0.1c-17.3-2.1-30.9 14.1-30.9 14.1s7.7 27.3 31 35.2m-73.5-39.5s24.5-36.2 73.6-40v-13.2c-54.4 4.4-101.4 50.4-101.4 50.4s26.6 77 101.3 84v-14c-54.8-6.8-73.5-67.2-73.5-67.2z"></path>
                </svg>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-content" id="navbarNav">
                <?php $count = 0 ?>
                @foreach($globalMenus as $category)
                <?php $count++;
                $count ?>
                @if($category->children->isNotEmpty())
                <div class="nav-item">
                    <a class="nav-link nav-link-web" href="@if($category->is_click == 1){{ asset($category->url) }}@else javascript:void(0) @endif" target="@if($category->is_tab == 1) _blank @endif" id="navbarDropdown{{ $category->id }}" data-id="{{ $category->id }}">
                        {{ $category->name }}
                    </a>
                    @if(count($category->children) > 0)
                    <div class="dropdown-content dropdown-{{ $category->id }}">
                        <div class="container" style="padding: 0;">
                            @include('cntt.components.partials.children', ['subcategories' => $category->children])
                        </div>
                    </div>
                    @endif
                </div>
                @else
                <div class="nav-item">
                    <a class="nav-link" href="@if($category->is_click == 1){{ asset($category->url) }}@else javascript:void(0) @endif" target="@if($category->is_tab == 1) _blank @endif" id="navbarDropdown{{ $category->id }}" data-id="{{ $category->id }}">
                        {{ $category->name }}
                    </a>
                </div>
                @endif
                @endforeach
            </div>
            <div class="d-flex" id="templatemo_main_nav">
                <ul class="navbar-nav main-nav-link">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="javascript:void(0)">Shop</a>
                        <!-- <a class="nav-link" aria-current="page" href="{{ asset('/shop') }}" target="_blank">Shop</a> -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="javascript:void(0)">Driviers</a>
                        <!-- <a class="nav-link" aria-current="page" href="{{ asset('/download') }}" target="_blank">Driviers</a> -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="javascript:void(0)">Support</a>
                        <!-- <a class="nav-link" aria-current="page" href="{{ asset('/support') }}" target="_blank">Support</a> -->
                    </li>
                </ul>
                <div class="d-flex align-self-center search-abort">
                    <a class="nav-icon d-none d-lg-inline" id="searchToggleMenu" data-bs-toggle="modal" data-bs-target="#templatemo_search" style="width: 30px;">
                        <i class="fa-solid fa-search mr-2" id="faSearch"></i>
                        <i class="fa-solid fa-xmark mr-2" id="faXmark" style="display: none;"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    @endif
    <!-- Modal -->
    <div class="modal fade bg-search" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="container">
            <div class="modal-dialog modal-lg modal-search" role="document">
                <form method="GET" action="{{ route('home.search') }}" class="modal-content modal-body border-0 p-0">
                    <div class="input-group">
                        <div class="form-group">
                            <select name="cate" class="form-control border">
                                <option value="prod">Tất cả sản phẩm</option>
                                <option value="news">Tất cả bài viết</option>
                                @if(isset($searchCate))
                                @foreach($searchCate as $category)
                                @php
                                $optionValue = $category->source . '_' . $category->id;
                                $isSelected = \Request::get('cate') == $optionValue ? "selected" : "";
                                @endphp
                                <option value="{{ $optionValue }}" {{ $isSelected }}>
                                    @if($category->source == 'prod')
                                    {{ $category->name }}--Sản phẩm
                                    @elseif($category->source == 'news')
                                    {{ $category->name }}--Bài viết
                                    @endif
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <input type="text" class="form-control" id="inputModalSearch" name="keyword" placeholder="Tìm kiếm ...">
                        <button type="submit" class="input-group-text bg-gr text-light">
                            <i class="fa fa-fw fa-search text-white"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Close Header -->
</div>