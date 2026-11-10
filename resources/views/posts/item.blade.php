<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <h5 class="card-title mb-1">{{ $post['title'] }}</h5>
            @if (session('api_token') && ($authorId === session('api_user._id') || session('api_user.role') === 'admin'))
                <form method="POST" action="{{ route('posts.destroy', $post['_id']) }}" onsubmit="return confirm('Delete this post?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                </form>
            @endif
        </div>
        <p class="small text-muted mb-2">
            by
            @if ($authorId)
                <a href="{{ route('posts.user', $authorId) }}">{{ $authorName }}</a>
            @else
                {{ $authorName }}
            @endif
            &middot; {{ \Illuminate\Support\Carbon::parse($post['createdAt'])->diffForHumans() }}
        </p>
        <p class="card-text mb-0" style="white-space: pre-wrap">{{ $post['body'] }}</p>
    </div>
</div>
