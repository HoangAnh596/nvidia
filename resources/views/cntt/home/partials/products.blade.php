<div class="col-12 col-md-3 mb-4">
    <div class="card h-100">
        <a class="btn-img" href="{{ $val->slug }}">
            <img src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" class="card-img-top" alt="{{ $val->alt_img }}" title="{{ $val->title_img }}">
        </a>
        <div class="card-body">
            <div>
                <a href="{{ $val->slug }}" class="text-decoration-none text-danger">{{ number_format($val->price, 0, ',', '.') }}đ</a>
            </div>
            <a href="{{ $val->slug }}" class="text-decoration-none text-dark">{{ $val->name }}</a>
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
            <!-- <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt in culpa qui officia deserunt.
                            </p> -->
            <!-- <p class="text-muted">Reviews (24)</p> -->
        </div>
    </div>
</div>