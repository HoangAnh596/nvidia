@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa Menu</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageFormCateMenu" action="{{ route('cateMenu.update', ['id' => $category->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($category))
            <input type="hidden" name="id" value="{{ $category->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('cateMenu.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                </div>
            </div>

            <div class="text-dark card-body border-top">
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Tiêu đề :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" oninput="checkDuplicate()">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse">Link :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-9 d-flex justify-content-between">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="checkboxes[]" id="inlineRadio1" value="option1">
                            <label class="form-check-label" for="inlineRadio1">Trang trong</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="checkboxes[]" id="inlineRadio2" value="option2">
                            <label class="form-check-label" for="inlineRadio2">Trang ngoài</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="checkboxes[]" id="inlineRadio3" value="option3">
                            <label class="form-check-label" for="inlineRadio3">Danh mục tin tức</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="checkboxes[]" id="inlineRadio4" value="option4">
                            <label class="form-check-label" for="inlineRadio4">Danh sách tin tức</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="checkboxes[]" id="inlineRadio5" value="option5">
                            <label class="form-check-label" for="inlineRadio5">Danh mục sản phẩm</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="checkboxes[]" id="inlineRadio6" value="option6">
                            <label class="form-check-label" for="inlineRadio6">Danh sách sản phẩm</label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <div id="input-url">
                            <label for="url">Đường dẫn :</label>
                            <input type="text" name="url" id="url" value="{{ old('url', $category->url ?? '') }}" placeholder="Đường dẫn">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Menu cha :</div>
                    <div class="col-4">
                        <div class="form-group">
                            <select name="parent_menu" id="parent_menu" class="form-select" size="10" style="width: 400px;">
                                <option value="0">Gốc</option>
                                @foreach($categories as $val)
                                @include('admin.cateMenu.partials.category_option', ['category' => $val, 'level' => 0, 'prefix' => '|---', 'selected' => $category->parent_menu])
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="height: 38px; color: red; margin-left: 20px;"><i class="fa-solid fa-circle-info"></i></div>
                    <div class="col-5">

                    </div>
                </div>
                <!-- <div class="row" style="margin:60px 0;">
                    <div class="col-2 imgMenu">
                        <div class="d-flex flex-row-reverse">Ảnh đại diện <div class="warningMenu">*</div>
                        </div>
                        <div class="d-flex flex-row-reverse ftImg">Kích thước đề nghị(WxH pixels)</div>
                    </div>
                    <div class="col-10 imgMenu">
                        <div class="input-group" style="margin-top: 30px;">
                            <input class="hiddenImg py-1" type="file" name="uploadImg" id="image" accept="image/*">
                            <input id="thumbnail" class="form-control" type="hidden" name="filepath">
                            <input type="hidden" name="current_url" id="current_url" value="" />
                            <button class="btn btn-outline-dark" id="uploadBtnCateMenu" style="margin-right: 1rem;" onclick="uploadImage()">Upload</button>
                            <span class="input-group-btn">
                                <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                                    <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                                </button>
                            </span>
                        </div>
                        <div id="holder"></div>
                        <div id="preview">
                            <img id="preview-image" src="#" alt="your image" />
                        </div>
                    </div>
                </div> -->
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
                    <div class="col-1">
                        <input type="number" style="width: 50px;" name="stt_menu" value="{{ old('stt_menu', $category->stt_menu ?? '') }}">
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Mở tab mới :</div>
                    <div class="col-1 d-flex align-items-center">
                        <input type="checkbox" name="is_tab" value="1" {{ ($category->is_tab == 1) ? 'checked' : '' }}>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </form>
        @can('menu-delete')
        <form id="deleteForm-{{ $category->id }}" action="{{ route('cateMenu.destroy', ['id' => $category->id]) }}" method="post" class="deleteForm">
            @csrf
            @method('Delete')
            <button class="btn btn-danger btn-sm" type="button" onclick="confirmDelete('{{ $category->id }}')" style="float: right; margin: 0 5px">
                <i class="fa-solid fa-eraser"></i> Xóa
            </button>
        </form>
        @endcan
    </div>
</div>

@endsection

@section('css')
<style>
    #input-url {
        display: none;
    }

    #url {
        width: 500px;
    }

    .ftImg {
        font-size: 12px;
    }

    .titleMenu {
        justify-content: center;
        display: flex;
        flex-direction: column;
        height: 30px;
        text-align: center;
    }

    .imgMenu {
        justify-content: center;
        display: flex;
        flex-direction: column;
        height: 80px;
        text-align: center;
    }
    .toast-top-center>div {
        width: 400px !important;
    }
</style>
@endsection
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var option1 = document.getElementById('inlineRadio1');
        var option2 = document.getElementById('inlineRadio2');
        var inputUrl = document.getElementById('input-url');

        function toggleInput() {
            if (option2.checked) {
                inputUrl.style.display = 'block';
            } else {
                inputUrl.style.display = 'none';
            }
        }

        option1.addEventListener('change', toggleInput);
        option2.addEventListener('change', toggleInput);

        // Gọi hàm toggleInput để đảm bảo trạng thái đúng khi trang được tải
        toggleInput();
    });

    $(document).ready(function() {
        // $('#current_url').val(window.location.href);
        $("#uploadBtnCateMenu").click(function(e) {
            e.preventDefault();
            let data = new FormData();
            console.log(data);
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
                _token: "{{ csrf_token() }}",
                success: function(response) {
                    $('#thumbnail').val(response.image_name);
                    $('#preview-image').show();
                },
                error: function(response) {
                    alert("An error occurred. Please try again.");
                    console.log(response);
                }
            });
        });
    });

    function confirmDelete(id) {
        toastr.warning(`
        <div>Các menu con thuộc menu này sẽ bị xóa. Bạn chắc chắn muốn xóa chứ?</div>
        <div style="margin-top: 15px;">
            <button type="button" id="confirmButton" class="btn btn-danger btn-sm" style="margin-right: 10px;">Xóa</button>
            <button type="button" id="cancelButton" class="btn btn-secondary btn-sm">Hủy</button>
        </div>
    `, 'Cảnh báo', {
            closeButton: false,
            timeOut: 0, // Vô hiệu hóa tự động loại bỏ
            extendedTimeOut: 0,
            tapToDismiss: false,
            positionClass: "toast-top-center",
            onShown: function() {
                // Xử lý khi người dùng nhấn "Xóa"
                document.getElementById('confirmButton').addEventListener('click', function() {
                    toastr.clear(); // Xóa thông báo toastr
                    document.getElementById('deleteForm-' + id).submit(); // Gửi form để xóa
                });

                // Xử lý khi người dùng nhấn "Hủy"
                document.getElementById('cancelButton').addEventListener('click', function() {
                    toastr.remove(); // Xóa thông báo toastr khi nhấn nút "Hủy"
                });
            }
        });
    }
</script>
@endsection