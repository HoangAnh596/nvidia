<option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories ?? []) ? 'selected' : '' }}>
    {{ str_repeat('--| ', $level ?? 0) . $category->name }}
</option>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.product.partials.sub-category', ['category' => $child, 'selectedCategories' => $selectedCategories, 'level' => ($level ?? 0) + 1])
    @endforeach
@endif

