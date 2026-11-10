<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Notes') - {{ config('app.name') }}</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 960px; margin: 0 auto; padding: 1rem; color: #222; }
        nav { display: flex; gap: 1rem; align-items: center; border-bottom: 1px solid #ddd; padding-bottom: .75rem; margin-bottom: 1rem; flex-wrap: wrap; }
        nav .spacer { flex: 1; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: .4rem; border-bottom: 1px solid #eee; vertical-align: top; }
        label { display: block; margin-top: .75rem; }
        input, textarea, select { width: 100%; padding: .4rem; box-sizing: border-box; }
        textarea { min-height: 8rem; }
        button { padding: .4rem .8rem; cursor: pointer; }
        .inline { display: inline; }
        .alert { padding: .6rem; margin-bottom: 1rem; border-radius: 4px; }
        .alert-success { background: #e6f6e6; }
        .alert-error { background: #fbe9e9; }
        .muted { color: #777; font-size: .9em; }
        .pagination { display: flex; gap: 1rem; margin-top: 1rem; align-items: center; }
        .card { border: 1px solid #ddd; border-radius: 4px; padding: .75rem; margin-bottom: .75rem; }
    </style>
</head>
<body>
    <nav>
        @if (session('api_token'))
            <a href="{{ route('notes.index') }}">My Notes</a>
            <a href="{{ route('posts.index') }}">Posts</a>
            <a href="{{ route('interests') }}">Interests</a>
            @if (session('api_user.role') === 'admin')
                <a href="{{ route('admin.notes') }}">All Notes</a>
                <a href="{{ route('users.index') }}">Users</a>
            @endif
            <span class="spacer"></span>
            <a href="{{ route('profile.edit') }}">{{ session('api_user.name') }} ({{ session('api_user.role') }})</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('posts.index') }}">Posts</a>
            <span class="spacer"></span>
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endif
    </nav>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</body>
</html>
