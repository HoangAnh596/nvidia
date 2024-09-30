<!-- resources/views/categories/partials/category_row.blade.php -->
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
    </td>
    <td class="text-center">
        <input type="checkbox" class="active-checkbox" data-id="{{ $category->id }}" data-field="is_serve" {{ ($category->is_serve == 1) ? 'checked' : '' }}>
    </td>
    <!-- <td class="text-center">
        <input type="checkbox" class="active-checkbox" data-id="{{ $category->id }}" data-field="is_parent" {{ ($category->is_parent == 1) ? 'checked' : '' }}>
    </td> -->
    <td class="text-center">
        <input type="checkbox" class="active-checkbox" data-id="{{ $category->id }}" data-field="is_menu" {{ ($category->is_menu == 1) ? 'checked' : '' }}>
    </td>
    <td class="text-center">
        <input type="checkbox" class="active-checkbox" data-id="{{ $category->id }}" data-field="is_outstand" {{ ($category->is_outstand == 1) ? 'checked' : '' }}>
    </td>
    <td class="text-center">
        <input type="checkbox" class="active-checkbox" data-id="{{ $category->id }}" data-field="is_public" {{ ($category->is_public == 1) ? 'checked' : '' }}>
    </td>
    <td class="text-center">
        <input type="text" class="check-stt" name="stt_cate" data-id="{{ $category->id }}" style="width: 50px;text-align: center;" value="{{ old('stt_cate', $category->stt_cate) }}">
    </td>
    <td>
        @can('category-edit')
        <a href="{{ asset('admin/categories/'.$category->id.'/edit') }}">Chỉnh sửa</a> |
        @endcan
        @can('filter-add')
        <a href="{{ asset('admin/filters/create?cate_id=' . $category->id) }}">Thêm bộ lọc</a> |
        @endcan
        @can('compare-add')
        <a href="{{ asset('admin/compares/create?cate_id=' . $category->id) }}">So sánh</a> |
        @endcan
        @can('group-add')
        <a href="{{ asset('admin/groups/create?cate_id=' . $category->id) }}">Nhóm</a> |
        @endcan
        <a href="{{ asset('admin/categories') }}" >Xóa cache</a>
        <!-- <a href="{{ route('categories.duplicate', $category->id) }}" >Nhân bản</a> -->
        <!-- <a href="{{ asset('admin/categories/'.$category->id) }}" >Chi tiết</a> |  -->
    </td>
</tr>
@if ($category->children)
@foreach ($category->children as $child)
@include('admin.category.partials.children', ['category' => $child, 'level' => $level + 1])
@endforeach
@endif