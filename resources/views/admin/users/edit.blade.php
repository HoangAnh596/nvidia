@extends('layouts.app')
@section('content')
<div class="card shadow mb-4">
    <div class="text-center">
        <h1 class="h4 text-gray-900 mb-4">Chỉnh sửa tài khoản</h1>
    </div>
    <form class="user" action="{{ route('users.update', ['id' => $user->id]) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
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
                        <input type="text" name="name" class="form-control" id="exampleFirstName" value="{{ old('name', $user->name ?? '') }}">
                        <span id="name-error" style="color: red;"></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Email tài khoản <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                        <input type="text" name="email" class="form-control" id="exampleInputEmail" value="{{ old('email', $user->email ?? '') }}">
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
                            <option {{ $user->roles->contains('id', $role->id) ? 'selected' : ''}} value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <label for="">Hình ảnh</label>
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group">
                                <input id="thumbnail" class="form-control" type="hidden" name="filepath">
                                <span class="input-group-btn">
                                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                                    </button>
                                </span>
                            </div>
                            <div id="holder"><img id="out_img" src="{{ \App\Http\Helpers\Helper::getPath($user->image) }}"></div>
                        </div>
                        <div class="col-6 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 800 x 800 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
                    </div>
                </div>
            </div>
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