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

        .edit-btn, .delete-btn {
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

       <!-- Equipment Tab -->
<div id="equipment-content" class="tab-content active">
    <h3 class="text-xl font-semibold">Equipment</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all-equipment" onclick="selectAllCheckboxes('equipment')"></th> <!-- Select All Checkbox -->
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
                        <td><input type="checkbox" class="select-item" name="item_ids[]" value="{{ $item->id }}"></td> <!-- Individual Checkbox -->
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

        <!-- Pagination for Equipment -->
        <div class="pagination-container mt-4">
            <button class="pagination-btn">Previous</button>
            <button class="pagination-btn">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">Next</button>
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
                    <th><input type="checkbox" id="select-all-office-supplies" onclick="selectAllCheckboxes('office-supplies')"></th> <!-- Select All Checkbox -->
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
                        <td><input type="checkbox" class="select-item" name="item_ids[]" value="{{ $item->id }}"></td> <!-- Individual Checkbox -->
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

        <!-- Pagination for Office Supplies -->
        <div class="pagination-container mt-4">
            <button class="pagination-btn">Previous</button>
            <button class="pagination-btn">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">Next</button>
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
                    <th><input type="checkbox" id="select-all-emergency-kits" onclick="selectAllCheckboxes('emergency-kits')"></th> <!-- Select All Checkbox -->
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
                        <td><input type="checkbox" class="select-item" name="item_ids[]" value="{{ $item->id }}"></td> <!-- Individual Checkbox -->
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

                <!-- Pagination for Emergency Kits -->
                <div class="pagination-container mt-4">
                    <button class="pagination-btn">Previous</button>
                    <button class="pagination-btn">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <button class="pagination-btn">Next</button>
                </div>
            </div>
        </div>
    </div>
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

    function selectAllCheckboxes(tab) {
    // Get the 'Select All' checkbox for the specific tab
    const selectAllCheckbox = document.getElementById(`select-all-${tab}`);
    
    // Get all the individual checkboxes within the specific tab content
    const checkboxes = document.querySelectorAll(`#${tab}-content .select-item`);
    
    // Loop through each checkbox and set the checked state based on the 'Select All' checkbox
    checkboxes.forEach(function (checkbox) {
        checkbox.checked = selectAllCheckbox.checked;
    });
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
