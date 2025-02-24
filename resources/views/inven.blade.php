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
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #E5E5E5;
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

        <!-- Tab Content (Tables for Equipment, Office Supplies, and Emergency Kits) -->
        <div id="equipment-content" class="tab-content active">
            <h3 class="text-xl font-semibold">Equipment</h3>
            <div class="table-container">
                <table>
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
                        <!-- Original Data -->
                        <tr>
                            <td>1</td>
                            <td>Laptop</td>
                            <td>Electronics</td>
                            <td>5</td>
                            <td>Unit</td>
                            <td>Dell XPS 13</td>
                            <td>Storage A</td>
                            <td>2025-02-19</td>
                            <td>2025-01-15</td>
                            <td>Available</td>
                            <td><img src="image.jpg" alt="Laptop Image" class="w-10 h-10"></td>
                            <td>
                                <button class="edit-btn">Edit</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>

        <div id="office-supplies-content" class="tab-content">
            <h3 class="text-xl font-semibold">Office Supplies</h3>
            <div class="table-container">
                <table>
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
                        <!-- Example Data for Office Supplies -->
                        <tr>
                            <td>1</td>
                            <td>Whiteboard</td>
                            <td>Stationery</td>
                            <td>10</td>
                            <td>Unit</td>
                            <td>Magnetic Whiteboard</td>
                            <td>Storage B</td>
                            <td>2025-02-20</td>
                            <td>2025-01-10</td>
                            <td>Available</td>
                            <td><img src="whiteboard.jpg" alt="Whiteboard" class="w-10 h-10"></td>
                            <td>
                                <button class="edit-btn">Edit</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>

        <div id="emergency-kits-content" class="tab-content">
            <h3 class="text-xl font-semibold">Emergency Kits</h3>
            <div class="table-container">
                <table>
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
                        <!-- Example Data for Emergency Kits -->
                        <tr>
                            <td>1</td>
                            <td>First Aid Kit</td>
                            <td>Medical</td>
                            <td>5</td>
                            <td>Unit</td>
                            <td>Basic First Aid Kit</td>
                            <td>Storage C</td>
                            <td>2025-02-18</td>
                            <td>2025-01-12</td>
                            <td>Available</td>
                            <td><img src="first-aid.jpg" alt="First Aid Kit" class="w-10 h-10"></td>
                            <td>
                                <button class="edit-btn">Edit</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
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
</script>

</body>
</html>
