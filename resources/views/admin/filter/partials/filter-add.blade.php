<!-- partials/category-add.blade.php -->
<option value="{{ $category->id }}" {{ $category->id == $selected ? 'selected' : '' }}>
    {{ str_repeat('|---', $level) }} {{ $category->name }}
</option>
@if($category->children)
    @foreach($category->children as $child)
        @include('admin.filter.partials.filter-add', ['category' => $child, 'level' => $level + 1, 'selected' => $selected])
    @endforeach
@endif