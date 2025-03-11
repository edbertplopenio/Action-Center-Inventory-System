@extends('layouts.app')

@section('title', 'Disaster Risk Reduction Inventory Dashboard')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-semibold text-gray-800">Disaster Risk Reduction Inventory</h1>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Top Stocked Item Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg transition-transform transform hover:scale-105 hover:shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Top Stocked Item</h2>
                <p class="text-3xl font-semibold text-gray-800">Emergency Tent</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-up"></i> 200 units available</span>
            </div>

            <!-- Low Stock Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg transition-transform transform hover:scale-105 hover:shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Low Stock</h2>
                <p class="text-3xl font-semibold text-gray-800">Water Purifiers</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-exclamation-triangle"></i> 10 units left</span>
            </div>

            <!-- Slow Moving Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg transition-transform transform hover:scale-105 hover:shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Slow Moving</h2>
                <p class="text-3xl font-semibold text-gray-800">First Aid Kits</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-down"></i> 3 units distributed this month</span>
            </div>

            <!-- Total Stock Value Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg transition-transform transform hover:scale-105 hover:shadow-2xl">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Total Stock Value</h2>
                <p class="text-3xl font-semibold text-gray-800">$50,000</p>
                <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-up"></i> 15% increase in value since last review</span>
            </div>
        </div>

        <!-- Full Width Inventory Dynamics -->
        <div class="bg-white p-6 shadow-lg rounded-lg mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Inventory Dynamics</h2>
            <div class="bg-gray-100 h-64 rounded-lg"></div> <!-- Placeholder for Inventory Trend Chart -->
        </div>

        <!-- Full Width Risk Assessment -->
        <div class="bg-white p-6 shadow-lg rounded-lg mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Risk Assessment Overview</h2>
            <div class="bg-gray-100 h-64 rounded-lg"></div> <!-- Placeholder for Risk Heatmap -->
        </div>
    </div>
@endsection
