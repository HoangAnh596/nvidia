@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Products Table</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($product))
            <input type="hidden" name="id" value="{{ $product->id }}">
            <input type="hidden" name="image_ids" value="{{ $product->image_ids }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Back</a>
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
                        @include("admin.product.shared.edit-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.product.shared.edit-seo")
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
            url: " {{ route('products.checkName') }} ",
            type: 'POST',
            data: {
                name: name,
                id: '{{ $product->id }}',
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

    function validatePrice() {
        const priceField = document.getElementById('price');
        const priceError = document.getElementById('priceError');
        const value = priceField.value;

        if (!/^\d*\.?\d*$/.test(value)) {
            priceError.textContent = 'Vui lòng chỉ nhập số nguyên hoặc số thực.';
            priceField.value = value.replace(/[^0-9.]/g, '');
        } else {
            priceError.textContent = '';
        }
    }

    $(document).ready(function() {
        // Xử lý sản phẩm liên quan select2
        $('.related_pro').select2({
            placeholder: 'select',
            allowClear: true,
        });
        $("#related_pro").select2({
            ajax: {
                url: "{{ route('products.tim-kiem') }}",
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

        $('#searchTags').select2({
            placeholder: "Select or type product name",
            tags: true,
            ajax: {
                url: "{{ route('products.searchTags') }}",
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
                    };
                },
                cache: true
            },
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        }).on('select2:select', function(e) {
            var data = e.params.data;
            if (data.newTag) {
                $.ajax({
                    url: "{{ route('product-tags.store') }}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        name: data.text,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        var newOption = new Option(response.name, response.id, false, true);
                        // Kiểm tra nếu id đã tồn tại trong select2, không thêm lại
                        if ($('#searchTags').find("option[value='" + response.id + "']").length) {
                            $('#searchTags').val(response.id).trigger('change');
                        } else {
                            $('#searchTags').append(newOption).trigger('change');
                        }
                    }
                });
            }
        });

        $('#current_url').val(window.location.href);
        $("#uploadButtonPr").click(function(e) {
            e.preventDefault();
            let data = new FormData();
            console.log(data);
            data.append('uploadImg', $('#prImages')[0].files[0]);
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
                    addImageToTable(response.image_name);
                    resetInputs();
                },
                error: function(response) {
                    alert("An error occurred. Please try again.");
                }
            });
        });
        $('table#dataTable').on('click', '.delete-filter', function() {
            $(this).closest('tr').remove();
            updateIndex();
        });
         // Xử lý sự kiện khi ảnh được chọn từ trình quản lý file
         $('#lfm-prImages').on('click', function() {
            var dataPreview = $(this).data('preview');
            window.open('/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
            window.SetUrl = function (items) {
                var imagePath = items.map(function (item) {
                    return item.url;
                }).join(',');

                addImageToTable(imagePath);
            };
        });
        // Function to add image to the table
        function addImageToTable(imagePath) {
            let title = $('#title_pr_images').val() || $('#name').val();
            let alt = $('#alt_pr_images').val() || $('#name').val();
            let stt_img = 999; //chỉ cho nhập số và lớn hoặc bằng 1

            let newRow = `<tr>
                            <td>
                                <input type="hidden" name="image[]" value="${imagePath}">
                                <img src="${imagePath}" class="img-fluid" alt="${imagePath}" width="50%">
                            </td>
                            <td><input type="hidden" name="title[]" value="${title}">${title}</td> 
                            <td><input type="hidden" name="alt[]" value="${alt}">${alt}</td>
                            <td class="text-center">
                                <input type="hidden" name="main_img[]" value="0">
                                <input type="checkbox" class="main_img_checkbox" style="width: 50px; text-align: center;">
                            </td>
                            <td class="text-center">
                                <input type="number" name="stt_img[]" style="width: 50px;text-align: center;" value="${stt_img}" min="1">
                            </td>
                            <td class="text-center"><a href="javascript:void(0);" class="btn-sm delete-filter">Xóa</a></td>
                        </tr>`;
            $('table#dataTable tbody').append(newRow);
            // thay đổi checkbox main_img
            $('.main_img_checkbox').last().change(function() {
                let hiddenInput = $(this).prev('input[type="hidden"]');
                hiddenInput.val($(this).is(':checked') ? '1' : '0');
            });

            // Reset các data cũ về ban đầu
            function resetInputs() {
                $('#prImages').val('');
                $('#title_pr_images').val('');
                $('#alt_pr_images').val('');
            }

            // Xử lý khi ấn vào nút xóa
            $('table#dataTable').on('click', '.delete-filter', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
            });
        }

        $('.btn-destroy').on('click', function(e) {
            e.preventDefault();

            if (confirm('Bạn chắc chắn muốn xóa chứ?')) {
                var url = $(this).attr('href');
                console.log(url);
                
                var row = $(this).closest('tr'); // Lấy hàng chứa nút "Xóa"

                $.ajax({
                    url: url,
                    type: 'DELETE', 
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        // Xóa hàng khỏi bảng nếu xóa thành công
                        row.remove();
                    },
                    error: function(xhr) {
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                    }
                });
            }
        });

        $('.check-stt').change(function() {
            var idMenu = $(this).data('id');
            var sttMenu = $(this).val();

            $.ajax({
                url: '{{ route("product-images.checkStt") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idMenu,
                    stt_img: sttMenu,
                },
                success: function(response) {
                    if (response.success) {
                        alert('Trạng thái được cập nhật thành công.');
                    } else {
                        alert('Không thể cập nhật trạng thái.');
                    }
                },
                error: function() {
                    alert('Lỗi cập nhật trạng thái.');
                }
            });
        });

        $('.check-main').change(function() {
            var cateId = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("products.isCheckImg") }}',
                method: 'POST',
                data: {
                    id: cateId,
                    main_img: value,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        alert('Trạng thái được cập nhật thành công.');
                    } else {
                        alert('Không thể cập nhật trạng thái.');
                    }
                },
                error: function() {
                    alert('Lỗi cập nhật trạng thái.');
                }
            });
        });
    });
</script>

@endsection