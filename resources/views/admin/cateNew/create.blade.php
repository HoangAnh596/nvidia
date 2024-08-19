@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chi tiết danh mục tin tức</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục tin tức</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageFormCateNew" action="{{ route('cateNews.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('cateNews.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm" id="submit" type="submitCateNew"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button>
                </div>
            </div>
            <div class="card-body border-top p-9">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Tên danh mục <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" oninput="checkDuplicate()">
                            <span id="name-error" style="color: red;"></span>
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha </label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="0">Chọn danh mục</option>
                                @foreach($cateNewParents as $category)
                                @include('admin.cateNew.partials.category_add', ['category' => $category, 'level' => 0])
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">URL danh mục bài viết <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" oninput="checkDuplicate()">
                            <span id="slug-error" style="color: red;"></span>
                        </div>
                        <div class="mb-3">
                            <label for="related_pro" class="form-label">Sản phẩm liên quan: </label>
                            <select class="related_pro form-control" name="related_pro[]" id="related_pro" multiple="multiple"></select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Tiêu đề SEO: </label>
                            <input type="text" name="title_seo" id="title_seo" class="form-control" value="{{ old('title_seo') }}">
                            <div class="text-danger" id="message" style="padding-top: 10px;"></div>
                            @error('title_seo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Từ khóa SEO: </label>
                            <input type="text" name="keyword_seo" class="form-control" value="{{ old('keyword_seo') }}">
                            @error('keyword_seo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Mô tả chi tiết SEO: </label>
                            <input type="text" name="des_seo" class="form-control" value="{{ old('des_seo') }}">
                            @error('des_seo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" id="submit" type="submitCateNew"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('cntt/js/slug.js') }}"></script>
<script>
    let timeout = null;
    let updateSlug = true;

    function validateSlug(slug) {
        // Biểu thức chính quy để kiểm tra định dạng của slug
        const regex = /^[a-z0-9]+(-[a-z0-9]+)*$/;
        return regex.test(slug);
    }

    function checkDuplicate() {
        clearTimeout(timeout);
        timeout = setTimeout(async function() {
            if (updateSlug) {
                await createSlug();
            }

            const name = document.getElementById('name').value;
            const slug = document.getElementById('slug').value;

            // Xóa thông báo lỗi trước đó
            document.getElementById('name-error').innerText = "";
            document.getElementById('slug-error').innerText = "";
            // Chỉ kiểm tra nếu slug không rỗng
            if (updateSlug && name.trim() !== "") {
                await createSlug();
            }
            // Kiểm tra định dạng slug
            if (slug.trim() === "") {
                document.getElementById('slug-error').innerText = 'Url không được để trống';
            } else if (!validateSlug(slug)) {
                document.getElementById('slug-error').innerText = 'Url không hợp lệ. Chỉ chấp nhận chữ cái thường, số và dấu gạch ngang.';
            } else {
                // Nếu slug hợp lệ, kiểm tra trùng lặp
                await $.ajax({
                    url: "{{ route('cateNews.checkName') }}",
                    type: 'POST',
                    data: {
                        name: name,
                        slug: slug,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.name_exists) {
                            document.getElementById('name-error').innerText = 'Tên đã tồn tại';
                        }

                        if (data.slug_exists) {
                            document.getElementById('slug-error').innerText = 'Url đã tồn tại';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }, 1000);
    }
    // Đặt updateSlug là true khi tên thay đổi
    document.getElementById('name').addEventListener('input', function() {
        updateSlug = true;
        checkDuplicate();
    });

    // Đặt updateSlug là false khi slug thay đổi
    document.getElementById('slug').addEventListener('input', function() {
        updateSlug = false;
        checkDuplicate();
    });

    $(document).ready(function() {
        // Xử lý sản phẩm liên quan select2
        $('.related_pro').select2({
            placeholder: 'select',
            allowClear: true,
        });
        $("#related_pro").select2({
            ajax: {
                url: "{{ route('cateNews.tim-kiem') }}",
                type: "POST",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        name: params.term,
                        _token: "{{ csrf_token() }}",
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.name,
                            }
                        })
                    }
                }
            },
        });
    });
</script>
@endsection