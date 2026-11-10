@extends('layouts.main')

@section('title', 'Users by Interest')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h1 class="h3 mb-0">Users by Interest</h1>
        <form method="GET" action="{{ route('interests') }}" class="d-flex gap-2">
            <input class="form-control form-control-sm" type="text" name="interest" value="{{ $interest }}" placeholder="Filter, e.g. chess">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            @if ($interest)
                <a href="{{ route('interests') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Interest</th><th>Users</th><th class="text-end">Count</th></tr>
                </thead>
                <tbody>
                    @forelse ($data as $group)
                        <tr>
                            <td><span class="badge text-bg-primary">{{ $group['interest'] }}</span></td>
                            <td>
                                @foreach ($group['users'] as $member)
                                    <a href="{{ route('posts.user', $member['_id']) }}">{{ $member['name'] }}</a>@if (! $loop->last), @endif
                                @endforeach
                            </td>
                            <td class="text-end">{{ $group['count'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">No interests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('partials.pagination')
@endsection
