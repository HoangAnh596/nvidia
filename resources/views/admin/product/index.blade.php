@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Danh sách sản phẩm</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                <li class="breadcrumb-item active">Danh sách</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group sr-product">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="Tìm kiếm tên, code sản phẩm" aria-label="Search" name="keyword" value="{{ $keyword }}">
                    </div>
                    <div class="form-group">
                        <select name="cate" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                            @include('admin.product.partials.category_search', ['category' => $category, 'level' => 0])
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                <a href="{{ route('product.create') }}" class="btn btn-danger btn-sm"><i class="fa-solid fa-circle-plus"></i> CREATE</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="">No.</th>
                            <th class="col-sm-4">Name</th>
                            <th class="col-sm-3">Slug</th>
                            <th class="col-sm-2">Code</th>
                            <th class="col-sm-1 text-center">Nổi bật</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ (($products->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->slug }}</td>
                            <td>{{ $product->code }}</td>
                            <td class="text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="active-checkbox" data-id="{{ $product->id }}" data-field="is_outstand" {{ ($product->is_outstand == 1) ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <a href="{{ asset('admin/products/'.$product->id.'/edit') }}" class="btn-sm">Chỉnh sửa</a> |
                                <a href="{{ asset('admin/filter-pro/create/?pro_id=' . $product->id) }}" class="btn-sm">Thêm bộ lọc</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav class="float-right">
                    {{ $products->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.active-checkbox').change(function() {
            var cateId = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("products.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: cateId,
                    is_outstand: value,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Trạng thái được cập nhật thành công.', 'Thành công', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    } else {
                        toastr.error('Không thể cập nhật trạng thái.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                },
                error: function() {
                    toastr.error('Lỗi cập nhật trạng thái.', 'Lỗi', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                }
            });
        });
    });
</script>
@endsection