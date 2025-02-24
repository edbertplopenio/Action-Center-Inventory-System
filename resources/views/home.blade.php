@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-semibold text-gray-800">Analytics</h1>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Top Selling Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Top Selling</h2>
                <p class="text-3xl font-semibold text-gray-800">Product A</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-up"></i> 25 units sold</span>
            </div>

            <!-- Low Stock Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Low Stock</h2>
                <p class="text-3xl font-semibold text-gray-800">Product B</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-exclamation-triangle"></i> 5 units left</span>
            </div>

            <!-- Slow Moving Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Slow Moving</h2>
                <p class="text-3xl font-semibold text-gray-800">Product C</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-down"></i> 2 units sold this month</span>
            </div>

            <!-- Total Sales Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Total Sales</h2>
                <p class="text-3xl font-semibold text-gray-800">$15,000</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-up"></i> 10% increase since last month</span>
            </div>

            <!-- Full Width Sales Dynamics -->
            <div class="bg-white p-6 shadow-lg rounded-lg col-span-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Sales Dynamics</h2>
                <div class="bg-gray-100 h-52 rounded-lg"></div> <!-- Placeholder for Large Chart -->
            </div>

            <!-- Full Width User Activity -->
            <div class="bg-white p-6 shadow-lg rounded-lg col-span-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Overall User Activity</h2>
                <div class="bg-gray-100 h-52 rounded-lg"></div> <!-- Placeholder for Large Chart -->
            </div>
        </div>
    </div>
@endsection
