<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <style>

        html, body {
            overflow: hidden; /* Prevent scrolling on the entire page */
            height: 100%; /* Ensure full height without extra spacing */
            margin: 0;
            padding: 0;
        }


        /* Hide all tables by default, only show the active tab's table */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }

        /* Custom tab color styles */
        .tab-button {
            padding: 0.5rem 1.5rem;
            font-size: 0.9rem; /* Reduced font size */
            font-weight: 500;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .tab-button:hover {
            opacity: 0.8;
        }

        .tab-button.active {
            font-weight: bold;
        }

        /* Flex container for Tabs and Add Item Button */
        .tab-container {
            display: flex;
            align-items: center;
            margin-bottom: -0.2rem;
        }

        .tab-button-container {
            display: flex;
        }

        .tab-button + .tab-button {
            margin-left: 0.5rem;
        }

        /* Position the Add Item button to the right side of the tabs */
        #add-item-btn {
            margin-left: auto; /* Push the button to the far right */
            background-color: #38A169; /* Green */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #add-item-btn:hover {
            background-color: #2F9C5A;
        }

        /* Custom Tab Colors */
        .equipment-tab {
            background-color: #4A90E2; /* Blue */
        }

        .office-supplies-tab {
            background-color:rgb(118, 82, 236); /* Orange */
        }

        .emergency-kits-tab {
            background-color:rgb(244, 56, 232); /* Red */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }

        table th, table td {
            padding: 0.6rem; /* Reduced padding for better alignment */
            text-align: left;
            border-bottom: 1px solid #E5E5E5;
            font-size: 0.9rem; /* Reduced font size */
        }
        table th {
            background-color: #F7FAFC;
            color: #2D3748;
        }

        table tr:hover {
            background-color: #F1F1F1;
        }

        .table-container {
            width: 100%;           /* Ensure it fills the width of the parent */
            height: 550px;  
            max-height; 650px;       /* Adjust the height as needed */
            overflow-y: scroll;    /* Enable vertical scrolling */
            overflow-x: hidden;    /* Disable horizontal scrolling */
        }

        table {
            width: 100%;           /* Ensure the table takes the full width of the container */
            table-layout: fixed;   /* Prevent table from expanding beyond its container */
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Ensures column alignment */
        }

        .table-container thead {
            position: sticky;
            top: 0;
            background-color: white; /* Keeps the header visible */
            z-index: 5;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
        }

        .table-footer {
            width: 100%;
            background-color: white; /* Ensure footer has a solid background */
            position: sticky;
            bottom: 0;
            z-index: 10;  /* Ensure it stays on top of other content */
        }

        /* Styling for the Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px; /* Para may spacing between buttons */
            min-width: 120px; /* Fixed width para di gagalaw */
        }

        .edit-btn, .archive-btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
            width: 60px; /* Fixed width para pareho ang laki */
            margin-bottom: 5px;
            margin-top: 2px;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit-btn:hover {
            background-color: #45A049;
        }

        .archive-btn {
            display: flex;  /* Enable flexbox */
            justify-content: center;  /* Center horizontally */
            align-items: center;  /* Center vertically */
            padding: 6px 12px;  /* Adjust padding to control the button size */
            border-radius: 4px;
            font-size: 14px;
            background-color: rgb(255, 145, 48);
            color: white;
            text-align: center;  /* Ensure the text is centered */
            cursor: pointer;
            width: auto;  /* Optional: Adjust the button's width */
        }

        .archive-btn:hover {
            background-color: #D32F2F;  /* Hover effect */
        }


        /* Form row layout (two fields per row) */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr; /* 2 columns */
            gap: 1rem; /* Space between columns */
        }

        .form-row > div {
            margin-bottom: 1rem; /* Margin for each field */
        }

        .archives-tab {
            background-color: rgb(0, 123, 255); /* Blue color for the Archives tab */
        }

        /* Make the table scrollable while keeping the pagination at the bottom */
    table.dataTable {
        width: 100%; /* Ensure the table takes up the full width of the container */
    }

    /* Optional: Ensure the table container has a maximum height */
    .table-container {
        max-height: 500px;  /* Adjust based on your layout */
        overflow-y: auto;   /* Enable vertical scrolling */
    }

    /* Style pagination and entries at the bottom */
    .dataTables_wrapper .dataTables_info, 
    .dataTables_wrapper .dataTables_paginate {
        position: sticky;
        bottom: 0;
        z-index: 10;
        background-color: white;
    }


    </style>
</head>
<body class="bg-gray-100">

<!-- Modal Overlay for Adding Item -->
<div id="item-form-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg w-2/3 max-w-4xl">
        <h3 class="text-xl font-semibold mb-4">Add New Item</h3>
        <form id="item-form" action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Start of form row (2 fields per row) -->
            <div class="form-row">
                <!-- Item Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-black mb-2">Item Name</label>
                    <input type="text" id="name" name="name" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-black mb-2">Category</label>
                    <select id="category" name="category" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                    <option value="DRRM Equipment">DRRM Equipment</option>    
                    <option value="Office Supplies">Office Supplies</option>
                    <option value="Emergency Kits">Emergency Kits</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-semibold text-black mb-2">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>

                <!-- Unit -->
                <div>
                    <label for="unit" class="block text-sm font-semibold text-black mb-2">Unit</label>
                    <input type="text" id="unit" name="unit" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>
            </div>

            <div class="form-row">
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-black mb-2">Description</label>
                    <input type="text" id="description" name="description" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>

                <!-- Arrival Date -->
                <div>
                    <label for="arrival_date" class="block text-sm font-semibold text-black mb-2">Arrival Date</label>
                    <input type="date" id="arrival_date" name="arrival_date" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>
            </div>

            <div class="form-row">
                <!-- Date Purchased -->
                <div>
                    <label for="date_purchased" class="block text-sm font-semibold text-black mb-2">Date Purchased</label>
                    <input type="date" id="date_purchased" name="date_purchased" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-black mb-2">Status</label>
                    <select id="status" name="status" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                    </select>
                </div>
            </div>

            <!-- Image -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-semibold text-black mb-2">Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Storage Location -->
            <div class="mb-4">
                <label for="storage_location" class="block text-sm font-semibold text-black mb-2">Storage Location</label>
                <input type="text" id="storage_location" name="storage_location" class="w-full p-2 border rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-4">
                <button type="reset" id="cancel-btn" class="px-4 py-2 bg-green-400 text-black rounded-md transition duration-300 hover:bg-green-600 hover:text-white">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-400 text-black rounded-md transition duration-300 hover:bg-green-600 hover:text-white">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="flex-1 p-6 relative">
    <div class="bg-white shadow-md rounded-lg p-6">
        <!-- Tabs -->
        <div class="tab-container">
            <div class="tab-button-container">
            <button id="equipment-tab" class="tab-button equipment-tab" onclick="switchTab('equipment')">DRRM Equipment</button>
            <button id="office-supplies-tab" class="tab-button office-supplies-tab ml-2" onclick="switchTab('office-supplies')">Office Supplies</button>
            <button id="emergency-kits-tab" class="tab-button emergency-kits-tab ml-2" onclick="switchTab('emergency-kits')">Emergency Kits</button>
            <button id="archives-tab" class="tab-button archives-tab ml-2" onclick="switchTab('archives')">Archives</button>
            </div>
            <!-- Add Item Button (Right Aligned) -->
            <button id="add-item-btn" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                + Add Item
            </button>
        </div>

        <!-- Equipment Tab -->
        <!-- Equipment Tab -->
<div id="equipment-content" class="tab-content active">
    <h3 class="text-xl font-semibold" style="margin-bottom: 7px;">DRRM Equipment</h3>
    <div class="table-container">
        <table id="equipmentTable" class="display">
            <thead>
                <tr>
                    <th>Equipment Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Date Purchased</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10"></td>
                        <td class="action-buttons">
                            <button class="edit-btn">Edit</button>
                            <button class="archive-btn">Archive</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


        <!-- Office Supplies Tab -->
<div id="office-supplies-content" class="tab-content">
    <h3 class="text-xl font-semibold" style="margin-bottom: 7px;">Office Supplies</h3>
    <div class="table-container">
        <table id="officeSuppliesTable" class="display">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Date Purchased</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($officeSupplies as $item)
                    <tr>
                        <td><input type="checkbox" class="select-item" name="item_ids[]" value="{{ $item->id }}"></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10"></td>
                        <td class="action-buttons">
                            <button class="edit-btn">Edit</button>
                            <button class="archive-btn">Archive</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Emergency Kits Tab -->
<div id="emergency-kits-content" class="tab-content">
    <h3 class="text-xl font-semibold" style="margin-bottom: 7px;">Emergency Kits</h3>
    <div class="table-container">
        <table id="emergencyKitsTable" class="display">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Date Purchased</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emergencyKits as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10"></td>
                        <td class="action-buttons">
                            <button class="edit-btn">Edit</button>
                            <button class="archive-btn">Archive</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Archives Tab -->
<div id="archives-content" class="tab-content">
    <h3 class="text-xl font-semibold" style="margin-bottom: 7px;">Archives</h3>
    <div class="table-container">
        <table id="archivesTable" class="display">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all-archives" onclick="selectAllCheckboxes('archives')"></th>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Date Purchased</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example archived item -->
                <tr>
                    <td><input type="checkbox" class="select-item" name="item_ids[]" value="1"></td>
                    <td>Archived Item 1</td>
                    <td>5</td>
                    <td>pcs</td>
                    <td>Item description</td>
                    <td>Location A</td>
                    <td>2025-01-01</td>
                    <td>2024-12-01</td>
                    <td>Archived</td>
                    <td><img src="image_url" alt="Archived Item 1" class="w-10 h-10"></td>
                    <td class="action-buttons">
                        <button class="edit-btn">Edit</button>
                        <button class="archive-btn">Restore</button>
                    </td>
                </tr>
                <!-- Add more archived items here -->
            </tbody>
        </table>
    </div>
</div>

    </div>
</div>

<script>
    function switchTab(tab) {
        console.log("Switching to tab: ", tab);  // For debugging purposes

        // Hide all tabs by default and remove the 'active' class
        var tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(function (tabContent) {
            tabContent.classList.remove('active'); // Remove active class
            tabContent.style.display = 'none'; // Hide all tab contents
        });

        // Show the selected tab and add the 'active' class
        var activeTabContent = document.getElementById(tab + '-content');
        activeTabContent.classList.add('active');  // Add active class to the selected tab
        activeTabContent.style.display = 'block'; // Show the selected tab content

        // Remove the 'active' class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(function (btn) {
            btn.classList.remove('active');
        });

        // Add the 'active' class to the clicked tab button
        document.getElementById(tab + '-tab').classList.add('active');

        // Reinitialize DataTables after switching tabs
        initializeDataTables();
    }

    // Function to initialize DataTables
    function initializeDataTables() {
        $('table').each(function () {
            if (!$.fn.DataTable.isDataTable(this)) {
                $(this).DataTable();
            }
        });
    }

    // Ensure DataTables is initialized when the page loads
    $(document).ready(function () {
        $('#equipmentTable').DataTable({
        "scrollY": "400px",         // Set a fixed height for the table body
        "scrollCollapse": true,     // Allow the table to shrink in height when fewer rows are present
        "paging": true,             // Enable pagination
        "pagingType": "simple",     // Optional: You can set the paging type (simple, full numbers, etc.)
        "dom": '<"top"i>rt<"bottom"flp>',  // Custom layout for table controls, "top" is for entries, "bottom" is for pagination
    });
});
</script>

<!-- JavaScript for Modal Logic -->
<script>
    const addItemBtn = document.getElementById('add-item-btn');
    const itemFormOverlay = document.getElementById('item-form-overlay');
    const cancelBtn = document.getElementById('cancel-btn');
    const form = document.getElementById('item-form');

    // Open the modal
    addItemBtn.addEventListener('click', function () {
        itemFormOverlay.classList.remove('hidden');
    });

    // Close the modal when clicking outside the form
    window.addEventListener('click', function (event) {
        if (event.target === itemFormOverlay) {
            itemFormOverlay.classList.add('hidden');
        }
    });

    // Cancel button logic
    cancelBtn.addEventListener('click', function () {
        form.reset(); // Reset the form fields
        itemFormOverlay.classList.add('hidden'); // Hide the overlay
    });
</script>

<!-- JavaScript for AJAX form submission -->
<script>
    // Submit the form via AJAX
    $('#item-form').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this); // Collect form data
        $.ajax({
            url: "{{ route('items.store') }}", // The route for saving the item
            method: "POST", // POST method
            data: formData, // Send the form data
            processData: false,
            contentType: false,
            success: function(response) {
                alert('Item added successfully!');
                $('#item-form-overlay').addClass('hidden'); // Hide the modal
                location.reload(); // Reload the page to show the new item
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Log the error
                alert('An error occurred while adding the item.');
            }
        });
    });
</script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
</body>
</html>
