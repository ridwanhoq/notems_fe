@extends('layouts.main')

@section('title', 'Users')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Users</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">New user</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Name</th><th>Email</th><th>Role</th><th>Interests</th><th class="text-end">Actions</th></tr>
                </thead>
                <tbody>
                    @foreach ($data as $user)
                        <tr>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td><span class="badge {{ $user['role'] === 'admin' ? 'text-bg-dark' : 'text-bg-secondary' }}">{{ $user['role'] }}</span></td>
                            <td>
                                @foreach ($user['interests'] ?? [] as $interest)
                                    <span class="badge text-bg-light border">{{ $interest }}</span>
                                @endforeach
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.notes', ['userId' => $user['_id']]) }}" class="btn btn-outline-secondary btn-sm">Notes</a>
                                <a href="{{ route('posts.user', $user['_id']) }}" class="btn btn-outline-secondary btn-sm">Posts</a>
                                <a href="{{ route('users.edit', $user['_id']) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                @if ($user['_id'] !== session('api_user._id'))
                                    <form method="POST" action="{{ route('users.destroy', $user['_id']) }}" class="d-inline" onsubmit="return confirm('Delete this user and all their notes and posts?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('partials.pagination')
@endsection
