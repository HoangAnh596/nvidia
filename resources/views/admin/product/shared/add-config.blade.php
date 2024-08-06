<div class="text-dark">
    <div class="form-row">
        <div class="col">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" oninput="checkDuplicate()">
                <span id="name-error" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Mã sản phẩm</label>
                <input type="text" id="code" class="form-control" name="code" value="{{ old('code') }}">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá sản phẩm</label>
                <input class="form-control" id="price" type="text" name="price" value="{{ old('price') }}">
                <span class="text-danger" id="priceError"></span>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Danh mục chính <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
                <select name="category" id="parent_id" class="form-control" style="min-height: 300px;" multiple>
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                    @include('admin.category.partials.category_add', ['category' => $category, 'level' => 0])
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Tình trạng</label>
                <select class="form-select" id="status" aria-label="Default" name="status">
                    <option value="1">Còn hàng</option>
                    <option value="0">Hết hàng</option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="slug" class="form-label">Địa chỉ Url</label>
                <input type="text" id="slug" class="form-control" name="slug" value="{{ old('slug') }}" oninput="checkDuplicate()">
                <span id="slug-error" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="related_pro" class="form-label">Sản phẩm liên quan: </label>
                <select class="related_pro form-control" name="related_pro[]" id="related_pro" multiple="multiple"></select>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">Thẻ Tags</label>
                <select class="form-control searchTags" name="tag_ids[]" id="searchTags" multiple="multiple"></select>
            </div>
            
            <div class="mb-3">
                <label for="category" class="form-label">Danh mục phụ <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
                <select name="subCategory[]" id="parent_id" class="form-control" style="min-height: 300px;" multiple="multiple">
                    @foreach($categories as $category)
                    @include('admin.product.partials.category_add', ['category' => $category, 'level' => 0])
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
                <!-- <input type="file" id="image" name="image" > -->
                <button class="btn btn-outline-dark" id="uploadButtonPr" style="margin-right: 1rem;" onclick="uploadImage()">Upload</button>
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
    <div class="form-row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả ngắn <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
            <textarea id="des-editor" name="des" class="form-control"></textarea>
        </div>
    </div>
    <div class="form-row pt-4">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả chi tiết <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
            <textarea id="my-editor" name="content" class="form-control"></textarea>
        </div>
    </div>
</div>
