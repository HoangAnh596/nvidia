<div class="text-dark">
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="name" class="form-label">Tên danh mục: </label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $category->name ?? '') }}">
                @error('name')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 col-xs-12">
                <label for="slug" class="form-label">URL danh mục: </label>
                <input type="text" id="slug" class="form-control" name="slug" value="{{ old('slug', $category->slug ?? '') }}" disabled>
                @error('slug')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="related_pro" class="form-label">Sản phẩm liên quan: </label>
                <select class="related_pro form-control" name="related_pro[]" id="related_pro" multiple="multiple" value="{{ old('related_pro', $category->related_pro ?? '') }}">
                    @if(!empty($relatedPro))
                    @foreach($relatedPro as $val)
                    <option value="{{ $val->id }}" {{ in_array($val->id, json_decode($category->related_pro, true)) ? 'selected' : '' }}>
                        {{ $val->name }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group" style="margin-top: 30px;">
                <input class="hiddenImg py-1" type="file" name="uploadImg" id="image" accept="image/*">
                <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $category->image ?? '') }}">
                <input type="hidden" name="current_url" id="current_url" value="" />
                <button class="btn btn-outline-dark" id="uploadButton" style="margin-right: 1rem;" onclick="uploadImage()">Upload</button>
                <span class="input-group-btn">
                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                    </button>
                </span>
            </div>
            <div id="holder">
                <img id="out_img" src="{{ \App\Http\Helpers\Helper::getPath($category->image) }}" class="ml-2 img-fluid">
            </div>
            <div id="preview">
                <img id="preview-image" src="#" alt="your image" />
            </div>
        </div>
    </div>
    <div class="form-check" style="margin-bottom: 50px; margin-top: 30px;">
        <input class="form-check-input" type="checkbox" name="delete_image" id="flexCheckDefault" value="1">
        <label class="form-check-label text-danger" for="flexCheckDefault">
            Xóa ảnh cũ (Thận trọng khi sử dụng)
        </label>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="title_img" class="form-label">Tiêu đề ảnh:</label>
                <input type="text" id="title_img" class="form-control" name="title_img" value="{{ old('title_img', $category->title_img ?? '') }}">
                @error('title_img')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="alt_img" class="form-label">Alt ảnh:</label>
                <input type="text" id="alt_img" class="form-control" name="alt_img" value="{{ old('alt_img', $category->alt_img ?? '') }}">
                @error('alt_img')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả chi tiết: </label>
            <textarea class="form-control" id="my-editor" rows="10" name="content">{{ old('content', $category->content ?? '') }}</textarea>
            @error('content')
            <span class="font-italic text-danger ">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>