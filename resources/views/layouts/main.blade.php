<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Notes') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Notes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto">
                    @if (session('api_token'))
                        <li class="nav-item"><a class="nav-link @if (request()->routeIs('notes.*')) active @endif" href="{{ route('notes.index') }}">My Notes</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link @if (request()->routeIs('posts.*')) active @endif" href="{{ route('posts.index') }}">Posts</a></li>
                    @if (session('api_token'))
                        <li class="nav-item"><a class="nav-link @if (request()->routeIs('interests')) active @endif" href="{{ route('interests') }}">Interests</a></li>
                    @endif
                    @if (session('api_user.role') === 'admin')
                        <li class="nav-item"><a class="nav-link @if (request()->routeIs('admin.notes')) active @endif" href="{{ route('admin.notes') }}">All Notes</a></li>
                        <li class="nav-item"><a class="nav-link @if (request()->routeIs('users.*')) active @endif" href="{{ route('users.index') }}">Users</a></li>
                    @endif
                </ul>
                <ul class="navbar-nav align-items-md-center">
                    @if (session('api_token'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}">
                                {{ session('api_user.name') }}
                                <span class="badge text-bg-secondary">{{ session('api_user.role') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm ms-md-2">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="container pb-5">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
