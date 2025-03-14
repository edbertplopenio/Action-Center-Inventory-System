@extends('layout')

@section('title', 'Home Page')

@section('content')

<!-- Background Image -->
<img src="/images/LandingPage.png" alt="Background GIF" class="absolute inset-0 w-screen h-screen object-cover" draggable="false">


<!-- Buttons -->
<div class="absolute bottom-40 right-60 flex gap-4 z-10"> <!-- Changed right-40 to right-60 -->
    <a href="{{ route('registration') }}" class="px-6 py-2 bg-white rounded-md hover:bg-gray-200 transition"
       style="font-family: 'Inter', sans-serif; color: #780000; font-size: 14px;"> <!-- Added font-size -->
        Register
    </a>

    <a href="{{ route('login') }}" class="px-6 py-2 bg-white rounded-md hover:bg-gray-200 transition"
       style="font-family: 'Inter', sans-serif; color: #780000; font-size: 14px;"> <!-- Added font-size -->
        Login
    </a>
</div>

@endsection
