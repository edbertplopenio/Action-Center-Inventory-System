@extends('layout')

@section('title', 'About Us')

@section('content')

<!-- Hero Section with Background Image and Overlay -->
<section class="relative w-screen h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('{{ asset('images/about.png') }}');">
    
    <!-- Navigation Links -->
    <div class="absolute top-10 right-20 flex gap-12 z-10">
        <a href="{{ route('about') }}" class="text-white text-2xl font-bold hover:text-yellow-500 transition">About Us</a>
        <a href="{{ route('login') }}" class="text-white text-2xl font-bold hover:text-yellow-500 transition">Login</a>
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded shadow hover:bg-gray-200 transition">← Back</a>
    </div>

    <!-- Content Section -->
    <div class="w-full max-w-6xl px-6 lg:flex lg:items-center lg:justify-between bg-white bg-opacity-80 rounded-xl shadow-lg p-6 backdrop-blur-md mt-56">
        
        <!-- Left Side: Text Content -->
        <div class="lg:w-1/2 text-gray-900 space-y-4">
            <h2 class="text-4xl font-bold">About Our Inventory System</h2>
            <p class="text-gray-700 text-lg">
                The Action Center Inventory System is a web-based platform designed to efficiently manage and track the resources, equipment, and supplies used by the BatStateU Action Center. It ensures real-time inventory monitoring, automated alerts, and seamless coordination, making it an essential tool for disaster response and emergency operations.
                With role-based access, automated notifications, and detailed reports, the system helps reduce waste, prevent shortages, and improve efficiency. It eliminates manual tracking inefficiencies, ensuring that critical supplies are always available when needed.
            </p>
        </div>

        <!-- Right Side: Image Collage -->
        <div class="lg:w-1/2 flex flex-wrap gap-4">
            <img src="{{ asset('images/image3.JPG') }}" alt="Inventory System" class="w-full rounded-lg shadow-lg">
        </div>
    </div>
</section>

<!-- Scrolling Image & Info Section -->
<section class="w-full py-20 bg-gray-100">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-10">More About Our System</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach(['image4.JPG' => 'Our system simplifies inventory tracking, reducing human errors and improving response times.',
                      'image5.JPG' => 'With automated alerts, users can prevent shortages and ensure resources are always available.',
                      'image6.JPG' => 'Seamless coordination helps organizations respond faster during emergencies.'] as $image => $text)
                <div class="bg-white p-4 rounded-lg shadow-lg transform transition duration-500 hover:scale-105">
                    <img src="{{ asset('images/' . $image) }}" alt="System Feature" class="w-full rounded-lg">
                    <p class="mt-4 text-gray-700">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Information Section -->
<section class="w-full py-16 bg-gray-800 text-white text-center">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-4">Contact Us</h2>
        <p class="text-lg mb-2">📞 Phone: (043) 980-0385 Loc. 1994</p>
        <p class="text-lg mb-2">📧 Email: <a href="mailto:actioncenter@batstate-u.edu.ph" class="text-yellow-400 hover:underline">actioncenter@batstate-u.edu.ph</a></p>
        <p class="text-lg">🌍 Follow us on <a href="https://facebook.com/batstateuactioncenter" target="_blank" class="text-yellow-400 hover:underline">Facebook</a></p>
    </div>
</section>

@endsection
