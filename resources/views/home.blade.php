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

    <!-- Grid Layout for Dashboard Items with 5 items in one row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Borrowing Request Section -->
        <div class="bg-[#e57373] p-4 shadow-lg rounded-lg border-l-4 border-[#e57373] relative font-inter">
            <h2 class="text-sm font-semibold text-gray-200 leading-none">Borrowing Request</h2>
            <!-- Display Pending Borrowing Requests -->
            @php
                $pendingRequests = $borrowedItems->where('status', 'Pending');
            @endphp

            @if($pendingRequests->count() > 0)
                <div class="mb-4">
                    <!-- Display number of pending requests -->
                    <p class="text-1xl font-bold text-white leading-tight">
                         {{ $pendingRequests->count() }} pending request(s)
                    </p>
                    <div class="icon bg-[#FAE7C3] text-white text-3xl flex items-center justify-center w-10 h-10 rounded-full absolute bottom-2 right-2">
                        ⏳
                    </div>
                </div>

<!-- Display only 1 pending equipment -->
<div class="mt-4">
        @php
            $firstPendingRequest = $pendingRequests->first(); // Get the first pending request
        @endphp

        @if($firstPendingRequest && $firstPendingRequest->item) <!-- Check if the first request has an item -->
            <p class="text-white">
                <strong>Equipment:</strong> {{ $firstPendingRequest->item->name }}<br>
                <strong>Quantity:</strong> {{ $firstPendingRequest->quantity_borrowed }}<br>
            </p>
        @endif
    </div>
@else
    <p class="text-white">No pending borrowing requests.</p>
@endif
        </div>

        <!-- Most Available Equipment -->
        <div class="bg-[#57cc99] p-4 shadow-lg rounded-lg border-l-4 border-[#57cc99] relative font-inter">
            <h2 class="text-sm font-semibold text-gray-200 leading-none">Most Available<br>Equipment</h2>
            @if($mostAvailableItems->count() > 0)
                @foreach($mostAvailableItems as $item)
                    <div class="mb-4">
                        <p class="text-2xl font-bold text-white leading-tight">{{ $item->name }}</p>
                        <span class="text-xs text-gray-200 mt-1">⬆️ {{ $item->quantity }} units available</span>
                        <div class="icon bg-[#C7EEDD] text-white text-3xl flex items-center justify-center w-10 h-10 rounded-full absolute bottom-2 right-2">
                            📦
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-white">No equipment available.</p>
            @endif
        </div>

        <!-- Critical Stock (Low Inventory) -->
        <div class="bg-[#4cc9f0] p-4 shadow-lg rounded-lg border-l-4 border-[#4cc9f0] relative font-inter">
            <h2 class="text-sm font-semibold text-gray-200 leading-none">Critical Stock</h2>
            @if($criticalStockItems->count() > 0)
                @foreach($criticalStockItems as $item)
                    <div class="mb-4">
                        <p class="text-2xl font-bold text-white leading-tight">{{ $item->name }}</p>
                        <span class="text-xs text-gray-200 mt-1">⚠️ {{ $item->quantity }} units left</span>
                        <div class="icon bg-[#C3EDFA] text-white text-3xl flex items-center justify-center w-10 h-10 rounded-full absolute bottom-2 right-2">
                            ⚠️
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-white">No critical stock available.</p>
            @endif
        </div>

        <!-- Equipment Needing Repair -->
        <div class="bg-[#f0b84c] p-4 shadow-lg rounded-lg border-l-4 border-[#f0b84c] relative font-inter">
            <h2 class="text-sm font-semibold text-gray-200 leading-none">Equipment Needing<br>Repair</h2>
            @if($itemsNeedingRepair->count() > 0)
                @foreach($itemsNeedingRepair as $item)
                    <div class="mb-4">
                        <p class="text-2xl font-bold text-white leading-tight">{{ $item->name }}</p>
                        <span class="text-xs text-gray-200 mt-1">🔧 {{ $item->quantity }} units under maintenance</span>
                        <div class="icon bg-[#FAE7C3] text-white text-3xl flex items-center justify-center w-10 h-10 rounded-full absolute bottom-2 right-2">
                            🛠️
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-white">No equipment needing repair.</p>
            @endif
        </div>

        <!-- Recent Deployments -->
        <div class="bg-[#b79ced] p-4 shadow-lg rounded-lg border-l-4 border-[#b79ced] relative font-inter">
            <h2 class="text-sm font-semibold text-gray-200 leading-none">Recent Deployments</h2>
            @if($recentDeploymentFirst->count() > 0)
                @foreach($recentDeploymentFirst as $deployment)
                    <div class="mb-4">
                        <p class="text-2xl font-bold text-white leading-tight">{{ $deployment->item->name }}</p>
                        <span class="text-xs text-gray-200 mt-1">🚛 {{ $deployment->quantity_borrowed }} units deployed</span>
                        <div class="icon bg-[#E7DEF9] text-white text-3xl flex items-center justify-center w-10 h-10 rounded-full absolute bottom-2 right-2">
                            🚚
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-white">No recent deployments.</p>
            @endif
        </div>
    </div>
</div>




    <!-- Three-Column Layout for Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 w-full">
        <!-- Most Borrowed Items -->
        <div class="bg-white p-4 shadow-lg rounded-lg h-[35vh] w-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Most Borrowed Items</h2>
            <canvas id="mostborroweditemsChart" style="width: 80%; height: 70%;">"></canvas>
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


 <!-- Equipment Usage -->
 <div class="bg-white p-4 shadow-lg rounded-lg h-[32vh] w-full relative">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Monthly Equipment Utilization</h2>

    <!-- Drop-down list with centered text -->
    <div class="absolute top-4 right-4">
        <label for="usageRateSelect" class="text-sm text-gray-600">Select Equipment:</label>
        <select id="usageRateSelect" class="mt-2 block w-full max-w-md h-10 p-2 border rounded-md bg-gray-50 text-gray-800">
            @foreach($equipment as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <canvas id="usageRateChart" style="width: 80%; height: 70%;"></canvas>
</div>

<style>
    #usageRateSelect {
        width: 100%; /* Make the select element span the available width */
        max-width: 200px; /* Set a max-width if needed */
        text-align: left; /* Align the text inside the select element */
    }
    .absolute {
        right: 0; /* Ensure it is aligned to the right of the parent container */
        top: 4%; /* You can adjust the top percentage as needed */
    }
</style>


<!-- Recent Deployments by Category -->
<div class="bg-white p-4 shadow-lg rounded-lg h-[32vh] w-full overflow-hidden">
    <h2 class="text-sm font-semibold text-gray-800 mb-3 sticky top-0 bg-white z-20">Recent Deployments</h2>
    <div class="overflow-y-auto h-[23vh]">
        <table class="min-w-full table-auto border-collapse text-xs">
            <thead class="bg-gray-100 sticky top-0 z-10">
                <tr>
                    <th class="px-3 py-1 text-center text-xs font-medium text-gray-600 uppercase">Equipment</th>
                    <th class="px-3 py-1 text-center text-xs font-medium text-gray-600 uppercase">Quantity</th>
                    <th class="px-3 py-1 text-center text-xs font-medium text-gray-600 uppercase">Date Borrowed</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentDeploymentsNext as $deployment)
                    <tr class="border-t">
                        <td class="px-3 py-1 text-xs text-gray-800">{{ $deployment->item->name }}</td>
                        <td class="px-3 py-1 text-xs text-gray-800">{{ $deployment->quantity_borrowed }}</td>
                        <td class="px-3 py-1 text-xs text-gray-800">{{ \Carbon\Carbon::parse($deployment->borrow_date)->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
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

 // most borrowed items Chart 

// Pass PHP data to JavaScript
var mostBorrowedItems = @json($mostBorrowedItems);

// Extract item names and borrowed quantities
var itemNames = mostBorrowedItems.map(item => item.item_name);  // Using item_name from the query result
var quantities = mostBorrowedItems.map(item => item.total_borrowed);  // Using total_borrowed from the query result

// Create the chart
var ctx1 = document.getElementById('mostborroweditemsChart').getContext('2d');
var mostborroweditemsChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: itemNames, // Using item names as labels
        datasets: [{
            label: 'Most Borrowed Items',
            data: quantities, // Using the quantities of borrowed items
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


 // Low Stock Chart
 var lowStockItemsNames = <?php echo json_encode($lowStockItems->pluck('name')->toArray()); ?>;
    var lowStockItemsQuantities = <?php echo json_encode($lowStockItems->pluck('quantity')->toArray()); ?>;

    var ctx2 = document.getElementById('lowStockChart').getContext('2d');
    var lowStockChart = new Chart(ctx2, {
        type: 'bar', // Bar chart type
        data: {
            labels: lowStockItemsNames, // Get item names
            datasets: [{
                label: 'Low Stock Items',
                data: lowStockItemsQuantities, // Get item quantities
                backgroundColor: 'rgba(255, 99, 132, 1)', // Pink color for the bars
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


 // Quantity By Category Chart

  // Pass PHP data to JavaScript
  var categoryCounts = @json($categoryCounts);

// Extract category names and their corresponding total quantities
var categories = categoryCounts.map(item => item.category);
var quantities = categoryCounts.map(item => item.total_quantity);  // Use total quantity for each category

// Create the pie chart
var ctx3 = document.getElementById('quantityByCategoryChart').getContext('2d');
var quantityByCategoryChart = new Chart(ctx3, {
    type: 'pie',
    data: {
        labels: categories, // Equipment categories
        datasets: [{
            label: 'Equipment by Category',
            data: quantities, // Quantities of items in each category
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#B79CED'],  // You can add more colors if needed
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
        aspectRatio: 1, // 1 is a square, adjust it as needed
        layout: {
            padding: 10
        }
    }
});

 // Usage Rate Chart

  // Load equipment list dynamically when the page is ready
  document.addEventListener("DOMContentLoaded", function() {
        // Fetch all items (equipment) from the backend
        fetch('/api/items')
            .then(response => response.json())
            .then(data => {
                const selectElement = document.getElementById('usageRateSelect');
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;  // Use the item ID as the value
                    option.textContent = item.name;  // Display the item name in the dropdown
                    selectElement.appendChild(option);
                });

                // Fetch initial data for the default selected item (first item in the dropdown)
                updateUsageRateChart(selectElement.value);
            })
            .catch(error => console.error('Error fetching items:', error));
    });

    // Function to fetch and update the chart data based on selected item
    function updateUsageRateChart(itemId) {
        fetch(`/api/usage-rate/${itemId}`)
            .then(response => response.json())
            .then(data => {
                // Update chart labels and data
                usageRateChart.data.labels = data.labels;
                usageRateChart.data.datasets[0].data = data.data;
                usageRateChart.update();  // Update the chart with new data
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    // Initialize the chart (this will be updated later)
    var ctx = document.getElementById('usageRateChart').getContext('2d');
    var usageRateChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July','August', 'September', 'October', 'November','December'], // Default labels
            datasets: [{
                label: 'Usage Rate',
                data: [0, 0, 0, 0, 0], // Default data
                borderColor: 'rgba(76, 201, 240)',  // Line color
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

    // Listen to the select change event
    document.getElementById('usageRateSelect').addEventListener('change', function() {
        const selectedItemId = this.value;
        updateUsageRateChart(selectedItemId);  // Fetch and update chart when user selects an item
    });
</script>
@endsection