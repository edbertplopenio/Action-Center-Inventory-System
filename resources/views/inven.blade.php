<!DOCTYPE html>
<html lang="en">
<head>
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
            border-radius: 0.5rem;
            color: white;
            font-weight: 500;
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
            background-color: #FF9F00; /* Orange */
        }

        .emergency-kits-tab {
            background-color: #E94E77; /* Red */
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }

        table th, table td {
            font-size: 12px; /* Smaller font size */
            padding: 0.6rem; /* Reduced padding for tighter spacing */
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #E5E5E5;
        }

        table th {
            font-size: 12px; /* Smaller font size */
            padding: 0.6rem; /* Reduced padding for tighter spacing */
            background-color: #F7FAFC;
            color: #2D3748;
        }

        table tr:hover {
            background-color: #F1F1F1;
        }

        .table-container {
            overflow-x: auto;
            width: 100%;
            height : 500px;
            overflow-y: auto; /* Enable vertical scrolling if needed */
            margin-top: 1rem; /* Add margin top to separate the content */
        }

        /* Styling for the Action Buttons */
        .edit-btn, .delete-btn {
            padding: 0.3rem 0.6rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .edit-btn:hover {
            background-color: #45A049;
        }

        .delete-btn {
            background-color: #F44336;
            color: white;
        }

        .delete-btn:hover {
            background-color: #F41F29;
        }

        /* Pagination styles */
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            position: absolute;
            bottom: 20px; /* Adjust the distance from the bottom */
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            padding-top: 1rem;
        }


        .pagination-btn {
            font-size: 12px;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            background-color: #f7fafc;
            border: 1px solid #e5e5e5;
            color: #2d3748;
            font-weight: 500;
            transition: background-color 0.3s;
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

.edit-btn, .delete-btn {
    font-size: 12px;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 14px;
    text-align: center;
    cursor: pointer;
    width: 60px; /* Fixed width para pareho ang laki */
}

.edit-btn {
    font-size: 12px;
    background-color: #4CAF50;
    color: white;
}

.edit-btn:hover {
    background-color: #45A049;
}

.delete-btn {
    background-color: #F44336;
    color: white;
}

.delete-btn:hover {
    background-color: #D32F2F;
}



    </style>
</head>
<body class="bg-gray-100">

<!-- Main Content -->

<!-- Modal Overlay for Adding Item -->
<div id="add-item-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h3 class="text-xl font-semibold mb-4">Add New Item</h3>
        <form action="/add-item" method="POST">
            <!-- Include your fields for item form (adjust as per your `item-form.blade.php`) -->
            <label for="item-name">Item Name:</label>
            <input type="text" id="item-name" name="item_name" class="mb-4 p-2 border rounded w-full">

            <label for="item-description">Description:</label>
            <textarea id="item-description" name="description" class="mb-4 p-2 border rounded w-full"></textarea>

            <!-- Add more fields as needed -->

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">Save Item</button>
            <button type="button" id="close-modal-btn" class="ml-2 bg-red-600 text-white px-4 py-2 rounded-md">Cancel</button>
        </form>
    </div>
</div>

<div class="flex-1 p-6 relative">
    <div class="bg-white shadow-md rounded-lg p-6"> <!-- Reduced padding for better layout -->
        <!-- Tabs -->
        <div class="tab-container">
            <div class="tab-button-container">
                <button id="equipment-tab" class="tab-button equipment-tab" onclick="switchTab('equipment')">Equipment</button>
                <button id="office-supplies-tab" class="tab-button office-supplies-tab ml-2" onclick="switchTab('office-supplies')">Office Supplies</button>
                <button id="emergency-kits-tab" class="tab-button emergency-kits-tab ml-2" onclick="switchTab('emergency-kits')">Emergency Kits</button>
            </div>
            <!-- Add Item Button (Right Aligned) -->
            <button class="px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none" id="add-item-btn">
                + Add Item
            </button>
        </div>

        <!-- Tab Content (Tables for Equipment, Office Supplies, and Emergency Kits) -->
        <div id="equipment-content" class="tab-content active">
            <h3 class="text-xl font-semibold">Equipment</h3>
            <div class="table-container">
                <table>
                    <!-- After closing the <table> tag, add this pagination section -->
                    

                    <thead>
                        <tr>
                            <th>ID</th>
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
                                <td>{{ $item->id }}</td>
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
                                        <button class="delete-btn">Delete</button>
                                    </td>
                                        </tr>
                                    @endforeach
                    </tbody>
                </table>

            </div>
            </div>
        </div>

        <div id="office-supplies-content" class="tab-content">
            <h3 class="text-xl font-semibold">Office Supplies</h3>
            <div class="table-container">
                <table>
                    <!-- After closing the <table> tag, add this pagination section -->

                    <thead>
                        <tr>
                            <th>ID</th>
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
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
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
                                        <button class="delete-btn">Delete</button>
                                    </td>
                                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        <div id="emergency-kits-content" class="tab-content">
            <h3 class="text-xl font-semibold">Emergency Kits</h3>
            <div class="table-container">
                <table>
                    <!-- After closing the <table> tag, add this pagination section -->

                    <thead>
                        <tr>
                            <th>ID</th>
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
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
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
                                        <button class="delete-btn">Delete</button>
                                    </td>
                                        </tr>
                                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="pagination-container">
    <button class="pagination-btn">Previous</button>
    <button class="pagination-btn">1</button>
    <button class="pagination-btn">2</button>
    <button class="pagination-btn">3</button>
    <button class="pagination-btn">Next</button>
</div>

<!-- JavaScript for Tab Switching -->
<script>
    function switchTab(tab) {
        // Hide all tab content
        var tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(function (tabContent) {
            tabContent.classList.remove('active');
        });

        // Show the selected tab's content
        document.getElementById(tab + '-content').classList.add('active');

        // Change tab button styles
        document.querySelectorAll('.tab-button').forEach(function (btn) {
            btn.classList.remove('active');
        });

        // Set active class and background color for the clicked tab
        document.getElementById(tab + '-tab').classList.add('active');
    }
</script>

<!-- JavaScript for Modal Logic -->
<script>
    // Get references to the modal and buttons
    const addItemBtn = document.getElementById('add-item-btn');
    const addItemModal = document.getElementById('add-item-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');

    // Show the modal when the Add Item button is clicked
    addItemBtn.addEventListener('click', function() {
        addItemModal.classList.remove('hidden');
    });

    // Hide the modal when the Cancel button is clicked
    closeModalBtn.addEventListener('click', function() {
        addItemModal.classList.add('hidden');
    });

    // Optionally, hide the modal if the user clicks anywhere outside of it
    window.addEventListener('click', function(event) {
        if (event.target === addItemModal) {
            addItemModal.classList.add('hidden');
        }
    });
</script>

</body>
</html>
