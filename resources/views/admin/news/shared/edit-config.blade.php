<div class="text-dark">
    <div class="form-row">
        <div class="col">
            <div class="mb-3">
                <label for="name" class="form-label">Tên tin tức</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $new->name ?? '') }}" oninput="checkDuplicate()">
                <span id="name-error" style="color: red;"></span>
                @error('name')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Mô tả ngắn</label>
                <input size="5" class="form-control" id="desc" type="name" name="desc" value="{{ old('desc', $new->desc ?? '') }}">
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="slug" class="form-label">Slug tin tức</label>
                <input class="form-control" id="slug" type="name" name="slug" value="{{ old('slug', $new->slug ?? '') }}" disabled>
            </div>
            <div class="mb-3">
                <label for="new_categories" class="form-label">Danh mục tin tức</label>
                <select id="new_categories" class="border form-control" data-live-search="true" name="cate_id">
                    @if(isset($categories))
                    @foreach($categories as $val)
                    <option value="{{ $val->id }}" data-slug="{{ $val->slug }}"  {{ $new->cate_id == $val->id ? 'selected' : '' }}>
                        {{ $val->name }}
                    </option>
                    @endforeach
                    @endif
                </select>
                @error('cate_id')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <input class="hiddenImg py-1" type="file" name="uploadImg" id="image" accept="image/*">
                <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $new->image ?? '') }}">
                <input type="hidden" name="current_url" id="current_url" value="" />
                <button class="btn btn-outline-dark" id="uploadBtnNew" style="margin-right: 1rem;" onclick="uploadImage()">Upload</button>
                <span class="input-group-btn">
                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                    </button>
                </span>
            </div>
            <div id="holder"><img id="out_img" src="{{ \App\Http\Helpers\Helper::getPath($new->image) }}" class="ml-2 img-fluid"></div>
            <div id="preview">
                <img id="preview-image" src="#" alt="your image" />
            </div>
            <div class="form-check" style="margin-bottom: 50px; margin-top: 30px;">
                <input class="form-check-input" type="checkbox" name="delete_image" id="flexCheckDefault" value="1">
                <label class="form-check-label text-danger" for="flexCheckDefault">
                    Xóa ảnh cũ (Thận trọng khi sử dụng)
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="title_img" class="form-label">Tiêu đề ảnh</label>
                <input class="form-control" id="title_img" type="name" name="title_img" value="{{ old('title_img', $new->title_img ?? '') }}">
                @error('title_img')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <div class="mb-3">
                    <label for="alt_img" class="form-label">Alt ảnh</label>
                    <input class="form-control" id="alt_img" type="name" name="alt_img" value="{{ old('alt_img', $new->alt_img ?? '') }}">
                    @error('alt_img')
                    <span class="font-italic text-danger ">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả chi tiết</label>
            <textarea class="form-control" id="my-editor" name="content">{{ old('content', $new->content ?? '') }}</textarea>
            @error('content')
            <span class="font-italic text-danger ">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>