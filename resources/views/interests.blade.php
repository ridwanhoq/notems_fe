@extends('layouts.main')

@section('title', 'Users by Interest')

@section('content')
    <h1>Users by Interest</h1>

    <form method="GET" action="{{ route('interests') }}">
        <label>Filter by interest <input type="text" name="interest" value="{{ $interest }}" placeholder="e.g. chess"></label>
        <p><button type="submit">Filter</button> @if ($interest)<a href="{{ route('interests') }}">Clear</a>@endif</p>
    </form>

    <table>
        <thead>
            <tr><th>Interest</th><th>Users</th><th>Count</th></tr>
        </thead>
        <tbody>
            @forelse ($data as $group)
                <tr>
                    <td>{{ $group['interest'] }}</td>
                    <td>
                        @foreach ($group['users'] as $member)
                            <a href="{{ route('posts.user', $member['_id']) }}">{{ $member['name'] }}</a>@if (! $loop->last), @endif
                        @endforeach
                    </td>
                    <td>{{ $group['count'] }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No interests found.</td></tr>
            @endforelse
        </tbody>
    </table>

    @include('partials.pagination')
@endsection
