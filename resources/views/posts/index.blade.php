@extends('layouts.main')

@section('title', 'Posts')

@section('content')
    <h1>Posts</h1>

    @if (session('api_token'))
        <form method="POST" action="{{ route('posts.store') }}" class="card">
            @csrf
            <label>Title <input type="text" name="title" value="{{ old('title') }}" required maxlength="200"></label>
            <label>Body <textarea name="body" required>{{ old('body') }}</textarea></label>
            <p><button type="submit">Publish</button></p>
        </form>
    @endif

    @forelse ($data as $post)
        @include('posts.item', ['post' => $post, 'authorId' => $post['author']['_id'] ?? null, 'authorName' => $post['author']['name'] ?? 'deleted user'])
    @empty
        <p>No posts yet.</p>
    @endforelse

    @include('partials.pagination')
@endsection
