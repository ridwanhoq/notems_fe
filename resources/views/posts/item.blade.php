<div class="card">
    <strong>{{ $post['title'] }}</strong>
    <div class="muted">
        by
        @if ($authorId)
            <a href="{{ route('posts.user', $authorId) }}">{{ $authorName }}</a>
        @else
            {{ $authorName }}
        @endif
        &middot; {{ \Illuminate\Support\Carbon::parse($post['createdAt'])->diffForHumans() }}
    </div>
    <p style="white-space: pre-wrap">{{ $post['body'] }}</p>
    @if (session('api_token') && ($authorId === session('api_user._id') || session('api_user.role') === 'admin'))
        <form method="POST" action="{{ route('posts.destroy', $post['_id']) }}" class="inline" onsubmit="return confirm('Delete this post?')">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    @endif
</div>
