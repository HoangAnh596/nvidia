@if($countMb == 1)
<li class="nav-item p-15">
    <a class="link-sub-mb" href="{{ asset($child->url) }}">{{ $child->name }}</a>
    <a class="nav-link-mb link-sub-mb" id="nav-link-mb-{{ $child->id }}" data-id="{{ $child->id }}">
        <i class="fa-solid fa-chevron-down icon-down"></i>
        <i class="fa-solid fa-chevron-up icon-up"></i>
    </a>
    @if($child->children->isNotEmpty())
    <ul class="dropdown-content-mobile content-mr-mb-{{ $item->id }}" id="dropdown-content-{{ $child->id }}">
        @foreach ($child->children as $grandchild)
        <li class="nav-item sub-pt-30">
            <a class="link-sub-mb" id="nav-link-mb-{{ $grandchild->id }}" href="{{ asset($grandchild->url) }}" data-id="{{ $grandchild->id }}">
                {{ $grandchild->name }}
            </a>
            <hr>
            @foreach ($grandchild->children as $val)
        <li class="nav-item sub-pt-10">
            <a class="link-sub-mb" id="nav-link-mb-{{ $val->id }}" href="{{ asset($val->url) }}" data-id="{{ $val->id }}">
                {{ $val->name }}
            </a>
        </li>
        @endforeach
</li>
@endforeach
</ul>
@endif
</li>
@else
<li class="nav-item sub-pt-30">
    @if($child->children->isNotEmpty())
    <a class="link-sub-mb" id="nav-link-mb-{{ $child->id }}" href="{{ asset($child->url) }}" data-id="{{ $child->id }}">
        {{ $child->name }}
    </a>
    <hr>
    @foreach ($child->children as $grandchild)
<li class="nav-item sub-pt-10">
    <a class="link-sub-mb" id="nav-link-mb-{{ $grandchild->id }}" href="{{ asset($grandchild->url) }}" data-id="{{ $grandchild->id }}">
        {{ $grandchild->name }}
    </a>
</li>
@endforeach
@else
<a class="link-sub-mb" id="nav-link-mb-{{ $child->id }}" href="{{ asset($child->url) }}" data-id="{{ $child->id }}">
    {{ $child->name }}
</a>
@endif
</li>
@endif