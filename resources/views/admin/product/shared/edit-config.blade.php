<div class="text-dark">
    <div class="form-row">
        <div class="col">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
                <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $product->name ?? '') }}" oninput="checkDuplicate()">
                <span id="name-error" style="color: red;"></span>
                @error('name')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Mã sản phẩm <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
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
                <label for="category">Danh mục chính <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
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
                    <option value="1" @if(!empty($product) && $product->status == 1) selected @endif>
                        Còn hàng
                    </option>
                    <option value="0" @if(!empty($product) && $product->status == 0) selected @endif>
                        Hết hàng
                    </option>
                </select>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="slug" class="form-label">Địa chỉ Url <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
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
    <div class="text-dark">
        <div class="row">
            <div class="col">
                <div style="margin-top: 1rem;">(Kích thước đề nghị 400 x 400 px) <i class="fa-solid fa-circle-info" style="color: red;"></i></div>
                <div class="input-group">
                    <input class="hiddenPrImages py-1" type="file" name="pr_image_ids" id="prImages" accept="image/*">
                    <input id="thumbnailPrImages" class="form-control" type="hidden" name="filepathPrImages">
                    <button class="btn btn-outline-dark" id="uploadButtonPr" style="margin-right: 1rem;">Upload</button>
                    <span class="input-group-btn">
                        <button id="lfm-prImages" data-input="thumbnail" data-preview="image-holder" class="btn btn-outline-dark hiddenBtnPrImages">
                            <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện 
                        </button>
                    </span> <i class="fa-solid fa-circle-info" style="color: red;"></i>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-6">
                <div class="mb-3">
                    <label for="title_pr_images" class="form-label">Thẻ Title</label>
                    <input type="text" id="title_pr_images" class="form-control" name="title_pr_images" value="{{ old('title_pr_images', $product->title_pr_images ?? '') }}">
                    <span id="name-error" style="color: red;"></span>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="alt_pr_images" class="form-label">Thẻ Alt</label>
                    <input type="text" id="alt_pr_images" class="form-control" name="alt_pr_images" value="{{ old('alt_pr_images', $product->alt_pr_images ?? '') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card-body">
                <div class="table table-img">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="col-sm-2">Ảnh</th>
                                <th class="col-sm-3">Thẻ title</th>
                                <th class="col-sm-3">Thẻ Alt</th>
                                <th class="">Ảnh chính</th>
                                <th class="col-sm-1">Thứ tự</th>
                                <th class="">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($images))
                            @foreach($images as $val)
                            <tr id="image-row-{{ $val->id }}">
                                <td>
                                    <img src="{{ \App\Http\Helpers\Helper::getPath($val->image) }}" alt="{{ $val->alt }}" title="{{ $val->title }}" style="height: 100px;">
                                </td>
                                <td>{{ $val->title }}</td>
                                <td>{{ $val->alt }}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="check-stt" name="main_img" data-id="{{ $val->id }}" style="width: 50px;text-align: center;" value="{{ old('main_img', $val->main_img) }}" {{ ($val->main_img == 1) ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="number" class="check-stt" name="stt_img" data-id="{{ $val->id }}" style="width: 50px;text-align: center;" value="{{ old('stt_img', $val->stt_img) }}" min="1">
                                </td>
                                <td class="text-center">
                                    <a href="{{ asset('/admin/product-images/' . $val->id) }}" class="btn-sm btn-destroy">Xóa</a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <nav class="float-right">
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả ngắn <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
            <textarea class="form-control" id="des-editor" name="des">{{ old('des', $product->des ?? '') }}</textarea>
            @error('des')
            <span class="font-italic text-danger ">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả chi tiết <i class="fa-solid fa-circle-info" style="color: red;"></i></label>
            <textarea class="form-control" id="my-editor" name="content">{{ old('content', $product->content ?? '') }}</textarea>
            @error('content')
            <span class="font-italic text-danger ">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>