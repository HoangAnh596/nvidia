@extends('layouts.app')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách tài khoản</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="margin-bottom:20px !important">
                <div class="input-group">
                    <input type="search" name="keyword" class="form-control bg-light border-0 small" placeholder="Tìm kiếm tài khoản" aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
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
                            <a class="btn btn-primary" href="{{ asset('admin/users/'.$val->id.'/edit') }}">chỉnh sửa</a>
                            <form action="{{ route('users.destroy', ['user' => $val->id]) }}" method="post">
                                @csrf
                                @method('Delete')
                                <input type="submit" class="btn btn-danger" value="Xóa" onclick="return confirm('Do you really want to delete?')" />
                            </form>
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