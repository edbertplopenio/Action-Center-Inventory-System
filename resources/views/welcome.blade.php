@extends('layout')

@section('title', 'Home Page')

@section('content')
    <!-- Hero Section --> 
    <div class="relative min-h-screen flex flex-col items-center justify-between bg-cover bg-center font-sans"
    style="background-image: url('/images/commandcenter.png'); background-size: cover; background-position: center; max-height: 60vh;">
<!-- Background Image -->
<div class="absolute inset-0 w-screen h-screen bg-cover bg-center" style="background-image: url('{{ asset('Images/landing.png') }}');">
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