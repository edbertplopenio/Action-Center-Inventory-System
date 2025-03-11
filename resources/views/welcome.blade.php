@extends('layout')

@section('title', 'Home Page')

@section('content')

<!-- Hero Section -->
<div class="relative min-h-screen flex flex-col items-center justify-center font-sans overflow-hidden"
     style="font-family: 'Inter', sans-serif;">
    
    <!-- GIF Background -->
    <img src="/videos/0310(1).gif" alt="Background GIF" class="absolute inset-0 w-full h-full object-cover">

    <!-- Overlay to Darken Background -->
    <div class="absolute inset-0 bg-black bg-opacity-5 backdrop-blur-md"></div>

    <!-- Main Content Container with Stronger Shadow -->
    <div class="relative z-10 flex flex-col items-center text-center bg-white bg-opacity-80 text-black px-6 py-6 rounded-lg shadow-50xl w-full max-w-md backdrop-blur-md"
     style="font-family: 'Inter', sans-serif;">


        
        <!-- Logo -->
        <img src="/images/actioncenterlogo.png" alt="Logo" class="w-16 h-auto mb-4">

        <!-- University Title -->
        <h1 class="text-4xl sm:text-3xl md:text-2xl font-extrabold leading-tight tracking-widest"
            style="font-family: 'Inter', sans-serif;">
            Batangas State University<br>
            <span class="text-4xl sm:text-3xl md:text-xl tracking-widest">ACTION Center</span>
        </h1>
        
        <br>

        <!-- Buttons -->
        <div class="mt-4 flex gap-4">
            <a href="{{ route('registration') }}" class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition"
               style="font-family: 'Inter', sans-serif;">
                Register
            </a>

            <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition"
               style="font-family: 'Inter', sans-serif;">
                Login
            </a>
        </div>
    </div>
</div>
@endsection