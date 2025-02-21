@extends('layout')  {{-- Extends the main layout (layout.blade.php) --}}

@section('title', "Home Page")  {{-- Sets the page title --}}

@section('content')
    <style>
        /* Hero Section Styles */
        .hero-section {
            height: 100vh;
            background: url('{{ asset('public/image/landing.jpg') }}') no-repeat center center/cover;
            position: relative;
        }
        
        /* Dark Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        /* Content Container */
        .content-container {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
        }
    </style>

    {{-- Hero Section --}}
    <div class="hero-section d-flex align-items-center justify-content-center">
        <div class="overlay"></div>
        <div class="container content-container">
            <h1>Welcome to Our Landing Page</h1>
            <p class="lead">Enhance your business with data-driven insights.</p>
            <a href="#" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>
@endsection
