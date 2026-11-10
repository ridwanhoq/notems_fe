@extends('layouts.main')

@section('title', 'Posts by '.$user['name'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h3 mb-3">Posts by {{ $user['name'] }}</h1>

            @forelse ($data as $post)
                @include('posts.item', ['post' => $post, 'authorId' => $user['_id'], 'authorName' => $user['name']])
            @empty
                <p class="text-muted">{{ $user['name'] }} has not posted anything yet.</p>
            @endforelse

            @include('partials.pagination')
        </div>
    </div>
@endsection
