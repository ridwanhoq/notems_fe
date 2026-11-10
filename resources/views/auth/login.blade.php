@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <h1>Login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Email <input type="email" name="email" value="{{ old('email') }}" required autofocus></label>
        <label>Password <input type="password" name="password" required></label>
        <p><button type="submit">Login</button></p>
    </form>
    <p>No account? <a href="{{ route('register') }}">Register</a></p>
@endsection
