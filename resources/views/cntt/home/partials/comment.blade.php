@foreach($comments as $cmt)
    <div id="rate-reviews-list">
        <div class="review-row cmt-{{ $cmt->id }}" id="cmt-{{ $cmt->id }}">
            <div data-id="{{ $cmt->id }}" id="review-item-{{ $cmt->id }}" class="view-comments-item level-{{ $level ?? 1 }}" data-fname="{{ $cmt->name }}">
                <div class="img-member-thumb">{{ strtoupper(mb_substr($cmt->name, 0, 1, 'UTF-8')) }}</div>
                <div class="name-member">{{ $cmt->name }}</div>
                <div class="star-rated" title="5 sao"><i class="i-star"></i></div>
                <div class="content-comments">{!! $cmt->content !!}</div>
                <div class="relate-comment">
                    <input class="relate-com-item rep-comment" value="{{ $cmt->id }}" id="reply-comment-{{ $cmt->id }}" type="radio" name="rdo-reply">
                    <label for="reply-comment-{{ $cmt->id }}"><span></span>Trả lời</label>
                </div>
            </div>
            {{-- Gọi đệ quy cho các bình luận con --}}
            @if ($cmt->replies->isNotEmpty())
                <div class="replies">
                    @include('cntt.home.partials.comment', ['comments' => $cmt->replies, 'level' => ($level ?? 1) + 1])
                </div>
            @endif
        </div>
    </div>
@endforeach