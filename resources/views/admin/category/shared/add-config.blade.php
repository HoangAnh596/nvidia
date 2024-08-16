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
    <div class="row">
        <div class="col">
            <label for="example-textarea" class="form-label">Mô tả chi tiết</label>
            <textarea class="form-control" id="my-editor" rows="10" name="content">{{ old('content') }}</textarea>
            @error('content')
            <span class="font-italic text-danger ">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>