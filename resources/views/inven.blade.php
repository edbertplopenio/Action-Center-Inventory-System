<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            margin-bottom: 1rem;
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
            overflow-x: auto;
            width: 100%;
            height: 550px;
            overflow-y: auto; /* Enable vertical scrolling if needed */
            margin-top: -1.5rem; /* Set to 0 or a smaller value to move the table up */
            position: relative;
        }

        /* Pagination styles */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            position: absolute; /* Positioning it at the bottom */
            bottom: -0.5px; /* Adjust distance from the bottom */
            width: 100%;
        }

        .pagination-btn {
            font-size: 0.75rem; /* Smaller font size */
            padding: 0.4rem 0.8rem; /* Smaller padding */
            border-radius: 0.25rem;
            cursor: pointer;
            background-color: #f7fafc;
            border: 1px solid #e5e5e5;
            color: #2d3748;
        }

        .pagination-btn:hover {
            background-color: #e2e8f0;
        }

        .pagination-btn:disabled {
            background-color: #edf2f7;
            cursor: not-allowed;
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
        <div id="equipment-content" class="tab-content active">
            <h3 class="text-xl font-semibold">DRRM Equipment</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-equipment" onclick="selectAllCheckboxes('equipment')"></th>
                            <th>Equipment Name</th>
                            <th>Category</th>
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
                                <td><input type="checkbox" class="select-item" name="item_ids[]" value="{{ $item->id }}"></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category }}</td>
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

                <!-- Pagination for Equipment -->
                <div class="pagination-container mt-4">
                    {{ $items->links() }} <!-- Pagination links for Equipment -->
                </div>
            </div>
        </div>

        <!-- Office Supplies Tab -->
        <div id="office-supplies-content" class="tab-content">
            <h3 class="text-xl font-semibold">Office Supplies</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-office-supplies" onclick="selectAllCheckboxes('office-supplies')"></th>
                            <th>Item Name</th>
                            <th>Category</th>
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
                                <td>{{ $item->category }}</td>
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

                <!-- Pagination for Office Supplies -->
                <div class="pagination-container mt-4">
                    {{ $officeSupplies->links() }} <!-- Pagination links for Office Supplies -->
                </div>
            </div>
        </div>

        <!-- Emergency Kits Tab -->
        <div id="emergency-kits-content" class="tab-content">
            <h3 class="text-xl font-semibold">Emergency Kits</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-emergency-kits" onclick="selectAllCheckboxes('emergency-kits')"></th>
                            <th>Item Name</th>
                            <th>Category</th>
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
                                <td><input type="checkbox" class="select-item" name="item_ids[]" value="{{ $item->id }}"></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category }}</td>
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

                <!-- Pagination for Emergency Kits -->
                <div class="pagination-container mt-4">
                    {{ $emergencyKits->links() }} <!-- Pagination links for Emergency Kits -->
                </div>
            </div>
        </div>

        <!-- Archives Tab -->
<div id="archives-content" class="tab-content">
    <h3 class="text-xl font-semibold">Archives</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all-archives" onclick="selectAllCheckboxes('archives')"></th>
                    <th>Item Name</th>
                    <th>Category</th>
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
                <!-- Example archived item -->
                <tr>
                    <td><input type="checkbox" class="select-item" name="item_ids[]" value="1"></td>
                    <td>Archived Item 1</td>
                    <td>Category 1</td>
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

        <!-- Pagination for Archives (if needed) -->
        <div class="pagination-container mt-4">
            <!-- Pagination links for Archives -->
        </div>
    </div>
</div>

    </div>
</div>

<!-- JavaScript for Tab Switching -->
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
    
    // Force reflow (this forces the browser to recalculate layout and refresh content if necessary)
    activeTabContent.offsetHeight; // Accessing offsetHeight forces a reflow
}


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

</body>
</html>
