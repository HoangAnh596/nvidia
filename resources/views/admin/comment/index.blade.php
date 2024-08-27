@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Danh sách bình luận</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Bình luận</a></li>
                <li class="breadcrumb-item active">Danh sách</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-end">
            <a href="{{ route('comments.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="position-relative text-center">#</th>
                            <th class="col-sm-3 position-relative">Nội dung bình luận</th>
                            <th class="col-sm-1 position-relative">Tác giả</th>
                            <th class="col-sm-2 position-relative text-center">Mail</th>
                            <th class="position-relative text-center">BL Sản Phẩm</th>
                            <th class="position-relative text-center">Hiển thị</th>
                            <th class="position-relative text-center">Đánh giá</th>
                            <th class="position-relative text-center">Time</th>
                            <th class="col-sm-2 position-relative"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $category)
                        @include('admin.comment.partials.children', ['category' => $category, 'level' => 0])
                        @endforeach
                    </tbody>
                </table>
                <nav class="float-right">
                    {{ $comments->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<style>
    .table-responsive {
        font-size: 15px;
    }
</style>
@endsection
