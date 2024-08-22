@extends('layouts.app')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách tài khoản</h6>
    </div>
    <div class="card-header py-3 d-flex justify-content-between">
        <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
            <div class="input-group sr-product">
                <div class="form-group">
                    <input type="search" class="form-control" placeholder="Tìm kiếm tên, email tài khoản" aria-label="Search" name="keyword" value="{{ $keyword }}">
                </div>
                <div class="form-group">
                    <select name="role" class="form-control">
                        <option value="">Vai trò</option>
                        <option value="1">Quản trị viên</option>
                        <option value="0">Người dùng</option>
                    </select>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                </div>
            </div>
        </form>
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên tài khoản</th>
                        <th>Email tài khoản</th>
                        <th class="col-2">Vai trò</th>
                        <!-- <th>Image</th> -->
                        <th class="col-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $val)
                    <tr>
                        <td>{{ $val->id }}</td>
                        <td>{{ $val->name }}</td>
                        <td>{{ $val->email }}</td>
                        <td>{{ $val->role($val->role) }}</td>
                        <!-- <td><img src="{{ \App\Http\Helpers\Helper::getPath('users',$val->image) }}" alt="" style="width: 100px; height: 100px"></td> -->
                        <td class="action-buttons">
                            <a class="btn-sm" href="{{ asset('admin/users/'.$val->id.'/edit') }}">Chỉnh sửa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$users->appends(request()->query())->links()}}
        </div>
    </div>
</div>
@endsection