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
        </div>
        <div class="col-sm-6">
            <div class="mb-3 col-xs-12">
                <label for="slug" class="form-label">URL danh mục: </label>
                <input type="text" id="slug" class="form-control" name="slug" value="{{ old('slug', $category->slug ?? '') }}" disabled>
                @error('slug')
                <span class="font-italic text-danger ">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3 col-xs-12">
                <label for="parent_id">Danh mục cha:</label>
                <select class="form-control" id="parent_id" name="parent_id">
                    <option value="0">Chọn danh mục</option>
                    @foreach($categories as $cat)
                        @include('admin.category.partials.category-option', ['category' => $cat, 'level' => 0, 'selected' => $category->parent_id])
                    @endforeach
                </select>
                @if ($errors->has('parent_id'))
                <div class="invalid-feedback" style="display: block;">
                    {{ $errors->first('parent_id') }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-2">
            <div class="input-group">
                <input id="thumbnail" class="form-control" type="hidden" name="filepath" value="{{ old('image', $category->image ?? '') }}">
                <span class="input-group-btn">
                    <button id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-outline-dark hiddenButton">
                        <i class="fa fa-picture-o"></i> Chọn ảnh từ thư viện
                    </button>
                </span>
            </div>
            <div id="holder">
                <img id="out_img" src="{{ \App\Http\Helpers\Helper::getPath($category->image) }}" class="ml-2 img-fluid">
            </div>
        </div>
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