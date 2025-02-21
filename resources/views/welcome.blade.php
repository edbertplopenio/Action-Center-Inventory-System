@extends('layout')

@section('title', 'Home Page')

@section('content')
    <!-- Hero Section --> 
    <div class="relative min-h-screen flex items-center justify-center bg-cover bg-center" 
         style="background: url('{{ asset('images/bg.jpg') }}') no-repeat center center; background-size: cover;">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black opacity-30"></div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col items-center text-center text-white px-6">
            <h1 class="text-2xl font-extrabold mt-4">
                Adaptive Capacity-building and Technology Innovation for Occupational Hazards and Natural Disasters (BatStateU ACTION) Center
            </h1>
            <div class="mt-6 space-x-4">
                <a href="#" class="px-6 py-3 bg-indigo-500 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-indigo-600">
                    About Us
                </a>
                <a href="#" class="px-6 py-3 border border-white text-white text-lg font-semibold rounded-lg hover:bg-white hover:text-black">
                    Learn more →
                </a>
            </div>
        </div>
    </div>
@endsection
