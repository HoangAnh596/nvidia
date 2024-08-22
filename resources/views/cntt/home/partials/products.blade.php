@if($products->isEmpty())
<div class="nothing-show-more d-flex justify-content-center mt-4">
    <div class="icon">
        <svg height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path d="M143.9 398.6C131.4 394.1 124.9 380.3 129.4 367.9C146.9 319.4 198.9 288 256 288C313.1 288 365.1 319.4 382.6 367.9C387.1 380.3 380.6 394.1 368.1 398.6C355.7 403.1 341.9 396.6 337.4 384.1C328.2 358.5 297.2 336 256 336C214.8 336 183.8 358.5 174.6 384.1C170.1 396.6 156.3 403.1 143.9 398.6V398.6zM208.4 208C208.4 225.7 194 240 176.4 240C158.7 240 144.4 225.7 144.4 208C144.4 190.3 158.7 176 176.4 176C194 176 208.4 190.3 208.4 208zM304.4 208C304.4 190.3 318.7 176 336.4 176C354 176 368.4 190.3 368.4 208C368.4 225.7 354 240 336.4 240C318.7 240 304.4 225.7 304.4 208zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
        </svg>
    </div>
</div>
<p class="text-center mt-3">Không có sản phẩm phù hợp với tiêu chí bạn tìm</p>
@else
@foreach($products as $product)
<div class="col-w-5 col-xs-6 col-md-3 col-sm-6 mb-2">
    <div class="card h-100">
        @php
        $mainImage = $product->product_images ? $product->product_images->firstWhere('main_img', 1) : null;
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
        @else
        <a class="btn-img" href="{{ $product->slug }}">
            <img class="card-img-top lazyload img-size" src="{{ asset('storage/images/image-coming-soon.jpg') }}" data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" width="206" height="206" alt="Image Coming Soon" title="Image Coming Soon">
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