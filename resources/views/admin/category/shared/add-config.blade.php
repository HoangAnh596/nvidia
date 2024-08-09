<div class="text-dark">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="">Tên danh mục: </label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" oninput="checkDuplicate()">
                <span id="name-error" style="color: red;"></span>
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">URL danh mục: </label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" oninput="checkDuplicate()">
                <span id="slug-error" style="color: red;"></span>
                @error('slug')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Danh mục cha: </label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="0">Chọn danh mục</option>
                    @foreach($categoryParents as $category)
                    @include('admin.category.partials.category_add', ['category' => $category, 'level' => 0])
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group" style="margin-top: 30px;">
                <input class="hiddenImg py-1" type="file" name="uploadImg" id="image" accept="image/*">
                <input id="thumbnail" class="form-control" type="hidden" name="filepath">
                <input type="hidden" name="current_url" id="current_url" value="" />
                <button class="btn btn-outline-dark" id="" style="margin-right: 1rem;" onclick="uploadImage()">Upload</button>
                <span class="input-group-btn">
                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                    </button>
                </span>
            </div>
            <div id="holder"></div>
            <div id="preview">
                <img id="preview-image" src="#" alt="your image" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="">Tiêu đề ảnh: </label>
                <input type="text" name="title_img" class="form-control" value="{{ old('title_img') }}">
                @error('title_img')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Alt ảnh: </label>
                <input type="text" name="alt_img" class="form-control" value="{{ old('alt_img') }}">
                @error('alt_img')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả chi tiết</label>
            <textarea class="form-control" id="my-editor" rows="10" name="content"></textarea>
            @error('content')
            <span class="font-italic text-danger ">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>