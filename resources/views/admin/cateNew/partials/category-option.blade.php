<!-- partials/category-option.blade.php -->
<option value="{{ $category->id }}" {{ $category->id == $selected ? 'selected' : '' }}>
    {{ str_repeat('--', $level) }} {{ $category->name }}
</option>
@if($category->children)
    @foreach($category->children as $child)
        @include('admin.category.partials.category-option', ['category' => $child, 'level' => $level + 1, 'selected' => $selected])
    @endforeach
@endif