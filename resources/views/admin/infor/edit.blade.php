@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa thông tin liên hệ</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Liên hệ</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="inforsForm" action="{{ route('infors.update', $infor->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($infor))
            <input type="hidden" name="id" value="{{ $infor->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('infors.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                </div>
            </div>
            <div class="text-dark card-body border-top">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tên :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $infor->name ?? '') }}">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Số điện thoại :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $infor->phone ?? '') }}">
                            <span id="phone-error" style="color: red; display: none;">Sđt không hợp lệ (phải là 10 số từ 0-9)</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Link Skype :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="skype" id="skype" class="form-control" value="{{ old('skype', $infor->skype ?? '') }}">
                            <span id="skype-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Link Zalo :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="zalo" id="zalo" class="form-control" value="{{ old('zalo', $infor->zalo ?? '') }}">
                            <span id="zalo-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Link Gmail :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="gmail" id="gmail" class="form-control" value="{{ old('gmail', $infor->gmail ?? '') }}">
                            <span id="gmail-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Ảnh :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $infor->image ?? '') }}">
                            <span class="input-group-btn">
                                <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                                    <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                                </button>
                            </span>
                        </div>
                        <div id="holder">
                            <img id="out_img" src="{{ \App\Http\Helpers\Helper::getPath($infor->image) }}">
                        </div>
                    </div>
                    <div class="col-3 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 292 x 292 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Vai trò :</div>
                    <div class="col-3 d-flex align-items-center">
                        <select class="form-control" aria-label="Default" name="role">
                            <option value="0"
                                @if(!empty($infor) && $infor->role == 0) selected @endif>
                                Phòng kinh doanh
                            </option>
                            <option value="1"
                                @if(!empty($infor) && $infor->role == 1) selected @endif>
                                Phòng kỹ thuật
                            </option>
                            <option value="2"
                                @if(!empty($infor) && $infor->role == 2) selected @endif>
                                Phòng kinh doanh dự án
                            </option>
                            <option value="3"
                                @if(!empty($infor) && $infor->role == 3) selected @endif>
                                Phòng kinh doanh máy chủ serve
                            </option>
                            <option value="4"
                                @if(!empty($infor) && $infor->role == 4) selected @endif>
                                Phòng kế toán
                            </option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Vị trí vai trò :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $infor->title ?? '') }}">
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Mô tả vai trò :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <input type="text" name="desc_role" id="desc_role" class="form-control" value="{{ old('desc_role', $infor->desc_role ?? '') }}">
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Nhận báo giá :</div>
                    <div class="col-2">
                        <select class="form-control" aria-label="Default" name="send_price">
                            <option value="0"
                                @if(!empty($infor) && $infor->send_price == 0) selected @endif>
                                Không
                            </option>
                            <<option value="1"
                                @if(!empty($infor) && $infor->send_price == 1) selected @endif>
                                Có
                                </option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Hiển thị :</div>
                    <div class="col-2">
                        <select class="form-control" aria-label="Default" name="is_public">
                            <option value="1"
                                @if(!empty($infor) && $infor->is_public == \App\Models\Infor::IS_PUBLIC) selected @endif>
                                Hiển thị
                                </option>
                                <option value="0"
                                    @if(!empty($infor) && $infor->is_public == \App\Models\Infor::IS_NOT_PUBLIC) selected @endif>
                                    Ẩn
                                </option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
                    <div class="col-1">
                        <input type="number" class="form-control" style="width:80px;" name="stt" value="{{ old('stt', $infor->stt ?? '') }}">
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>

            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        var timer;
        var isPhoneValid = false; // Biến để kiểm tra tính hợp lệ của số điện thoại

        function validatePhone(phone) {
            // Biểu thức chính quy để kiểm tra số điện thoại Việt Nam và chấp nhận khoảng trắng
            var phoneRegex = /^(0[1-9])+(\s?[0-9]){8,9}$/;
            return phoneRegex.test(phone);
        }

        $('#phone').on('blur', function() {
            var phoneInput = $(this).val().trim();
            var errorMessage = $('#phone-error');

            // Xóa bộ đếm thời gian nếu người dùng nhấp vào lại trước khi hết 5 giây
            if (timer) {
                clearTimeout(timer);
            }

            // Thiết lập bộ đếm thời gian để thực hiện kiểm tra sau 5 giây
            timer = setTimeout(function() {
                if (validatePhone(phoneInput)) {
                    errorMessage.hide();
                    isPhoneValid = true; // Số điện thoại hợp lệ
                } else {
                    errorMessage.show();
                    isPhoneValid = false; // Số điện thoại không hợp lệ
                }
            }, 2000); // 2000ms tương đương với 2 giây
        });

        $('#inforsForm').on('submit', function(e) {
            var phoneInput = $('#phone').val().trim();
            var errorMessage = $('#phone-error');

            // Kiểm tra tính hợp lệ của số điện thoại khi submit form
            if (!validatePhone(phoneInput)) {
                e.preventDefault(); // Ngăn chặn form gửi đi
                errorMessage.show();
                isPhoneValid = false; // Số điện thoại không hợp lệ
            } else {
                errorMessage.hide();
                isPhoneValid = true; // Số điện thoại hợp lệ
            }
        });
    });
</script>
@endsection