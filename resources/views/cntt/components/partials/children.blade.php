<li>
    @if (isset($category->children) && count($category->children) > 0)
        @if ($category->name == 'Hãng')
        <a class="btnChild d-flex align-items-center" href="{{ asset($category->url) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bookmark-star-fill" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zM8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.178.178 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.178.178 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.178.178 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.178.178 0 0 1-.134-.098L8.16 4.1z"></path>
			</svg>
            {{ $category->name }} <i class="i-down" style="margin: 0 10px;"></i>
        </a>
        @elseif ($category->name != 'Hãng')
        <a class="btnChild d-flex align-items-center" href="{{ asset($category->url) }}">
            {{ $category->name }} <i class="i-down" style="margin: 0 10px;"></i>
        </a>
        @endif
        <ul class="">
            @foreach ($category->children as $child)
                @include('cntt.components.partials.children', ['category' => $child])
            @endforeach
        </ul>
    @else
        <a class="btnChild d-flex align-items-center" href="{{ asset($category->url) }}">
            @if(!empty($category->image))
            <img src="{{ \App\Http\Helpers\Helper::getPath($category->image) }}" alt="{{ $category->name }}">
            @elseif (empty($category->image) && ($category->name == 'Check giá list'))
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 16 16">
				<path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
			</svg>
            {{ $category->name }}
            @elseif (empty($cate->image))
            {{ $category->name }}
            @endif
        </a>
    @endif
</li>