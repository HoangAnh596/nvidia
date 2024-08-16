@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Cập nhật hình ảnh Favicon</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Favicon</a></li>
                <li class="breadcrumb-item active">Cập nh</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form action="{{ route('favicon.update', $favicon->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if (!empty($favicon))
            <input type="hidden" name="id" value="{{ $favicon->id }}">
            @endif
            <div class="row">
                <div class="col" style="margin-top: 30px; margin-left: 30px">
                    <p>Kích thước đề nghị (36x36)</p>
                    <div class="input-group">
                        <input class="hiddenImg py-1" type="file" name="uploadImg" id="image" accept="image/*">
                        <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $favicon->image ?? '') }}">
                        <input type="hidden" name="current_url" id="current_url" value="" />
                        <button class="btn btn-outline-dark" id="uploadButton" style="margin-right: 1rem;" onclick="uploadImage()">Upload</button>
                        <span class="input-group-btn">
                            <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                                <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                            </button>
                        </span>
                    </div>
                    <div id="holder">
                        <img id="favicon_img" src="{{ asset($favicon->image) }}" class="ml-2 img-fluid">
                    </div>
                    <div id="preview">
                        <img id="preview-image" src="#" alt="your image" />
                    </div>
                </div>
            </div>
            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm " type="submit" id="submit"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $("#uploadButton").click(function(e) {
            e.preventDefault();
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
                success: function(res) {
                    $('#thumbnail').val(res.image_name);
                    $('#preview-image').show();
                },
                error: function(err) {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });
</script>
@endsection