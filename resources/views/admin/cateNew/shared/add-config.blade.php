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
                <label for="">Danh mục cha: </label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="0">Chọn danh mục</option>
                    @foreach($cateNewParents as $category)
                    @include('admin.cateNew.partials.category_add', ['category' => $category, 'level' => 0])
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">URL danh mục: </label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" oninput="checkDuplicate()">
                <span id="slug-error" style="color: red;"></span>
                @error('slug')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="related_pro" class="form-label">Sản phẩm liên quan: </label>
                <select class="related_pro form-control" name="related_pro[]" id="related_pro" multiple="multiple"></select>
            </div>
        </div>
    </div>
</div>