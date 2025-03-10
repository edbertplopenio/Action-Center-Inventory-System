@extends('layout')

@section('title', 'Home Page')

@section('content')
<!-- Hero Section -->
<div class="relative min-h-screen flex flex-col items-center justify-center bg-cover bg-center font-sans"
    style="background-image: url('/images/home.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-5 backdrop-blur-md"></div>

    <div class="relative z-10 flex flex-col items-center text-center text-white px-10 rounded-lg p-5">
        <div class="bg-white p-4 rounded-full shadow-lg flex items-center justify-center w-50 h-50">
            <img src="/images/bsulogo.png" alt="Logo" class="w-20 h-auto">
        </div>
        <h1 class="text-6xl sm:text-5xl md:text-3xl font-extrabold leading-tight tracking-widest mt-4">
            Batangas State University<br>
            <span class="text-6xl sm:text-5xl md:text-2xl tracking-widest">ACTION Center</span>
        </h1>
        <br><br>
        <div class="mt-6 flex gap-4">
            <a href="{{ route('registration') }}" class="px-8 py-2 bg-white text-black rounded-full hover:bg-red-600 hover:text-white transition">
                Register
            </a>

            <a href="{{ route('login') }}" class="px-8 py-2 bg-white text-black rounded-full hover:bg-red-600 hover:text-white transition">
                Login
            </a>
        </div>
    </div>
</div>
@endsection