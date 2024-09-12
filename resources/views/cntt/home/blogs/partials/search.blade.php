@foreach($news as $product)
<div class="col-w-5 col-xs-6 col-md-4 col-sm-6 mb-2">
    <div class="card h-100 card-new">
        <a class="btn-img-new" href="{{ asset('/blogs/' . $product->slug) }}">
            <img src="{{ asset($product->image) }}" class="card-img-top lazyload" data-src="{{ asset($product->image) }}" alt="{{ $product->alt_img }}" title="{{ $product->title_img }}">
        </a>
        <div class="new-body new-search">
            <a href="{{ asset('/blogs/' . $product->slug) }}" class="text-decoration-none">
                <h4>{{ $product->name }}</h4>
            </a>
        </div>
        <p>{{ $product->desc }}</p>
    </div>
</div>
@endforeach