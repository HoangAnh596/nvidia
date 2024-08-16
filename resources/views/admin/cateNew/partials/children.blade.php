<!-- resources/views/cateMenu/partials/category_row.blade.php -->
<tr class="parent-{{ $category->parent_id ?? '' }} {{ $level > 0 ? 'hidden nested' : '' }}">
    <td>
        @if ($category->children->isNotEmpty())
        {{ str_repeat('--', $level) }}
            <button class="toggle-children" data-id="{{ $category->id }}">
                [+]
            </button>
        @else
            <span></span>
        @endif
        {{ str_repeat('---|', $level) }} {{ $category->name }}
    </td>
    <td>
        {{ $category->slug }}
    </td>
    <td class="text-center">
        <input type="text" class="check-stt" name="stt_new" data-id="{{ $category->id }}" style="width: 50px;text-align: center;" value="{{ old('stt_new', $category->stt_new) }}">
    </td>
    <td class="text-center">
        <div class="form-check">
            <input type="checkbox" class="checkbox-cateNew" data-id="{{ $category->id }}" data-field="is_menu" {{ ($category->is_menu == 1) ? 'checked' : '' }}>
        </div>
    </td>
    <td class="text-center">
        <div class="form-check">
            <input type="checkbox" class="checkbox-cateNew" data-id="{{ $category->id }}" data-field="is_public" {{ ($category->is_public == 1) ? 'checked' : '' }}>
        </div>
    </td>
    <td>
        <a href="{{ asset('admin/cateNews/'.$category->id.'/edit') }}" >Chỉnh sửa</a> | 
        <a href="{{ asset('admin/cateNews/'.$category->id.'/edit') }}" >Nhân bản</a> | 
        <a href="{{ asset('admin/cateNews/'.$category->id.'/edit') }}" >Thêm bộ lọc</a> | 
        <a href="{{ asset('admin/cateNews/'.$category->id.'/edit') }}" >Xóa cache</a> | 
        <!-- <a href="{{ asset('admin/cateNews/'.$category->id) }}" >Chi tiết</a> |  -->
    </td>
</tr>
@if ($category->children)
@foreach ($category->children as $child)
@include('admin.cateNew.partials.children', ['category' => $child, 'level' => $level + 1])
@endforeach
@endif