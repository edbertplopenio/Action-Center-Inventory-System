@extends('layouts.app')

@section('title', 'Action Center')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<div class="container mx-auto p-2 mt-0">
    <!-- Header -->
    <div class="flex justify-between items-center mb-2">
        <h1 class="text-2xl font-semibold text-gray-800 leading-tight">Dashboard</h1>
    </div>

    <!-- Grid Layout with reduced space -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
        <!-- Most Available Equipment -->
        <div class="bg-[#57cc99] p-3 shadow-lg rounded-lg border-l-4 border-[#57cc99] relative font-inter">
            <h2 class="text-xs font-semibold text-gray-200 leading-none">Most Available Equipment</h2>
            <p class="text-xl font-bold text-white leading-tight">Life Vests</p>
            <span class="text-xs text-gray-200 mt-1">⬆️ 150 units available</span>
            <div class="icon bg-[#C7EEDD] text-white text-2xl flex items-center justify-center w-12 h-12 rounded-full absolute bottom-2 right-2">
                📦
            </div>
        </div>

        <!-- Critical Stock (Low Inventory) -->
        <div class="bg-[#4cc9f0] p-3 shadow-lg rounded-lg border-l-4 border-[#4cc9f0] relative font-inter">
            <h2 class="text-xs font-semibold text-gray-200 leading-none">Critical Stock</h2>
            <p class="text-xl font-bold text-white leading-tight">Flood Lights</p>
            <span class="text-xs text-gray-200 mt-1">⚠️ 2 units left</span>
            <div class="icon bg-[#C3EDFA] text-white text-2xl flex items-center justify-center w-12 h-12 rounded-full absolute bottom-2 right-2">
                ⚠️
            </div>
        </div>

        <!-- Equipment Needing Repair -->
        <div class="bg-[#f0b84c] p-3 shadow-lg rounded-lg border-l-4 border-[#f0b84c] relative font-inter">
            <h2 class="text-xs font-semibold text-gray-200 leading-none">Equipment Needing Repair</h2>
            <p class="text-xl font-bold text-white leading-tight">Megaphone</p>
            <span class="text-xs text-gray-200 mt-1">🔧 5 units under maintenance</span>
            <div class="icon bg-[#FAE7C3] text-white text-2xl flex items-center justify-center w-12 h-12 rounded-full absolute bottom-2 right-2">
                🛠️
            </div>
        </div>

        <!-- Recent Deployments -->
        <div class="bg-[#b79ced] p-3 shadow-lg rounded-lg border-l-4 border-[#b79ced] relative font-inter">
            <h2 class="text-xs font-semibold text-gray-200 leading-none">Recent Deployments</h2>
            <p class="text-xl font-bold text-white leading-tight">Safety Helmet</p>
            <span class="text-xs text-gray-200 mt-1">🚛 20 units deployed</span>
            <div class="icon bg-[#E7DEF9] text-white text-2xl flex items-center justify-center w-12 h-12 rounded-full absolute bottom-2 right-2">
                🚚
            </div>
        </div>
    </div>

    <!-- Three-Column Layout for Charts with compact cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 mt-2 w-full">
        <!-- Equipment Age Distribution -->
        <div class="bg-white p-3 shadow-lg rounded-lg h-[30vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Equipment Age Distribution</h2>
            <canvas id="ageDistributionChart" style="width: 100%; height: 100%;"></canvas>
        </div>

        <!-- Low Stock (Populated with data) -->
        <div class="bg-white p-3 shadow-lg rounded-lg h-[30vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Low Stock</h2>
            <canvas id="lowStockChart" style="width: 100%; height: 100%;"></canvas>
        </div>

        <!-- Equipment Quantity by Category -->
        <div class="bg-white p-3 shadow-lg rounded-lg h-[30vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Equipment Quantity by Category</h2>
            <canvas id="quantityByCategoryChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>

    <!-- Two-Column Layout for Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2 w-full">

        <!-- Equipment Usage Rate -->
        <div class="bg-white p-3 shadow-lg rounded-lg h-[28vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Equipment Usage Rate</h2>
            <canvas id="usageRateChart" style="width: 100%; height: 100%;"></canvas>
        </div>

        <!-- Recent Deployments by Category -->
        <div class="bg-white p-3 shadow-lg rounded-lg h-[28vh] w-full overflow-hidden">
            <h2 class="text-sm font-semibold text-gray-800 mb-2 sticky top-0 bg-white z-20">Recent Deployments</h2>
            <div class="overflow-y-auto h-[20vh]">
                <table class="min-w-full table-auto border-collapse text-xs">
                    <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-3 py-1 text-center text-xs font-medium text-gray-600 uppercase">Equipment</th>
                            <th class="px-3 py-1 text-center text-xs font-medium text-gray-600 uppercase">Quantity</th>
                            <th class="px-3 py-1 text-center text-xs font-medium text-gray-600 uppercase">Condition</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="px-3 py-1 text-xs text-gray-800">First Aid Kit</td>
                            <td class="px-3 py-1 text-xs text-gray-800">10</td>
                            <td class="px-3 py-1 text-xs text-gray-800">Good</td>
                        </tr>
                        <tr class="border-t bg-gray-50">
                            <td class="px-3 py-1 text-xs text-gray-800">Fire Extinguisher</td>
                            <td class="px-3 py-1 text-xs text-gray-800">5</td>
                            <td class="px-3 py-1 text-xs text-gray-800">Excellent</td>
                        </tr>
                        <tr class="border-t">
                            <td class="px-3 py-1 text-xs text-gray-800">Water Supply</td>
                            <td class="px-3 py-1 text-xs text-gray-800">50</td>
                            <td class="px-3 py-1 text-xs text-gray-800">Good</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<style>
    tbody tr:hover {
        background-color: #C7EEDD;
    }

    th {
        background-color: #C7EEDD;
        text-align: center;
    }

    tbody {
        text-align: center;
    }

    /* Adjust grid spacing */
    .grid {
        gap: 1rem;
    }

    /* Responsive for small and large screens */
    @media (max-width: 1024px) {
        .grid-cols-1 {
            grid-template-columns: 1fr;
        }
        .grid-cols-2 {
            grid-template-columns: 1fr 1fr;
        }
        .grid-cols-3 {
            grid-template-columns: 1fr 1fr 1fr;
        }
    }
</style>

<!-- Initialize Charts -->
<script>
    // Dummy Data for Equipment Age Distribution (Bar Chart)
    var ctx1 = document.getElementById('ageDistributionChart').getContext('2d');
    var ageDistributionChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['0-1 Years', '1-5 Years', '5+ Years'],
            datasets: [{
                label: 'Equipment Age Distribution',
                data: [50, 120, 30], // Dummy data for each age group
                backgroundColor: '#B79CED', // Solid color for bars
                borderColor: '#B79CED', // Solid color for borders
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Other charts initialization goes here (lowStockChart, quantityByCategoryChart, etc.) as per your previous setup...
</script>

</div>
@endsection
