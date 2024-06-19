@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Tin tức</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">News</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form action="{{ route('news.update', $new->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($new))
            <input type="hidden" name="id" value="{{ $new->id }}">
            <input type="hidden" name="image_ids" value="{{ $new->image_ids }}">
            @endif
            <input type="hidden" name="slugParent" id="slugParent">
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('news.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Back</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                    <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button>
                </div>
            </div>
            <div class="card-body border-top p-9">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info-tab" type="button" role="tab">
                            <i class="bi bi-info-circle-fill"></i>
                            Cấu hình sản phẩm
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet-tab" type="button" role="tab">
                            <i class="bi bi-wallet2"></i>
                            Cấu hình SEO
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                        @include("admin.news.shared.edit-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.news.shared.edit-seo")
                    </div>
                </div>
            </div>
            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    function checkDuplicate() {
        const name = document.getElementById('name').value;
        // Xóa thông báo lỗi trước đó
        document.getElementById('name-error').innerText = "";

        $.ajax({
            url: " {{ route('news.checkName') }} ",
            type: 'POST',
            data: {
                name: name,
                id: '{{ $new->id }}',
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.name_exists) {
                    document.getElementById('name-error').innerText = 'Tên đã tồn tại';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectElement = document.getElementById('new_categories');
        const slugParentInput = document.getElementById('slugParent');

        // Hàm cập nhật giá trị của input ẩn
        function updateSlugParent() {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const slug = selectedOption.getAttribute('data-slug');
            slugParentInput.value = slug;
            // console.log(slug);
        }

        // Gọi hàm khi trang load lần đầu
        updateSlugParent();

        // Gọi hàm khi lựa chọn trong select thay đổi
        selectElement.addEventListener('change', updateSlugParent);
    });

    $(document).ready(function() {
        $('#current_url').val(window.location.href);
        $("#uploadBtnNew").click(function(e) {
            e.preventDefault();
            // let formData = new FormData($("#uploadImagenew")[0]);
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
                success: function(response) {
                    $('#thumbnail').val(response.image_name);
                    $('#preview-image').show();
                },
                error: function(response) {
                    alert("An error occurred. Please try again.");
                }
            });
        });

        // $('#current_url_images').val(window.location.href);
        $("#uploadBtnPrImages").click(function(e) {
            e.preventDefault();
            // let formData = new FormData($("#uploadImagenew")[0]);
            let data = new FormData();
            data.append('pr_image_ids', $('#prImages')[0].files[0]);
            // data.append('current_url_images', window.location.href);

            $.ajax({
                url: "{{ route('upload.image') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#thumbnailPrImages').val(response.image_name);
                    $('#pr-image').show();
                },
                error: function(response) {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });
</script>

@endsection