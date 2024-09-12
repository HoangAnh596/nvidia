@foreach($products as $product)
<div class="col-xs-6 col-s-3 col-md-4 col-sm-6 mb-2">
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
            <div class="text-dark">
                <a href="{{ $product->slug }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
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
