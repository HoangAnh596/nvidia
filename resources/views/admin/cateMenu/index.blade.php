@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chi tiết danh mục menu</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục Menu</a></li>
                <li class="breadcrumb-item active">Danh sách</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-end">
            <a href="{{ route('cateMenu.create') }}" class="btn btn-primary">Thêm mới danh mục</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="col-sm-3 position-relative">Tên Danh Mục Menu</th>
                            <th class="col-sm-3 position-relative">Địa chỉ đường dẫn</th>
                            <th class="position-relative text-center">Thứ tự</th>
                            <th class="position-relative text-center">Hiển thị</th>
                            <th class="position-relative text-center">Click</th>
                            <th class="col-sm-2 position-relative"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryParents as $category)
                        @include('admin.cateMenu.partials.children', ['category' => $category, 'level' => 0])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<style>
    .hidden {
        display: none;
    }

    .nested {
        padding-left: 20px;
    }
    td a {
        font-size: 14px;
    }
</style>

@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.toggle-children').click(function() {
            var categoryId = $(this).data('id');
            $('.parent-' + categoryId).toggleClass('hidden');
            $(this).text($(this).text() == '[+]' ? '[-]' : '[+]');
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.check-stt').change(function() {
            var idMenu = $(this).data('id');
            var sttMenu = $(this).val();

            $.ajax({
                url: '{{ route("cateMenu.checkStt") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idMenu,
                    stt_menu: sttMenu,
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

        $('.active-checkbox').change(function() {
            var cateId = $(this).data('id');
            var field = $(this).data('field');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("cateMenu.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: cateId,
                    field: field,
                    value: value
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