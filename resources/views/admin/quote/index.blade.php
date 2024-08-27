@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h3 class="mb-2 text-gray-800">Danh sách thông tin báo giá</h3>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control form-outline" placeholder="Tìm kiếm báo giá" aria-label="Search" name="keyword" value="">
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                <a href="{{ route('quotes.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">Tên KH</th>
                        <th class="text-center">Số điện thoại</th>
                        <th class="text-center">Gmail báo giá</th>
                        <th class="text-center">Sản phẩm</th>
                        <th class="text-center">Số lượng SP</th>
                        <th class="text-center">Mục đích</th>
                        <th class="text-center">Đã báo giá</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quotes as $val)
                    <tr>
                        <td>{{ $val->id }}</td>
                        <td>{{ $val->name }}</td>
                        <td>{{ $val->phone }}</td>
                        <td>{{ $val->gmail }}</td>
                        <td>{{ $val->product }}</td>
                        <td>{{ $val->quantity }}</td>
                        <td>@if($val->purpose == 0 ) công ty @else dự án @endif </td>
                        <td class="text-center">
                            <div class="form-check">
                                <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="status" {{ ($val->status == 1) ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <a href="{{ asset('admin/quotes/'.$val->id.'/edit') }}">Chỉnh sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <nav class="float-right">
                {{ $quotes->links() }}
            </nav>
        </div>
    </div>
</div>
@endsection