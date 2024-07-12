@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h3 class="mb-2 text-gray-800">Thông tin chân trang website</h3>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control form-outline" placeholder="Search hotline" aria-label="Search" name="keyword" value="">
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <a href="{{ route('bottoms.create') }}" class="btn btn-danger">Tạo mới</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Địa chỉ đường dẫn</th>
                            <th>stt</th>
                            <th>Hiển thị</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bottoms as $val)
                        <tr>
                            <td>{{ $val->id }}</td>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->url }}</td>
                            <td class="text-center">
                                <input type="text" class="check-stt" name="stt" data-id="{{ $val->id }}" style="width: 50px;text-align: center;" value="{{ old('stt', $val->stt) }}">
                            </td>
                            <td class="text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="is_public" {{ ($val->is_public == 1) ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <a href="{{ asset('admin/bottoms/'.$val->id.'/edit') }}" >Chỉnh sửa</a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav class="float-right">
                    {{ $bottoms->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('.active-checkbox').change(function() {
            var idInfor = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("bottoms.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: idInfor,
                    is_public: value,
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

        $('.check-stt').change(function() {
            var idInfor = $(this).data('id');
            var sttInfor = $(this).val();

            $.ajax({
                url: '{{ route("bottoms.checkStt") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idInfor,
                    stt: sttInfor,
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