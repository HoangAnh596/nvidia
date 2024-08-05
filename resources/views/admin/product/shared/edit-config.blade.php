<div class="text-dark">
    <div class="form-row">
        <div class="col">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $product->name ?? '') }}" oninput="checkDuplicate()">
                <span id="name-error" style="color: red;"></span>
                @error('name')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Mã code sản phẩm</label>
                <input type="text" id="code" class="form-control" name="code" value="{{ old('code', $product->code ?? '') }}">
                @error('code')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá sản phẩm</label>
                <input class="form-control" id="price" type="text" name="price" oninput="validatePrice()" value="{{ old('price', $product->price ?? '') }}">
                <span class="font-italic text-danger" id="priceError"></span>
            </div>
            <div class="mb-3">
                <label for="category">Danh mục chính</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $val)
                        @include('admin.product.partials.category-option', ['category' => $val, 'selectedCategories' => $product->category])
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Tình trạng :</label>
                <select class="form-select" aria-label="Default" name="status">
                    <option value="1"
                        @if(!empty($product) && $product->status == 1) selected @endif>
                        Còn hàng
                    </option>
                    <option value="0"
                        @if(!empty($product) && $product->status == 0) selected @endif>
                        Hết hàng
                    </option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="slug" class="form-label">Slug sản phẩm</label>
                <input class="form-control" id="slug" type="name" name="slug" value="{{ old('slug', $product->slug ?? '') }}" disabled>
            </div>
            <div class="mb-3">
                <label for="related_pro" class="form-label">Sản phẩm liên quan: </label>
                <select class="related_pro form-control" name="related_pro[]" id="related_pro" multiple="multiple" value="{{ old('related_pro', $product->related_pro ?? '') }}">
                    @if(!empty($relatedProducts))
                    @foreach($relatedProducts as $val)
                    <option value="{{ $val->id }}" {{ in_array($val->id, json_decode($product->related_pro, true)) ? 'selected' : '' }}>
                        {{ $val->name }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="mb-3">
                <label for="tag_ids" class="form-label">Thẻ tag</label>
                <select class="searchTags form-control" name="tag_ids[]" id="searchTags" multiple="multiple" value="{{ old('tag_ids', $product->tag_ids ?? '') }}">
                    @if(isset($productTags))
                    @foreach($productTags as $val)
                    <option value="{{ $val->id }}" {{ in_array($val->id, json_decode($product->tag_ids, true)) ? 'selected' : '' }}>
                        {{ $val->name }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="mb-3">
                <label for="category">Danh mục phụ</label>
                <select name="subCategory[]" id="category" multiple class="form-control" style="min-height: 300px;">
                    @foreach($categories as $val)
                        @include('admin.product.partials.sub-category', ['category' => $val, 'selectedCategories' => $product->subCategory])
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <input class="hiddenImg py-1" type="file" name="uploadImg" id="image" accept="image/*">
                <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $product->image ?? '') }}">
                <input type="hidden" name="current_url" id="current_url" value="" />
                <button class="btn btn-outline-dark" id="uploadBtnProduct" style="margin-right: 1rem;" onclick="uploadImage()">Upload</button>
                <span class="input-group-btn">
                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                    </button>
                </span>
            </div>
            <div id="holder"><img id="out_img" src="{{ \App\Http\Helpers\Helper::getPath($product->image) }}" class="ml-2 img-fluid"></div>
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
                <input class="form-control" id="title_img" type="name" name="title_img" value="{{ old('title_img', $product->title_img ?? '') }}">
                @error('title_img')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <div class="mb-3">
                    <label for="alt_img" class="form-label">Alt ảnh</label>
                    <input class="form-control" id="alt_img" type="name" name="alt_img" value="{{ old('alt_img', $product->alt_img ?? '') }}">
                    @error('alt_img')
                    <span class="font-italic text-danger ">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả ngắn</label>
            <textarea class="form-control" id="des-editor" name="des">{{ old('des', $product->des ?? '') }}</textarea>
            @error('des')
            <span class="font-italic text-danger ">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả chi tiết</label>
            <textarea class="form-control" id="my-editor" name="content">{{ old('content', $product->content ?? '') }}</textarea>
            @error('content')
            <span class="font-italic text-danger ">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>