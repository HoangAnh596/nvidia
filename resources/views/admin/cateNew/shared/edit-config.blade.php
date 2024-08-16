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
            <div class="form-group mb-3 col-xs-12">
                <label for="parent_id">Danh mục cha:</label>
                <select class="form-control" id="parent_id" name="parent_id">
                    <option value="0">Chọn danh mục</option>
                    @foreach($categories as $cat)
                        @include('admin.cateNew.partials.category-option', ['category' => $cat, 'level' => 0, 'selected' => $category->parent_id])
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
</div>