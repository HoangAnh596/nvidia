@extends('cntt.layouts.app')

@section('content')

<div class="container py-3">
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
        <div class="col-lg-3">
            <div class="menu-left product-wap">
                <h2 class="h2">Danh Mục Sản Phẩm</h2>
                <div class="menu-cate-prd" id="cate-menu-left">
                    <ul id="category-menu">
                        @foreach ($cateMenu as $category)
                        @include('cntt.home.partials.children', ['category' => $category])
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="h2 mb-3 mt-2">{{ $categoryParentFind->name }}</h1>
                </div>
                <div class="desc">
                    {{ $categoryParentFind->slug }}
                </div>
            </div>
            <div class="row">
                @foreach($products as $val)
                @include('cntt.home.partials.products', ['val' => $val])
                @endforeach
            </div>
        </div>
    </div>
</div>
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
</script>
@endsection