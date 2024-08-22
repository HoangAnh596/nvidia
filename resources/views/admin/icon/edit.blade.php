@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa thông tin icon</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Icon</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="iconsForm" action="{{ route('icons.update', $icon->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($icon))
            <input type="hidden" name="id" value="{{ $icon->id }}">
            @endif
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('icons.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
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
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $icon->name ?? '') }}">
                            <span id="name-error" style="color: red;"></span>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Địa chỉ đường dẫn :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="url" id="url" class="form-control" value="{{ old('url', $icon->url ?? '') }}">
                            @error('url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row">
                    <div class="col-2 d-flex flex-row-reverse align-items-center" style="height: 38px;">Icon fontawesome :<div class="warningMenu">*</div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $icon->icon ?? '') }}">
                            @error('icon')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Hiển thị :</div>
                    <div class="col-1 d-flex align-items-center">
                        <select class="form-select" aria-label="Default" name="is_public">
                            <<option value="1"
                                @if(!empty($icon) && $icon->is_public == \App\Models\Icon::IS_PUBLIC) selected @endif>
                                Hiển thị
                            </option>
                            <option value="0"
                                @if(!empty($icon) && $icon->is_public == \App\Models\Icon::IS_NOT_PUBLIC) selected @endif>
                                Ẩn
                            </option>
                        </select>
                    </div>
                    <div class="d-flex align-items-center" style="height: 38px; color: red;"><i class="fa-solid fa-circle-info"></i></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-2 d-flex flex-row-reverse align-items-center">Thứ tự hiển thị :</div>
                    <div class="col-1">
                        <input type="number" style="width:60px" name="stt" value="{{ old('stt', $icon->stt ?? '') }}">
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