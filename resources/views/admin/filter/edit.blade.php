@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chi tiết bộ lọc</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Bộ lọc</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageForm" action="{{ route('filter.update', $filter->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($filter))
            <input type="hidden" name="id" value="{{ $filter->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('filter.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Back</a>
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
                            Thông tin chi tiết
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet-tab" type="button" role="tab">
                            <i class="bi bi-wallet2"></i>
                            Giá trị bộ lọc
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                        @include("admin.filter.shared.edit-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.filter.shared.edit-filter")
                    </div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const options = document.querySelectorAll('#parent_id option');
        options.forEach(option => {
            option.style.display = 'block';
            option.addEventListener('click', function() {
                const level = parseInt(this.getAttribute('data-level'));
                options.forEach(opt => {
                    if (parseInt(opt.getAttribute('data-level')) > level) {
                        opt.style.display = opt.style.display === 'none' ? 'block' : 'none';
                    }
                });
            });
        });
    });

    $(document).ready(function() {
        // Hàm để cập nhật số thứ tự
        function updateIndex() {
            $('#filters-table tbody tr').each(function(index) {
                $(this).find('td:first').text(index);
            });
        }

        // Hàm để kiểm tra tên filter có trùng hay không
        function isDuplicateFilter(name) {
            var isDuplicate = false;
            $('#filters-table tbody tr td:nth-child(2)').each(function() {
                if ($(this).text().trim() === name.trim()) {
                    isDuplicate = true;
                    return false; // Break the loop
                }
            });
            return isDuplicate;
        }
        $('#edit-filter').click(function(e) {
            e.preventDefault();
            // Lấy giá trị từ input
            var filterName = $('#keyword').val().trim();

            if (filterName) {
                // Kiểm tra tên filter có trùng hay không
                if (isDuplicateFilter(filterName)) {
                    alert('Tên bộ lọc đã tồn tại. Vui lòng nhập một tên khác.');
                } else {
                    // Thêm vào bảng
                    var newRow = `<tr>
                            <td>{{ $filter->valueFilters->count() + 1 }}</td>
                            <td class="text-center">
                                ${filterName}
                                <input type="hidden" name="key_word[]" value="${filterName}">
                            </td>
                            <td class="text-center">
                                <input type="number" name="stt[]" style="width: 50px;text-align: center;" value="999">
                            </td>
                            <td><a class="btn-sm" href>Xóa</a></td>
                        </tr>`;
                    // Thêm dòng mới vào đầu tbody
                    $('#existing-items').prepend(newRow);

                    // Clear input
                    $('#keyword').val('');

                    // Cập nhật số thứ tự
                    updateIndex();
                }
            } else {
                alert('Vui lòng nhập tên bộ lọc');
            }
        });
        // Event delegation for dynamically added elements
        $('#filters-table').on('click', '.delete-filter', function() {
            $(this).closest('tr').remove();
            updateIndex();
        });
    });
</script>
@endsection