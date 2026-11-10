@extends('layouts.main')

@section('title', 'Posts by '.$user['name'])

@section('content')
    <h1>Posts by {{ $user['name'] }}</h1>

    @forelse ($data as $post)
        @include('posts.item', ['post' => $post, 'authorId' => $user['_id'], 'authorName' => $user['name']])
    @empty
        <p>{{ $user['name'] }} has not posted anything yet.</p>
    @endforelse

    @include('partials.pagination')
@endsection
