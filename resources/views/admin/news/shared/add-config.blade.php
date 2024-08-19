<div class="text-dark">
    <div class="form-row">
        <div class="col">
            <div class="mb-3">
                <label for="name" class="form-label">Tên bài viết</label>
                <input type="text" id="name" class="form-control" name="name" oninput="checkDuplicate()">
                <span id="name-error" style="color: red;"></span>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Mô tả ngắn</label>
                <input type="text" id="desc" class="form-control" name="desc">
                <span id="desc-error" style="color: red;"></span>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="slug" class="form-label">Url bài viết</label>
                <input type="text" id="slug" class="form-control" name="slug" oninput="checkDuplicate()">
                <span id="slug-error" style="color: red;"></span>
            </div>  
            <div class="mb-3">
                <label for="new_categories" class="form-label">Danh mục bài viết</label>
                <select id="new_categories" class="border form-control" data-live-search="true" name="cate_id">
                    @if(isset($categories))
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" data-slug="{{ $category->slug }}" {{ \Request::get('cate') == $category->id ? "selected ='selected'" : "" }}> {{ $category->name }} </option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-2">
            <div class="input-group">
                <input id="thumbnail" class="form-control" type="hidden" name="filepath">
                <span class="input-group-btn">
                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                    </button>
                </span>
            </div>
            <div id="holder"><img src="{{ old('filepath') }}" alt="" style="height: 5rem;"></div>
        </div>
        <div class="col-3 d-flex flex-row align-items-center" style="height: 38px;">(Kích thước đề nghị 800 x 600 px) <i class="fa-solid fa-circle-info" style="margin-left: 6px; color: red;"></i></div>
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
            <label for="example-textarea" class="form-label">Description</label>
            <textarea id="my-editor" name="content" class="form-control">{{ old('content') }}</textarea>
        </div>
    </div>
</div>
