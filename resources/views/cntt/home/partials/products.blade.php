<div class="col-md-4">
    <div class="card mb-4 product-wap rounded-0">
        <a class="a-img" href="{{ $val->slug }}">
            <img src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" class="img-fluid">
        </a>
        <div class="card-body">
            <a href="{{ $val->slug }}" class="h3 text-decoration-none">{{ $val->name }}</a>
        </div>
    </div>
</div>