@extends('layouts.app')

@section('title', 'Disaster Risk Reduction Inventory Dashboard')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-semibold text-gray-800">ACTION Center</h1>
    </div>

    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Most Available Equipment -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Most Available Equipment</h2>
            <p class="text-3xl font-semibold text-gray-800">Life Vests</p>
            <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-arrow-up"></i> 150 units available</span>
        </div>

        <!-- Critical Stock (Low Inventory) -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Critical Stock</h2>
            <p class="text-3xl font-semibold text-gray-800">Defibrillator</p>
            <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-exclamation-triangle text-red-500"></i> 2 units left</span>
        </div>

        <!-- Equipment Needing Repair -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Equipment Needing Repair</h2>
            <p class="text-3xl font-semibold text-gray-800">Jack Hammer</p>
            <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-tools text-orange-500"></i> 5 units under maintenance</span>
        </div>

        <!-- Recent Deployments -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Deployments</h2>
            <p class="text-3xl font-semibold text-gray-800">Emergency Lights</p>
            <span class="text-sm text-gray-600 mt-2 block"><i class="fas fa-truck text-blue-500"></i> 20 units deployed this week</span>
        </div>

        <!-- Full Width Inventory Dynamics -->
        <div class="bg-white p-6 shadow-lg rounded-lg col-span-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Inventory Dynamics</h2>
            <div class="bg-gray-100 h-52 rounded-lg"></div> <!-- Placeholder for Inventory Trend Chart -->
        </div>

        <!-- Full Width Risk Assessment -->
        <div class="bg-white p-6 shadow-lg rounded-lg col-span-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Risk Assessment Overview</h2>
            <div class="bg-gray-100 h-52 rounded-lg"></div> <!-- Placeholder for Risk Heatmap -->
        </div>
    </div>
</div>
@endsection