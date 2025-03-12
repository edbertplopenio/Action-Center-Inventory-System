@extends('layouts.app')

@section('title', 'Disaster Risk Reduction Inventory Dashboard')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<div class="container mx-auto p-4 mt-0">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-semibold text-gray-800 leading-tight">Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Most Available Equipment -->
    <div class="bg-[#57cc99] p-4 shadow-lg rounded-lg border-l-4 border-[#57cc99] relative font-inter" style="font-family: 'Inter', sans-serif;">
        <h2 class="text-sm font-semibold text-gray-200 leading-none">Most Available Equipment</h2>
        <p class="text-2xl font-bold text-white leading-tight">Life Vests</p>
        <span class="text-xs text-gray-200 mt-1">⬆️ 150 units available</span>
        <div class="icon bg-[#C7EEDD] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full absolute bottom-2 right-2">
            📦
        </div>
    </div>

    <!-- Critical Stock (Low Inventory) -->
    <div class="bg-[#4cc9f0] p-4 shadow-lg rounded-lg border-l-4 border-[#4cc9f0] relative font-inter" style="font-family: 'Inter', sans-serif;">
        <h2 class="text-sm font-semibold text-gray-200 leading-none">Critical Stock</h2>
        <p class="text-2xl font-bold text-white leading-tight">Flood Lights</p>
        <span class="text-xs text-gray-200 mt-1">⚠️ 2 units left</span>
        <div class="icon bg-[#C3EDFA] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full absolute bottom-2 right-2">
            ⚠️
        </div>
    </div>

    <!-- Equipment Needing Repair -->
    <div class="bg-[#f0b84c] p-4 shadow-lg rounded-lg border-l-4 border-[#f0b84c] relative font-inter" style="font-family: 'Inter', sans-serif;">
        <h2 class="text-sm font-semibold text-gray-200 leading-none">Equipment Needing Repair</h2>
        <p class="text-2xl font-bold text-white leading-tight">Megaphone</p>
        <span class="text-xs text-gray-200 mt-1">🔧 5 units under maintenance</span>
        <div class="icon bg-[#FAE7C3] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full absolute bottom-2 right-2">
            🛠️
        </div>
    </div>

    <!-- Recent Deployments -->
    <div class="bg-[#b79ced] p-4 shadow-lg rounded-lg border-l-4 border-[#b79ced] relative font-inter" style="font-family: 'Inter', sans-serif;">
        <h2 class="text-sm font-semibold text-gray-200 leading-none">Recent Deployments</h2>
        <p class="text-2xl font-bold text-white leading-tight">Safety Helmet</p>
        <span class="text-xs text-gray-200 mt-1">🚛 20 units deployed</span>
        <div class="icon bg-[#E7DEF9] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full absolute bottom-2 right-2">
            🚚
        </div>
    </div>
</div>






<!-- Three-Column Layout for Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 w-full">
    <!-- Equipment Overview -->
    <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Equipment Age Distribution</h2>
        <div class="bg-gray-200 h-[25vh] w-full rounded-lg"></div> 
    </div>

    <!-- Maintenance Status -->
    <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Low Stock</h2>
        <div class="bg-gray-200 h-[25vh] w-full rounded-lg"></div>
    </div>

    <!-- Equipment Condition -->
    <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Equipment Quantity by Category</h2>
        <div class="bg-gray-200 h-[25vh] w-full rounded-lg"></div>
    </div>
</div>

<!-- Two-Column Layout for Charts -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 w-full">
    <!-- Equipment Usage Rate -->
    <div class="bg-white p-4 shadow-lg rounded-lg h-[32vh] w-full">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Equipment Usage Rate</h2>
        <div class="bg-gray-200 h-[22vh] w-full rounded-lg"></div>
    </div>

    <!-- Equipment Quantity by Category -->
    <div class="bg-white p-4 shadow-lg rounded-lg h-[32vh] w-full">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Recent Deployments by category</h2>
        <div class="bg-gray-200 h-[22vh] w-full rounded-lg"></div>
    </div>
</div>


</div>
@endsection