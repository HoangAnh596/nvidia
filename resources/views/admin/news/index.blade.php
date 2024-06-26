@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chi tiết</h3>
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
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="Search of new" aria-label="Search" name="keyword" value="{{ $keyword }}">
                    </div>
                    <div class="form-group">
                        <select name="cateNew" class="form-control">
                            <option value="">Danh mục</option>
                            @if(isset($categories))
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ \Request::get('cate') == $category->id ? "selected ='selected'" : "" }}> {{ $category->name }} </option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                <a href="{{ route('news.create') }}" class="btn btn-danger btn-sm"><i class="fa-solid fa-circle-plus"></i> CREATE</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="">No.</th>
                            <th class="col-sm-4">Tên bài viết</th>
                            <th class="col-sm-2">Hình ảnh</th>
                            <th class="col-sm-2">Nổi bật</th>
                            <th class="col-sm-1">Lượt xem</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $new)
                        <tr>
                            <td>{{ (($news->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                            <td>{{ $new->name }}</td>
                            <td>
                                <img src="{{ \App\Http\Helpers\Helper::getPath($new->image) }}" class="img-fluid">
                            </td>
                            <td class="text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="active-checkbox" data-id="{{ $new->id }}" data-field="is_outstand" {{ ($new->is_outstand == 1) ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-center">{{ $new->view_count }}</td>
                            <td>
                                <a href="{{ asset('admin/news/'.$new->id.'/edit') }}" class="btn-sm">Chỉnh sửa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav class="float-right">
                    {{ $news->links() }}
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
                url: '{{ route("news.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: cateId,
                    is_outstand: value,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        alert('Trạng thái được cập nhật thành công.');
                    } else {
                        alert('Không thể cập nhật trạng thái.');
                    }
                },
                error: function() {
                    alert('Lỗi cập nhật trạng thái.');
                }
            });
        });
    });
</script>
@endsection