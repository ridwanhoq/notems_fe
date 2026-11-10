@extends('layouts.main')

@section('title', 'Posts')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h3 mb-3">Posts</h1>

            @if (session('api_token'))
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.store') }}">
                            @csrf
                            <div class="mb-2">
                                <input class="form-control" type="text" name="title" value="{{ old('title') }}" placeholder="Title" required maxlength="200">
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control" name="body" rows="3" placeholder="What's on your mind?" required>{{ old('body') }}</textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-sm">Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @forelse ($data as $post)
                @include('posts.item', ['post' => $post, 'authorId' => $post['author']['_id'] ?? null, 'authorName' => $post['author']['name'] ?? 'deleted user'])
            @empty
                <p class="text-muted">No posts yet.</p>
            @endforelse

            @include('partials.pagination')
        </div>
    </div>
@endsection
