<div class="contact-icon">
    <ul>
        @foreach ($contactIconGlobal as $icon)
        <li>
            <a class="{{ $icon->animation == 1 ? 'animation-icon' : '' }}" href="{{ asset($icon->url) }}" rel="nofollow" target="_blank">
                <img width="40" height="40" src="{{ asset($icon->image) }}" alt="Liên hệ qua {{ $icon->name }}" title="Liên hệ qua {{ $icon->name }}">
            </a>
        </li>
        @endforeach
    </ul>
</div>