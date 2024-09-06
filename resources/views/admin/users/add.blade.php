@extends('layouts.app')
@section('content')
<div class="card shadow">
    <div class="text-center mt-4">
        <h1 class="h4 text-gray-900 mb-4">Tạo mới tài khoản!</h1>
    </div>
    <form class="user" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
            <div>
                <button class="btn btn-primary btn-sm" id="submit" type="submitCateNew"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
            </div>
        </div>
        <div class="text-dark card-body border-top">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Tên tài khoản <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                        <input type="text" name="name" class="form-control" id="exampleFirstName" value="{{ old('name') }}">
                        <span id="name-error" style="color: red;"></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Email tài khoản <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                        <input type="text" name="email" class="form-control" id="exampleInputEmail" value="{{ old('email') }}">
                        <span id="email-error" style="color: red;"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Vai trò <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                        <select name="role_id[]" class="form-control select2_init" multiple>
                            <option value=""></option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Ảnh đại diện</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Mật khẩu <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="Password">
                        <span id="name-error" style="color: red;"></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Lặp lại mật khẩu <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                        <input type="password" name="password_confirmation" class="form-control" id="exampleRepeatPassword" placeholder="Repeat Password">
                        <span id="email-error" style="color: red;"></span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>
    $('.select2_init').select2({
        placeholder: 'Chọn vai trò',
        allowClear: true,
    });
</script>
@endsection