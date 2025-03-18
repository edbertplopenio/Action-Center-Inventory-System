@extends('layouts.app')

@section('title', 'Inventory')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<!-- 🌟 Sticky Main Container -->
<div class="container mx-auto px-4 py-6 bg-gray-100 rounded-lg shadow-md sticky top-0 z-10">
    
    <!-- 🌟 Sticky Tabs Container -->
<div class="sticky top-0 bg-white z-20 py-3 border-b border-gray-200 shadow-md">
    <div class="flex justify-center space-x-4">
        @foreach(['DRRM Equipment' => 'drrm', 'First Aid' => 'first-aid', 'Office Supplies' => 'office-supplies', 'Others' => 'others'] as $category => $id)
        <button id="{{ $id }}-tab" data-tabs-target="#{{ $id }}" 
            class="tab px-6 py-2 flex items-center space-x-2 rounded-lg text-white font-bold transition-all duration-200 
                   bg-green-400 hover:bg-green-500 active:bg-green-600">
            @if($category == 'DRRM Equipment') <span>🧑‍🚒</span> <!-- Changed icon to rescue worker -->
            @elseif($category == 'First Aid') <span class="text-brown-500">🩹</span>
            @elseif($category == 'Office Supplies') <span>📝</span>
            @elseif($category == 'Others') <span>📦</span>
            @endif
            <span>{{ $category }}</span>
        </button>
        @endforeach
    </div>
</div>

    <!-- Search, Sorter, and Pagination Controls -->
    <div class="flex flex-wrap items-center justify-between bg-white p-3 rounded-lg shadow-md mt-4 sticky top-[60px] z-10">
        <div class="flex items-center space-x-2">
            <input type="text" id="searchInput" placeholder="Search..." 
                class="border rounded-lg p-2 text-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none w-32">
            <select id="itemsPerPage" class="border rounded-lg p-2 text-sm">
                <option value="12">Show 12</option>
                <option value="18">Show 18</option>
                <option value="24">Show 24</option>
                <option value="30">Show 30</option>
                <option value="36">Show 36</option>
                <option value="42">Show 42</option>
            </select>
        </div>
        <div class="flex items-center space-x-2">
            <button id="prevPage" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600">◀️</button>
            <span id="pageNumber" class="text-sm font-semibold"></span>
            <button id="nextPage" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600">▶️</button>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="fullWidthTabContent" class="mt-4">
        @foreach(['DRRM Equipment' => 'drrm', 'First Aid' => 'first-aid', 'Office Supplies' => 'office-supplies', 'Others' => 'others'] as $category => $id)
        <div class="tab-content min-h-[500px]" id="{{ $id }}" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($items->where('category', $category) as $item)
                <div class="bg-white p-4 rounded-lg shadow-md transition-all duration-200 hover:scale-105">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                                    @if($category == 'DRRM Equipment') <span>🧑‍🚒</span> <!-- Changed icon to rescue worker -->
                            @elseif($category == 'First Aid') <span class="text-brown-500">🩹</span>
                            @elseif($category == 'Office Supplies') <span>📝</span>
                            @elseif($category == 'Others') <span>📦</span>
                            @endif
                        {{ $item->item_name }}
                    </h2>
                    <p class="text-sm text-gray-600"><strong>Category:</strong> {{ $item->category }}</p>
                    <p class="text-sm text-gray-600"><strong>Quantity:</strong> {{ $item->quantity }} pcs</p>
                    <p class="text-sm text-gray-600"><strong>Unit:</strong> {{ $item->unit }}</p>
                    <p class="text-sm text-gray-600"><strong>Description:</strong> {{ $item->description }}</p>
                    <p class="text-sm text-gray-600"><strong>Arrival Date:</strong> {{ \Carbon\Carbon::parse($item->arrival_date)->format('d/m/Y') }}</p>
                    <p class="text-sm font-semibold">
                        <strong>Status:</strong> 
                        <span class="{{ $item->status == 'Available' ? 'text-green-600' : ($item->status == 'Under Maintenance' ? 'text-orange-600' : 'text-red-600') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-600"><strong>Storage Location:</strong> {{ $item->storage_location }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    $(document).ready(function() {
        let itemsPerPage = 12; // Default items per page
        let currentPage = 1; // Start on page 1
        let activeTab = 'drrm'; // Default tab is DRRM
        let allItems = {}; // Store all items by category
        let filteredItems = {}; // Store filtered items

        // Function to initialize items in each tab
        function initializeItems() {
            ['drrm', 'first-aid', 'office-supplies', 'others'].forEach(category => {
                allItems[category] = $(`#${category} .bg-white`);
                filteredItems[category] = allItems[category]; // Initially, filtered items = all items
            });
        }

        // Function to paginate the items
        function paginate() {
            let items = filteredItems[activeTab]; // Use filtered items for active category
            let totalPages = Math.ceil(items.length / itemsPerPage); // Calculate total pages

            // Prevent pagination out of bounds
            if (currentPage > totalPages) {
                currentPage = Math.max(totalPages, 1);
            }

            // Update the page number
            $("#pageNumber").text(`Page ${currentPage} of ${totalPages || 1}`);

            // Hide all items, then show only the items for the current page
            allItems[activeTab].hide(); // Hide all items first
            items.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage).show();
        }

        // Initialize items for pagination
        initializeItems();

        // Show the first tab automatically when the page loads
        $(`#${activeTab}`).show();
        $(`#${activeTab}-tab`).addClass('bg-yellow-500');

        // Tab switching logic
        $('button[data-tabs-target]').click(function() {
            activeTab = $(this).attr('data-tabs-target').substring(1);
            $('.tab-content').hide();
            $(`#${activeTab}`).show();
            $('button[data-tabs-target]').removeClass('bg-yellow-500').addClass('bg-yellow-400');
            $(this).removeClass('bg-yellow-400').addClass('bg-yellow-500');
            currentPage = 1;  // Reset to first page when switching tabs
            $("#searchInput").val(""); // Clear search when switching tabs
            filteredItems[activeTab] = allItems[activeTab]; // Reset search results
            paginate();  // Apply pagination for the active tab
        });

        // Search functionality (Only searches item titles)
        $("#searchInput").on("keyup", function() {
            let term = $(this).val().toLowerCase(); // Get the search term
            filteredItems[activeTab] = allItems[activeTab].filter(function() {
                let title = $(this).find("h2").text().toLowerCase(); // Search only in the h2 (Title)
                return title.includes(term); // Filter items based on title
            });

            // Reset pagination to first page after search
            currentPage = 1;
            paginate();  // Re-paginate after filtering
        });

        // Items per page selection
        $('#itemsPerPage').change(function() {
            itemsPerPage = parseInt($(this).val()); // Get selected items per page
            currentPage = 1; // Reset to first page
            paginate();  // Apply pagination with new items per page
        });

        // Previous and Next page buttons
        $('#prevPage').click(function() {
            if (currentPage > 1) {
                currentPage--;  // Go to the previous page
                paginate();  // Re-paginate
            }
        });

        $('#nextPage').click(function() {
            let totalPages = Math.ceil(filteredItems[activeTab].length / itemsPerPage);
            if (currentPage < totalPages) {
                currentPage++;  // Go to the next page
                paginate();  // Re-paginate
            }
        });

        // Initialize the pagination when the page loads
        paginate();
    });
</script>

@endsection
