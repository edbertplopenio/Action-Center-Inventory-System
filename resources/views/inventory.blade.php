<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            height: 100%;
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
            background-color:rgb(21, 183, 75); /* Green */
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
            background-color: #4cc9f0;
            color: white;
            transition: background-color 0.3s, transform 0.2s
        }

        .edit-btn:hover {
            background-color:rgb(65, 175, 209);
        }

        .archive-btn {
            display: flex;  /* Enable flexbox */
            justify-content: center;  /* Center horizontally */
            align-items: center;  /* Center vertically */
            padding: 6px 12px;  /* Adjust padding to control the button size */
            border-radius: 4px;
            font-size: 14px;
            background-color: rgb(255, 176, 48);
            color: white;
            text-align: center;  /* Ensure the text is centered */
            cursor: pointer;
            width: auto;  /* Optional: Adjust the button's width */
            transition: background-color 0.3s, transform 0.2s
        }

        .archive-btn:hover {
            background-color:rgb(234, 71, 71);  /* Hover effect */
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
        background-color: rgb(21, 183, 75);  /* Purple */
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
        background-color: rgb(81, 166, 109);  /* Darker shade of purple for hover effect */
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
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10"></td>
                        <td class="action-buttons">
                            <button onclick="openEditModal({{ $item->id }})" class="edit-btn"> 
                                Edit
                            </button>
                            <!-- Archive Button: AJAX for archiving -->
                            <button type="button" class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- DRRM Equipment Tab -->
<div id="equipment-content" class="tab-content">
    <h3 class="text-xl font-semibold mb-4">DRRM Equipment</h3>
    <div class="table-container">
        <table id="equipmentTable" class="display">
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
                @foreach($drrmItems as $item)
                    <tr id="item-{{ $item->id }}">
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10"></td>
                        <td class="action-buttons">
                            <button onclick="openEditModal({{ $item->id }})" class="edit-btn"> 
                                Edit
                            </button>
                            <!-- Archive Button: AJAX for archiving -->
                            <button type="button" class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Office Supplies Tab -->
<div id="office-supplies-content" class="tab-content">
    <h3 class="text-xl font-semibold mb-4">Office Supplies</h3>
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
                @foreach($officeItems as $item)
                    <tr id="item-{{ $item->id }}">
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10"></td>
                        <td class="action-buttons">
                            <button onclick="openEditModal({{ $item->id }})" class="edit-btn"> 
                                Edit
                            </button>
                            <!-- Archive Button: AJAX for archiving -->
                            <button type="button" class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Emergency Kits Tab -->
<div id="emergency-kits-content" class="tab-content">
    <h3 class="text-xl font-semibold mb-4">Emergency Kits</h3>
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
                @foreach($emergencyItems as $item)
                    <tr id="item-{{ $item->id }}">
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10"></td>
                        <td class="action-buttons">
                            <button onclick="openEditModal({{ $item->id }})" class="edit-btn"> 
                                Edit
                            </button>
                            <!-- Archive Button: AJAX for archiving -->
                            <button type="button" class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
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
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-10 h-10"></td>
                        <td class="action-buttons">
                            <button onclick="openEditModal({{ $item->id }})" class="edit-btn"> 
                                Edit
                            </button>
                            <!-- Archive Button: AJAX for archiving -->
                            <button type="button" class="archive-btn" onclick="archiveItem({{ $item->id }})">Archive</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Archives Tab -->
<div id="archives-content" class="tab-content">
    <h3 class="text-xl font-semibold mb-4">Archives</h3>
    <div class="table-container">
        <table id="archivesTable" class="display">
            <thead>
                <tr>
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
                @foreach($archivedItems as $item)
                    <tr id="archived-{{ $item->id }}">
                        <td>{{ $item->item_name }}</td>
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
                            <!-- Restore Button: Form for restoring an archived item -->
                            <form action="{{ route('restore.item', $item->id) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="restore-btn">Restore</button>
                            </form>
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
<!-- Add item JavaScript for Modal Control -->
<script>
    $(document).ready(function () {
        // Event listener for Add Item button
        $("#add-item-btn").click(function () {
            $("#addItemModal").removeClass("hidden");
        });

        // Close modal actions
        $("#closeModal, #cancelModal").click(function () {
            $("#addItemModal").addClass("hidden");
        });
    });
</script>

<SCRIPT>
    //ARCHIVES
    function archiveItem(itemId) {
    $.ajax({
        url: '/archive-item/' + itemId,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            alert('Item archived successfully.');
            $('#item-' + itemId).remove(); // Remove the item row from the table
        },
        error: function(xhr) {
            alert('Error archiving item.');
        }
    });
}

function restoreItem(itemId) {
    $.ajax({
        url: '/restore-item/' + itemId,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            alert('Item restored successfully.');
            location.reload(); // Reload the page to update the table
        },
        error: function(xhr) {
            alert('Error restoring item.');
        }
    });
}

</script>

<script>
// Open the Edit Modal and populate fields with item data
function openEditModal(itemId) {
    $.ajax({
        url: '/get-item/' + itemId, // Fetch item data for the given itemId
        method: 'GET',
        success: function(item) {
            // Populate the form fields with the item data
            $('#edit_item_id').val(item.id);
            $('#edit_item_name').val(item.item_name);
            $('#edit_category').val(item.category);
            $('#edit_quantity').val(item.quantity);
            $('#edit_unit').val(item.unit);
            $('#edit_description').val(item.description);
            $('#edit_storage_location').val(item.storage_location);
            $('#edit_arrival_date').val(item.arrival_date);
            $('#edit_date_purchased').val(item.date_purchased);
            $('#edit_status').val(item.status);

            // Dynamically set the form's action URL to include the itemId
            var formAction = "{{ route('items.update', ['id' => '__ID__']) }}".replace('__ID__', item.id);
            $('#editItemForm').attr('action', formAction); // Set the action URL for form

            // Show the modal
            $('#editItemModal').removeClass('hidden');
        },
        error: function(xhr) {
            alert('Error fetching item data.');
        }
    });
}

// Save the updated item data when the form is submitted
$('#editItemForm').submit(function(e) {
    e.preventDefault();  // Prevent default form submission
    
    // Send the form data using AJAX
    $.ajax({
        url: $(this).attr('action'),  // Get the form's action URL
        method: 'POST',  // Use 'POST' for the AJAX request
        data: $(this).serialize(),   // Serialize the form data
        success: function(response) {
            alert('Item updated successfully!');
            $('#editItemModal').addClass('hidden');
            location.reload();  // Refresh the page to show the updated data
        },
        error: function(xhr) {
            alert('Error updating item.');
        }
    });
});

$(document).ready(function () {
    // Close the Edit Item Modal when clicking the "Cancel" button or the "Close" button (×)
    $("#cancelEditModal, #closeEditModal").click(function () {
        $("#editItemModal").addClass("hidden");  // Hide the modal
    });
});
</script>

<!-- Modal Overlay for Adding Item -->
<div id="addItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg w-2/3 max-w-4xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Add New Item</h3>
            <button id="closeModal" class="text-black hover:text-red-500 text-2xl">&times;</button>
        </div>
        <form id="itemForm" action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="item_name" class="block text-sm font-semibold text-black mb-2">Item Name</label>
                    <input type="text" id="item_name" name="item_name" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                </div>

                <div>
                    <label for="category" class="block text-sm font-semibold text-black mb-2">Category</label>
                    <select id="category" name="category" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                        <option value="DRRM Equipment">DRRM Equipment</option>
                        <option value="Office Supplies">Office Supplies</option>
                        <option value="Emergency Kits">Emergency Kits</option>
                        <option value="Other Items">Other Items</option>
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-semibold text-black mb-2">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                </div>

                <div>
                    <label for="unit" class="block text-sm font-semibold text-black mb-2">Unit</label>
                    <input type="text" id="unit" name="unit" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-black mb-2">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500"></textarea>
                </div>

                <div>
                    <label for="storage_location" class="block text-sm font-semibold text-black mb-2">Storage Location</label>
                    <input type="text" id="storage_location" name="storage_location" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                </div>

                <div>
                    <label for="arrival_date" class="block text-sm font-semibold text-black mb-2">Arrival Date</label>
                    <input type="date" id="arrival_date" name="arrival_date" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                </div>

                <div>
                    <label for="date_purchased" class="block text-sm font-semibold text-black mb-2">Date Purchased</label>
                    <input type="date" id="date_purchased" name="date_purchased" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-black mb-2">Status</label>
                    <select id="status" name="status" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                    </select>
                </div>

                <div>
                    <label for="image" class="block text-sm font-semibold text-black mb-2">Image</label>
                    <input type="file" id="image" name="image" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500">
                </div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" id="cancelModal" class="px-4 py-2 bg-gray-400 text-black rounded-md transition duration-300 hover:bg-gray-600 hover:text-white">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-green-400 text-black rounded-md transition duration-300 hover:bg-green-600 hover:text-white">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>



<!--EDIT MODAL-->
<!-- Edit Item Modal -->
<div id="editItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg w-2/3 max-w-4xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Edit Item</h3>
            <button id="closeEditModal" class="text-black hover:text-red-500 text-2xl">&times;</button>
        </div>
        <form id="editItemForm" action="{{ route('items.update', ['id' => '__ID__']) }}" method="POST">
            @csrf
            @method('PUT')  <!-- Use PUT method for updates -->
            <input type="hidden" id="edit_item_id" name="item_id">
            <div class="grid grid-cols-2 gap-4">
                <!-- Add editable fields here -->

                <div>
                    <label for="edit_item_name" class="block text-sm font-semibold text-black mb-2">Item Name</label>
                    <input type="text" id="edit_item_name" name="item_name" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                </div>

                <div>
                    <label for="edit_category" class="block text-sm font-semibold text-black mb-2">Category</label>
                    <select id="edit_category" name="category" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500">
                        <option value="DRRM Equipment">DRRM Equipment</option>
                        <option value="Office Supplies">Office Supplies</option>
                        <option value="Emergency Kits">Emergency Kits</option>
                        <option value="Other Items">Other Items</option>
                    </select>
                </div>

                <div>
                    <label for="edit_quantity" class="block text-sm font-semibold text-black mb-2">Quantity</label>
                    <input type="number" id="edit_quantity" name="quantity" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500" required>
                </div>

                <div>
                    <label for="edit_unit" class="block text-sm font-semibold text-black mb-2">Unit</label>
                    <input type="text" id="edit_unit" name="unit" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="edit_description" class="block text-sm font-semibold text-black mb-2">Description</label>
                    <textarea id="edit_description" name="description" rows="3" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500"></textarea>
                </div>

                <div>
                    <label for="edit_storage_location" class="block text-sm font-semibold text-black mb-2">Storage Location</label>
                    <input type="text" id="edit_storage_location" name="storage_location" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="edit_arrival_date" class="block text-sm font-semibold text-black mb-2">Arrival Date</label>
                    <input type="date" id="edit_arrival_date" name="arrival_date" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="edit_date_purchased" class="block text-sm font-semibold text-black mb-2">Date Purchased</label>
                    <input type="date" id="edit_date_purchased" name="date_purchased" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500">
                </div>

                <div>
                    <label for="edit_status" class="block text-sm font-semibold text-black mb-2">Status</label>
                    <select id="edit_status" name="status" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500">
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                    </select>
                </div>

                <div>
                    <label for="edit_image" class="block text-sm font-semibold text-black mb-2">Image</label>
                    <input type="file" id="edit_image" name="image" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-red-500">
                </div>
            </div>

            <div class="flex justify-between mt-4">
                <button type="button" id="cancelEditModal" class="px-4 py-2 bg-gray-400 text-black rounded-md transition duration-300 hover:bg-gray-600 hover:text-white">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-green-400 text-black rounded-md transition duration-300 hover:bg-green-600 hover:text-white">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>