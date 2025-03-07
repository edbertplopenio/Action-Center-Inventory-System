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
            border: none; /* Remove default button border */
            border-radius: 0.375rem; /* Consistent border radius */
        }
        .tab-button:hover {
            opacity: 0.8;
        }

        .tab-button.active {
            font-weight: bold;
            background-color: #4A90E2; /* Consistent background color for active tab */
        }

        /* Flex container for Tabs and Add Item Button */
        .tab-container {
            display: flex;
            align-items: center;
            margin-bottom: -0.2rem;
            margin-top: -1rem;
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
            background-color: rgb(255 102 102); /* Blue */
        }

        .office-supplies-tab {
            background-color: #ff4242; /* Orange */
        }

        .emergency-kits-tab {
            background-color: #ff1e1e; /* Red */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            margin-bottom: -2rem;
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
            width: 100%; /* Ensure it takes full width */
            height: auto; /* Fixed height for vertical scrolling */
            overflow-x: auto; /* Enable horizontal scrolling only */
            overflow-y: hidden; /* Prevent vertical scrollbar in outer container */
            margin-top: -1.5rem; /* Adjust margin for spacing */  
            margin-bottom: -1.7rem;  
            
        }
        /* Styling for the Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px; /* Para may spacing between buttons */
            min-width: 120px; /* Fixed width para di gagalaw */
        }

        .edit-btn, .archive-btn, .restore-btn {
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
            background-color: #d60000; /* Blue color for the Archives tab */
        }

        .restore-btn {
        background-color: rgb(135, 60, 255);  /* Purple */
        color: white;
        border-radius: 4px;
        font-size: 14px;
        padding: 6px 12px;  /* Same padding as the other buttons */
        width: auto;
        cursor: pointer;
        text-align: center;
        margin-bottom: 5px;
        margin-top: 2px;
        transition: background-color 0.3s, transform 0.2s; /* Added transition for smooth hover effect */
    }

    .restore-btn:hover {
        background-color: rgb(100, 45, 200);  /* Darker shade of purple for hover effect */
        transform: scale(1.05);  /* Slight scaling effect on hover for better interactivity */
    }

    #myTable {
        width: 100%;
        overflow-x: auto;  /* Enable horizontal scrolling */
        overflow-y: auto;  /* Enable vertical scrolling */
    }

    .all-items-tab {
        background-color: #ff8989; /* Gray */
    }

    .other-items-tab {
        background-color: #F90000; /* Yellow */
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
                    <option value="Emergency Kits">Other Item</option>
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
                <button id="all-items-tab" class="tab-button all-items-tab ml-2" onclick="switchTab('all-items')">All Items</button>
                <button id="equipment-tab" class="tab-button equipment-tab" onclick="switchTab('equipment')">DRRM Equipment</button>
                <button id="office-supplies-tab" class="tab-button office-supplies-tab ml-2" onclick="switchTab('office-supplies')">Office Supplies</button>
                <button id="emergency-kits-tab" class="tab-button emergency-kits-tab ml-2" onclick="switchTab('emergency-kits')">Emergency Kits</button>
                <button id="other-items-tab" class="tab-button other-items-tab ml-2" onclick="switchTab('other-items')">Other Items</button>
                <button id="archives-tab" class="tab-button archives-tab ml-2" onclick="switchTab('archives')">Archives</button>
            </div>
            <!-- Add Item Button (Right Aligned) -->
            <button id="add-item-btn" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                + Add Item
            </button>
        </div>

                <!-- All Items Tab -->
        <div id="all-items-content" class="tab-content active">
            <h3 class="text-xl font-semibold mb-4">All Items</h3>
            <div class="table-container">
                <table id="allItemsTable" class="display">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Category</th>
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
                        @foreach($allItems as $item)
                            <tr id="item-{{ $item->id }}">
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->category }}</td> <!-- Corrected category retrieval -->
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->storage_location }}</td>
                                <td>{{ $item->arrival_date }}</td>
                                <td>{{ $item->date_purchased }}</td>
                                <td>{{ $item->status }}</td>
                                <td><img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10"></td>
                                <td class="action-buttons">
                                    <button class="edit-btn">Edit</button>
                                    <button class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Equipment Tab -->
        <div id="equipment-content" class="tab-content">
            <h3 class="text-xl font-semibold mb-4">DRRM Equipment</h3>
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
                            <tr id="item-{{ $item->id }}">
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
                                    <button class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Office Supplies Tab -->
        <div id="office-supplies-content" class="tab-content">
            <h3 class="text-xl font-semibold" style="margin-bottom: 16px;">Office Supplies</h3>
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
                            <tr id="item-{{ $item->id }}">
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
                                    <button class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Emergency Kits Tab -->
        <div id="emergency-kits-content" class="tab-content">
            <h3 class="text-xl font-semibold" style="margin-bottom: 16px;">Emergency Kits</h3>
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
                            <tr id="item-{{ $item->id }}">
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
                                    <button class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

                <!-- Other Items Tab -->
        <div id="other-items-content" class="tab-content">
            <h3 class="text-xl font-semibold mb-4">Other Items</h3>
            <div class="table-container">
                <table id="otherItemsTable" class="display">
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
                        @foreach($otherItems as $item)
                            <tr id="item-{{ $item->id }}">
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
                                    <button class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Archives Tab -->
        <div id="archives-content" class="tab-content">
            <h3 class="text-xl font-semibold" style="margin-bottom: 16px;">Archives</h3>
            <div class="table-container">
                <table id="archivesTable" class="display">
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
                        @foreach($archivedItems as $item)
                            <tr id="archived-{{ $item->id }}">
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
                                    <button class="restore-btn" onclick="restoreItem({{ $item->id }})">Restore</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<script>
// Archive an item
function archiveItem(itemId) {
    $.ajax({
        url: '/archive-item/' + itemId,  // Your route to archive an item
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            // Remove the item from the current inventory list
            const itemRow = document.getElementById('item-' + itemId);
            itemRow.remove();

            // Add the item to the archived table
            const archiveTable = document.getElementById('archivesContent').getElementsByTagName('tbody')[0];
            const newRow = archiveTable.insertRow();
            newRow.id = 'archived-' + itemId;
            newRow.innerHTML = `
                <td>${itemRow.querySelector('.item-name').textContent}</td>
                <td>
                    <button class="restore-btn" onclick="restoreItem('${itemId}')">Restore</button>
                </td>
            `;
        }
    });
}

// Restore an item
function restoreItem(itemId) {
    $.ajax({
        url: '/restore-item/' + itemId,  // Your route to restore an item
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            // Remove the item from the archived list
            const archivedRow = document.getElementById('archived-' + itemId);
            archivedRow.remove();

            // Add the item back to the main inventory list
            const inventoryTable = document.getElementById('equipment-content').getElementsByTagName('tbody')[0];
            const newRow = inventoryTable.insertRow();
            newRow.id = 'item-' + itemId;
            newRow.innerHTML = `
                <td>${archivedRow.querySelector('.item-name').textContent}</td>
                <td>
                    <button class="archive-btn" onclick="archiveItem('${itemId}')">Archive</button>
                </td>
            `;
        }
    });
}


    function switchTab(tab) {
        console.log("Switching to tab: ", tab);  // For debugging

        // Hide all tabs and remove 'active' class
        var tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(tabContent => {
            tabContent.classList.remove('active');
            tabContent.style.display = 'none';
        });

        // Show the selected tab and add 'active' class
        var activeTabContent = document.getElementById(tab + '-content');
        if (activeTabContent) {
            activeTabContent.classList.add('active');
            activeTabContent.style.display = 'block';
        }

        // Remove 'active' class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));

        // Add 'active' class to the clicked tab button
        var activeTabButton = document.getElementById(tab + '-tab');
        if (activeTabButton) {
            activeTabButton.classList.add('active');
        }
    }


    // Ensure DataTables is initialized when the page loads
    $(document).ready(function () {
        initializeDataTables();
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

<script>
    $(document).ready(function() {
        $('.tab-button').click(function() {
            var targetTab = $(this).data('target');  // data-target is an attribute set to target tab
            $('.tab-content').removeClass('active');
            $('#' + targetTab).addClass('active');
        });
    });
</script>


<script>
        function initializeDataTables() {

        $('#allItemsTable').DataTable({
            "scrollY": '425px',
            "scrollCollapse": true,
            "paging": true,
            "searching": true,
            "ordering": true,
        });
        
        $('#equipmentTable').DataTable({
            "scrollY": '425px', // Set vertical scroll inside the table
            "scrollCollapse": true, // Enable collapsing the table when data is small
            "paging": true, // Enable pagination
            "searching": true, // Enable search
            "ordering": true, // Enable sorting
        });

        $('#officeSuppliesTable').DataTable({
            "scrollY": '425px', // Set vertical scroll inside the table
            "scrollCollapse": true, // Enable collapsing the table when data is small
            "paging": true, // Enable pagination
            "searching": true, // Enable search
            "ordering": true, // Enable sorting
        });

        $('#emergencyKitsTable').DataTable({
            "scrollY": '425px', // Set vertical scroll inside the table
            "scrollCollapse": true, // Enable collapsing the table when data is small
            "paging": true, // Enable pagination
            "searching": true, // Enable search
            "ordering": true, // Enable sorting
        });

        $('#otherItemsTable').DataTable({
            "scrollY": '425px',
            "scrollCollapse": true,
            "paging": true,
            "searching": true,
            "ordering": true,
        });

        $('#archivesTable').DataTable({
            "scrollY": '425px', // Set vertical scroll inside the table
            "scrollCollapse": true, // Enable collapsing the table when data is small
            "paging": true, // Enable pagination
            "searching": true, // Enable search
            "ordering": true, // Enable sorting
        });
    }
    
</script>

</body>
</html>
