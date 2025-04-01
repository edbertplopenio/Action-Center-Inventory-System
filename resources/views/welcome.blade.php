@extends('layout')

@section('title', 'Home Page')

@section('content')
    <!-- Hero Section --> 
    <div class="relative min-h-screen flex flex-col items-center justify-between bg-cover bg-center font-sans"
    style="background-image: url('/images/commandcenter.png'); background-size: cover; background-position: center; max-height: 60vh;">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black opacity-20"></div>

        <!-- Content at the top -->
        <div class="relative z-10 flex flex-col items-center text-center text-white px-6 pt-20">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold">
                Welcome to the BatStateU <br> ACTION Center
            </h1>
            <p class="text-lg sm:text-xl mt-10 max-w-xl">
                Adaptive Capacity-building and Technology Innovation for Occupational Hazards and Natural Disasters.
            </p>
        </div>

        <!-- "About Us" button at the bottom -->
        <div class="relative z-10 flex justify-center w-full mb-6">
            <a href="{{ url('/about-us') }}" class="px-6 py-3 bg-indigo-500 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-indigo-600">
                About Us
            </a>
        </div>
    </div>
=======
<!-- Background Image -->
<div class="absolute inset-0 w-screen h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/landing.png') }}');">
</div>
<!-- Navigation Links -->
 
<div class="absolute top-20 right-20 transform -translate-x-1/4 flex gap-12 z-10">
    
    <a href="{{ route('about') }}" class="text-white text-2xl font-bold hover:text-yellow-500 transition">About Us</a>
    <a href="{{ route('login') }}" class="text-white text-2xl font-bold hover:text-yellow-500 transition">Login</a>
</div>
<!-- Register Button -->
<div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 z-10">
    <a href="{{ route('registration') }}" class="px-8 py-4 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition"
       style="font-family: 'Inter', sans-serif; font-size: 18px;">
        Register
    </a>
</div>

@endsection
