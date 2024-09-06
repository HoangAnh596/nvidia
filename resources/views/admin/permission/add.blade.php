@extends('layouts.app')
@section('content')
<div class="card shadow">
    <div class="text-center mt-4">
        <h1 class="h4 text-gray-900 mb-4">Tạo mới Permission!</h1>
    </div>
    <!--  -->
    <form class="permission" action="{{ route('permissions.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="text-dark card-body border-top">
            <div class="form-group">
                <label for="">Chọn tên module <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></label>
                <select name="module_parent" class="form-control">
                    <option value="">Chọn tên module</option>
                    @foreach(config('permissions.table_module') as $key =>  $moduleItem)
                    <option value="{{ $moduleItem }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <div class="row">
                    @foreach(config('permissions.module_childrent') as $key => $moduleItemChildrent)
                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" name="module_childrent[]" value="{{ $moduleItemChildrent }}">
                            {{ $key }}
                        </label> 
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-4 pb-4 mr-4 float-right">
            <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
        </div>
    </form>
</div>
@endsection