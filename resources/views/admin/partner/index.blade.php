@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Danh sách các đối tác</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Đối tác</a></li>
                <li class="breadcrumb-item active">Danh sách</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-end">
            @can('partner-add')
            <a href="{{ route('partners.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới</a>
            @endcan
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="col-sm-2">Tên đối tác</th>
                            <th class="col-sm-2 text-center">Địa chỉ đường dẫn</th>
                            <th class="col-sm-2 text-center">Hình ảnh</th>
                            <th class="text-center">Thứ tự</th>
                            <th class="text-center">Hiển thị</th>
                            <th class="text-center">Mở Tab</th>
                            <th class="col-sm-2 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($partners->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">Không có bản ghi nào phù hợp !...</td>
                        </tr>
                        @else
                        @foreach ($partners as $partner)
                        <tr>
                            <td>{{ (($partners->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                            <td>{{ $partner->title }}</td>
                            <td>{{ $partner->url }}</td>
                            <td class="text-center" style="padding: 0;"><img src="{{ $partner->image }}" class="img-fluid"></td>
                            @can('partner-checkStt')
                            <td class="text-center">
                                <input type="text" class="check-stt" name="stt" data-id="{{ $partner->id }}" style="width: 50px;text-align: center;" value="{{ old('stt', $partner->stt) }}">
                            </td>
                            @else <td></td>
                            @endcan
                            @can('partner-checkbox')
                            <td class="text-center">
                                <input type="checkbox" class="active-checkbox" data-id="{{ $partner->id }}" data-field="is_public" {{ ($partner->is_public == 1) ? 'checked' : '' }}>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="active-checkbox" data-id="{{ $partner->id }}" data-field="is_tab" {{ ($partner->is_tab == 1) ? 'checked' : '' }}>
                            </td>
                            @else 
                            <td></td>
                            <td></td>
                            @endcan
                            <td class="action">
                                @can('partner-edit')
                                <a href="{{ asset('admin/partners/'.$partner->id.'/edit') }}">Chỉnh sửa</a> |
                                @endcan
                                <a href="{{ asset('admin/partners') }}">Xóa cache</a>
                                @can('partner-delete')
                                | <a href="javascript:void(0);" onclick="confirmDelete('{{ $partner->id }}')">Xóa</a>
                                <form id="deleteForm-{{ $partner->id }}" action="{{ route('partners.destroy', ['id' => $partner->id]) }}" method="post" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <nav class="float-right">
                    {{ $partners->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .toast-top-center>div {
        width: 400px !important;
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
                url: '{{ route("partners.checkStt") }}',
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
                        toastr.success('Thứ tự được cập nhật thành công.', 'Thành công', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    } else {
                        toastr.error('Không thể cập nhật thứ tự.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 403) {
                        toastr.warning('Bạn không có quyền cập nhật.', 'Cảnh báo', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 3000
                        });
                        setTimeout(function() {
                            window.location.reload()
                        }, 3000);
                    } else {
                        toastr.error('Lỗi cập nhật thứ tự.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                }
            });
        });

        $('.active-checkbox').change(function() {
            var cateId = $(this).data('id');
            var field = $(this).data('field');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("partners.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: cateId,
                    field: field,
                    value: value
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Trạng thái được cập nhật thành công.', 'Thành công', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    } else {
                        toastr.error('Không thể cập nhật trạng thái.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 403) {
                        toastr.warning('Bạn không có quyền cập nhật.', 'Cảnh báo', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 3000
                        });
                        setTimeout(function() {
                            window.location.reload()
                        }, 3000);
                    } else {
                        toastr.error('Lỗi cập nhật thứ tự.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                }
            });
        });
    });

    function confirmDelete(id) {
        toastr.warning(`
        <div>Bạn chắc chắn muốn xóa bản ghi này chứ ?</div>
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