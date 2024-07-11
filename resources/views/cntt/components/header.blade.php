<div class="header">
    @php
    $agent = new Jenssegers\Agent\Agent();
    @endphp
    <!-- Header -->
     <!-- begin navbar mobile -->

    <!-- Modal -->
    <div class="modal fade bg-search" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-4 mb-4 text-right btn-xmark">
                <button type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="GET" action="{{ route('home.search') }}" class="modal-content modal-body border-0 p-0">
                <div class="input-group">
                    <div class="form-group">
                        <select name="cate" class="form-control">
                            <option value="">Tất cả sản phẩm</option>
                            @if(isset($searchCate))
                            @foreach($searchCate as $category)
                            <option value="{{ $category->id }}" {{ \Request::get('cate') == $category->id ? "selected ='selected'" : "" }}> {{ $category->name }} </option>
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
    <!-- Close Header -->
</div>