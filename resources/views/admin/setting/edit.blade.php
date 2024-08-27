@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Cập nhật favicon và email</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">setting</a></li>
                <li class="breadcrumb-item active">Cập nhật</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form action="{{ route('setting.update', $setting->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if (!empty($setting))
            <input type="hidden" name="id" value="{{ $setting->id }}">
            @endif
            <div class="text-dark card-body border-top">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Tiêu đề mail <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="mail_text" class="form-control" id="exampleFirstName" value="{{ old('mail_text', $setting->mail_text ?? '') }}">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Email tài khoản <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="mail_name" class="form-control" id="exampleInputEmail" value="{{ old('mail_name', $setting->mail_name ?? '') }}">
                            <span id="email-error" style="color: red;"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Mật khẩu ứng dụng email: <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="password" name="mail_pass" class="form-control" id="exampleFirstName" value="{{ old('mail_pass', $setting->mail_pass ?? '') }}">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2">
                        <div class="input-group">
                            <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $new->image ?? '') }}">
                            <span class="input-group-btn">
                                <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                                    <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                                </button>
                            </span>
                        </div>
                        <div id="holder"><img id="setting_img" src="{{ asset($setting->image) }}" class="ml-2 img-fluid"></div>
                    </div>
                    <div class="col-3 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 36 x 36 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
                </div>
            </div>
            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm " type="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $("#uploadButton").click(function(e) {
            e.preventDefault();
            let data = new FormData();
            data.append('uploadImg', $('#image')[0].files[0]);
            data.append('current_url', window.location.href);

            $.ajax({
                url: "{{ route('upload.image') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#thumbnail').val(res.image_name);
                    $('#preview-image').show();
                },
                error: function(err) {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });
</script>
@endsection