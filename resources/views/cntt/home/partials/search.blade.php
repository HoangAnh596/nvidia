@foreach($products as $product)
<div class="col-lg-3 col-xs-6 col-md-3 col-sm-6 mb-4">
    <div class="card h-100">
        <a class="btn-img" href="{{ $product->slug }}">
            <img src="{{ asset($product->image) }}" class="card-img-top lazyload" data-src="{{ asset($product->image) }}" alt="{{ $product->alt_img }}" title="{{ $product->title_img }}">
        </a>
        <div class="card-body">
            <div>
                <a href="{{ $product->slug }}" class="text-decoration-none text-danger">{{ number_format($product->price, 0, ',', '.') }}đ</a>
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
