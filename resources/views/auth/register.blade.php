@extends('layouts.main')

@section('title', 'Register')

@section('content')
    <h1>Register</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label>Name <input type="text" name="name" value="{{ old('name') }}" required></label>
        <label>Email <input type="email" name="email" value="{{ old('email') }}" required></label>
        <label>Interests (comma separated) <input type="text" name="interests" value="{{ old('interests') }}" placeholder="chess, reading"></label>
        <label>Password <input type="password" name="password" required minlength="8"></label>
        <label>Confirm password <input type="password" name="password_confirmation" required minlength="8"></label>
        <p><button type="submit">Register</button></p>
    </form>
@endsection
