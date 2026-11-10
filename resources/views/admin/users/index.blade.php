@extends('layouts.main')

@section('title', 'Users')

@section('content')
    <h1>Users</h1>
    <p><a href="{{ route('users.create') }}">+ New user</a></p>

    <table>
        <thead>
            <tr><th>Name</th><th>Email</th><th>Role</th><th>Interests</th><th></th></tr>
        </thead>
        <tbody>
            @foreach ($data as $user)
                <tr>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['role'] }}</td>
                    <td>{{ implode(', ', $user['interests'] ?? []) }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user['_id']) }}">Edit</a>
                        <a href="{{ route('admin.notes', ['userId' => $user['_id']]) }}">Notes</a>
                        <a href="{{ route('posts.user', $user['_id']) }}">Posts</a>
                        @if ($user['_id'] !== session('api_user._id'))
                            <form method="POST" action="{{ route('users.destroy', $user['_id']) }}" class="inline" onsubmit="return confirm('Delete this user and all their notes and posts?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('partials.pagination')
@endsection
