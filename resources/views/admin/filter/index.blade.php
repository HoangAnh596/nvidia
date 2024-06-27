@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Danh sách bộ lọc</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Bộ lọc</a></li>
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
                        <input type="search" class="form-control" placeholder="Tìm kiếm tên bộ lọc" aria-label="Search" name="keyword" value="{{ $keyword }}">
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                <a href="{{ route('filter.create') }}" class="btn btn-danger btn-sm"><i class="fa-solid fa-circle-plus"></i> Tạo mới bộ lọc</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="">No.</th>
                            <th class="col-sm-4">Tên bộ lọc</th>
                            <th class="col-sm-3">Tên danh mục sản phẩm</th>
                            <th class="col-sm-2">Số thứ tự</th>
                            <th class="col-sm-1">Ẩn/Hiện</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($filter as $val)
                        <tr>
                            <td>{{ (($filter->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                            <td>{{ $val->name }}</td> 
                            <td class="text-center">
                                {{ $val->category->name }}
                            </td>
                            <td>
                            </td>
                            <td class="text-center"></td>
                            <td>
                                <a href="{{ asset('admin/filters/'.$val->id.'/edit') }}" class="btn-sm">Chỉnh sửa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav class="float-right">
                    {{ $filter->links() }}
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
    });
</script>
@endsection