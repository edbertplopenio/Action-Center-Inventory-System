@extends('layouts.app')

@section('title', 'Action Center')

@section('content')

@php
    use Illuminate\Support\Js;
@endphp

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<div class="container mx-auto p-4 mt-0">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-semibold text-gray-800 leading-tight">Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Most Available Equipment -->
        <div class="bg-[#57cc99] p-4 shadow-lg rounded-lg border-l-4 border-[#57cc99] relative font-inter">
            <h2 class="text-sm font-semibold text-gray-200 leading-none">Most Available Equipment</h2>
            <p class="text-2xl font-bold text-white leading-tight">Life Vests</p>
            <span class="text-xs text-gray-200 mt-1">⬆️ 150 units available</span>
            <div class="icon bg-[#C7EEDD] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full absolute bottom-2 right-2">📦</div>
        </div>

        <!-- Critical Stock -->
        <div class="bg-[#4cc9f0] p-4 shadow-lg rounded-lg border-l-4 border-[#4cc9f0] relative font-inter">
            <h2 class="text-sm font-semibold text-gray-200 leading-none">Critical Stock</h2>
            <p class="text-2xl font-bold text-white leading-tight">Flood Lights</p>
            <span class="text-xs text-gray-200 mt-1">⚠️ 2 units left</span>
            <div class="icon bg-[#C3EDFA] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full absolute bottom-2 right-2">⚠️</div>
        </div>

        <!-- Equipment Needing Repair -->
        <div class="bg-[#f0b84c] p-4 shadow-lg rounded-lg border-l-4 border-[#f0b84c] relative font-inter">
            <h2 class="text-sm font-semibold text-gray-200 leading-none">Equipment Needing Repair</h2>
            <p class="text-2xl font-bold text-white leading-tight">Megaphone</p>
            <span class="text-xs text-gray-200 mt-1">🔧 5 units under maintenance</span>
            <div class="icon bg-[#FAE7C3] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full absolute bottom-2 right-2">🛠️</div>
        </div>

        <!-- Recent Deployments -->
        <div class="bg-[#b79ced] p-4 shadow-lg rounded-lg border-l-4 border-[#b79ced] relative font-inter">
            <h2 class="text-sm font-semibold text-gray-200 leading-none">Recent Deployments</h2>
            <p class="text-2xl font-bold text-white leading-tight">Safety Helmet</p>
            <span class="text-xs text-gray-200 mt-1">🚛 20 units deployed</span>
            <div class="icon bg-[#E7DEF9] text-white text-3xl flex items-center justify-center w-14 h-14 rounded-full absolute bottom-2 right-2">🚚</div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 w-full">
        <!-- Most Borrowed Equipment (Blade-based) -->
        <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Most Borrowed Equipment</h2>
            <canvas id="mostBorrowedChart" style="width: 80%; height: 70%;"></canvas>
        </div>

        <!-- Low Stock -->
        <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Low Stock</h2>
            <canvas id="lowStockChart" style="width: 80%; height: 70%;"></canvas>
        </div>

        <!-- Equipment Quantity by Category -->
        <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Equipment Quantity by Category</h2>
            <canvas id="quantityByCategoryChart" style="width: 80%; height: 70%;"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 w-full">
        <!-- Equipment Usage Rate -->
        <div class="bg-white p-4 shadow-lg rounded-lg h-[32vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Equipment Usage Rate</h2>
            <canvas id="usageRateChart" style="width: 80%; height: 70%;"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Most Borrowed Equipment (Blade-based data)
        const mostBorrowedLabels = {!! Js::from($mostBorrowed->pluck('item_name')) !!};
        const mostBorrowedData = {!! Js::from($mostBorrowed->pluck('borrow_count')) !!};


        const mostBorrowedChart = new Chart(document.getElementById('mostBorrowedChart'), {
            type: 'bar',
            data: {
                labels: mostBorrowedLabels,
                datasets: [{
                    label: 'Borrow Count',
                    data: mostBorrowedData,
                    backgroundColor: '#A78BFA',
                    borderColor: '#A78BFA',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Low Stock (Static Dummy Data)
        new Chart(document.getElementById('lowStockChart'), {
            type: 'bar',
            data: {
                labels: ['Life Vests', 'Flood Lights', 'First Aid Kits'],
                datasets: [{
                    label: 'Low Stock Items',
                    data: [10, 2, 5],
                    backgroundColor: 'rgba(255, 99, 132)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                indexAxis: 'y',
                scales: {
                    x: { beginAtZero: true },
                    y: { beginAtZero: true }
                }
            }
        });

        // Equipment Quantity by Category (already working)
        const quantityByCategoryChart = new Chart(document.getElementById('quantityByCategoryChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: {!! Js::from($equipmentByCategory->pluck('category')) !!},
                datasets: [{
                    label: 'Equipment by Category',
                    data: {!! Js::from($equipmentByCategory->pluck('total_quantity')) !!},
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#B79CED'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { boxWidth: 20, padding: 15 }
                    }
                },
                aspectRatio: 1,
                layout: { padding: 10 }
            }
        });

        // Usage Rate Chart (Static)
        new Chart(document.getElementById('usageRateChart'), {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Usage Rate',
                    data: [30, 40, 20, 50, 60],
                    borderColor: 'rgba(76, 201, 240)',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });
    </script>
</div>

@endsection
