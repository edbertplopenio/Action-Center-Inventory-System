@extends('layouts.app')

@section('title', 'Action Center')

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
        <!-- Equipment Age Distribution -->
        <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Equipment Age Distribution</h2>
            <canvas id="ageDistributionChart" style="width: 80%; height: 70%;">"></canvas>
        </div>

        <!-- Low Stock -->
        <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Low Stock</h2>
            <canvas id="lowStockChart" style="width: 80%; height: 70%;">"></canvas>
        </div>

        <!-- Equipment Quantity by Category -->
        <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Equipment Quantity by Category</h2>
            <canvas id="quantityByCategoryChart" style="width: 80%; height: 70%;">></canvas>
        </div>

    </div>

    <!-- Two-Column Layout for Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 w-full">

        <!-- Equipment Usage Rate -->
        <div class="bg-white p-4 shadow-lg rounded-lg h-[32vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Equipment Usage Rate</h2>
            <canvas id="usageRateChart" style="width: 80%; height: 70%;"></canvas> <!-- Adjusting the canvas size here -->
        </div>


<!-- Recent Deployments by Category -->
<div class="bg-white p-4 shadow-lg rounded-lg h-[32vh] w-full overflow-hidden">
    <h2 class="text-sm font-semibold text-gray-800 mb-3 sticky top-0 bg-white z-20">Recent Deployments</h2>
    <div class="overflow-y-auto h-[23vh]">
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
                <tr class="border-t bg-gray-50">
                    <td class="px-3 py-1 text-xs text-gray-800">Portable Generator</td>
                    <td class="px-3 py-1 text-xs text-gray-800">2</td>
                    <td class="px-3 py-1 text-xs text-gray-800">Fair</td>
                </tr>
                <tr class="border-t">
                    <td class="px-3 py-1 text-xs text-gray-800">Rescue Rope</td>
                    <td class="px-3 py-1 text-xs text-gray-800">15</td>
                    <td class="px-3 py-1 text-xs text-gray-800">Good</td>
                </tr>
                <tr class="border-t bg-gray-50">
                    <td class="px-3 py-1 text-xs text-gray-800">Searchlight</td>
                    <td class="px-3 py-1 text-xs text-gray-800">8</td>
                    <td class="px-3 py-1 text-xs text-gray-800">Excellent</td>
                </tr>
                <tr class="border-t">
                    <td class="px-3 py-1 text-xs text-gray-800">Water Purification Tablets</td>
                    <td class="px-3 py-1 text-xs text-gray-800">200</td>
                    <td class="px-3 py-1 text-xs text-gray-800">Excellent</td>
                </tr>
                <tr class="border-t bg-gray-50">
                    <td class="px-3 py-1 text-xs text-gray-800">Portable Shelter</td>
                    <td class="px-3 py-1 text-xs text-gray-800">10</td>
                    <td class="px-3 py-1 text-xs text-gray-800">Good</td>
                </tr>
                <tr class="border-t">
                    <td class="px-3 py-1 text-xs text-gray-800">Safety Helmets</td>
                    <td class="px-3 py-1 text-xs text-gray-800">25</td>
                    <td class="px-3 py-1 text-xs text-gray-800">Fair</td>
                </tr>
                <tr class="border-t bg-gray-50">
                    <td class="px-3 py-1 text-xs text-gray-800">Emergency Blankets</td>
                    <td class="px-3 py-1 text-xs text-gray-800">30</td>
                    <td class="px-3 py-1 text-xs text-gray-800">Good</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<style>
    tbody tr:hover {
        background-color: #C7EEDD;
    }

    th{
        background-color: #C7EEDD;
        text-align: center; /* Center the text in header cells */
    }

    tbody{
        text-align: center;
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


        // Dummy Data for Low Stock (Horizontal Bar Chart)
        var ctx2 = document.getElementById('lowStockChart').getContext('2d');
        var lowStockChart = new Chart(ctx2, {
            type: 'bar', // Bar chart type
            data: {
                labels: ['Life Vests', 'Flood Lights', 'First Aid Kits'],
                datasets: [{
                    label: 'Low Stock Items',
                    data: [10, 2, 5], // Dummy low stock data
                    backgroundColor: 'rgba(255, 99, 132)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                indexAxis: 'y', // This makes the chart horizontal
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        // Dummy Data for Equipment Quantity by Category (Pie Chart)
        var ctx3 = document.getElementById('quantityByCategoryChart').getContext('2d');
        var quantityByCategoryChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Safety Equipment', 'Rescue Equipment', 'Office Equipment', 'Other Equipment'],
                datasets: [{
                    label: 'Equipment by Category',
                    data: [80, 150, 50, 60], // Dummy data for each category
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#B79CED', ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Ensures chart is responsive
                maintainAspectRatio: false, // Allows resizing of the chart to fit the container
                plugins: {
                    legend: {
                        position: 'right', // This places the legend to the right
                        labels: {
                            boxWidth: 20, // Size of the legend boxes
                            padding: 15 // Space between the legend boxes and labels
                        }
                    }
                },
                // Set explicit width and height of the chart
                aspectRatio: 1, // 1 is a square, adjust it as needed (less than 1 makes the chart more wide)
                layout: {
                    padding: 10
                }
            }
        });



        // Dummy Data for Equipment Usage Rate (Line Chart)
        var ctx4 = document.getElementById('usageRateChart').getContext('2d');
        var usageRateChart = new Chart(ctx4, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [{
                    label: 'Usage Rate',
                    data: [30, 40, 20, 50, 60], // Dummy data showing monthly usage
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

        // Dummy Data for Recent Deployments by Category (Stacked Column Chart)
        // var ctx5 = document.getElementById('deploymentsByCategoryChart').getContext('2d');
        // var deploymentsByCategoryChart = new Chart(ctx5, {
        //     type: 'bar',  // Use 'bar' for a column chart
        //     data: {
        //         labels: ['Safety Equipment', 'Rescue Equipment', 'Medical Equipment'],
        //         datasets: [{
        //             label: 'Deployments by Category',
        //             data: [20, 15, 10], // Dummy data for deployments by category
        //             backgroundColor: 'rgba(87, 204, 153)', // Color of the bars
        //             borderColor: 'rgba(87, 204, 153)', // Border color of the bars
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: true,
        //         scales: {
        //             y: {
        //                 beginAtZero: true
        //             },
        //             x: {
        //                 stacked: true // Enable stacking on the x-axis
        //             },
        //             y: {
        //                 stacked: true // Enable stacking on the y-axis
        //             }
        //         }
        //     }
        // });
    </script>

</div>
@endsection