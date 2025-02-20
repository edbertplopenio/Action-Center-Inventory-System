@extends('layout')
@section('title', "Home Page")
@section('content')
    <div class="container mt-5">
        <h2>Welcome, {{ auth()->user()->name ?? 'Guest' }}</h2>
        @auth
            <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('registration') }}" class="btn btn-secondary">Register</a>
        @endauth
    </div>
@endsection
