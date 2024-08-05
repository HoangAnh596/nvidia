<option value="{{ $category->id }}" {{ $selectedCategories->contains($category->id) ? 'selected' : '' }}>
    {{ str_repeat('--| ', $level ?? 0) . $category->name }}
</option>
@if ($category->children)
    @foreach ($category->children as $child)
        @include('admin.product.partials.category-option', ['category' => $child, 'selectedCategories' => $selectedCategories, 'level' => ($level ?? 0) + 1])
    @endforeach
@endif
