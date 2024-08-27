<!-- resources/views/cateMenu/partials/category_row.blade.php -->
<tr class="parent-{{ $category->parent_id ?? '' }} {{ $level > 0 ? 'hidden nested' : '' }}">
    <td>{{ (($comments->currentPage() - 1) * $comments->perPage()) + $loop->iteration }}</td>
    <td>
        @if ($category->replies->isNotEmpty())
        {{ str_repeat('--', $level) }}
            <button class="toggle-children" data-id="{{ $category->id }}">
                [+]
            </button>
        @else
            <span></span>
        @endif
        {{ str_repeat('---|', $level) }} {{ $category->content }}
    </td>
    <td>
        {{ $category->name }}
    </td>
    <td>
        {{ $category->email }}
    </td>
    <td class="text-center">
        <a href="">Xem link</a>
    </td>
    <td class="text-center">
        <div class="form-check">
            <input type="checkbox" class="checkbox-cateNew" data-id="{{ $category->id }}" data-field="is_public" {{ ($category->is_public == 1) ? 'checked' : '' }}>
        </div>
    </td>
    <td class="text-center">
        <input type="text" class="check-stt" name="stt_new" data-id="{{ $category->id }}" style="width: 40px;text-align: center;" value="{{ old('star', $category->star) }}">
    </td>
    <td>
        {{ $category->created_at->format('d-m-Y H:i') }}
    </td>
    <td>
        <a href="{{ asset('admin/comments/'.$category->id.'/edit') }}" >Chỉnh sửa</a> |
        <a href="{{ asset('admin/comments/'.$category->id) }}" >Xóa</a>
        <!-- <a href="{{ asset('admin/cateNews/'.$category->id.'/edit') }}" >Nhân bản</a> |  -->
        <!-- <a href="{{ asset('admin/cateNews/'.$category->id.'/edit') }}" >Thêm bộ lọc</a> |  -->
        <!-- <a href="{{ asset('admin/cateNews/'.$category->id.'/edit') }}" >Xóa cache</a> |  -->
        <!-- <a href="{{ asset('admin/cateNews/'.$category->id) }}" >Chi tiết</a> |  -->
    </td>
</tr>
@if ($category->replies)
@foreach ($category->replies as $child)
@include('admin.comment.partials.children', ['category' => $child, 'level' => $level + 1])
@endforeach
@endif