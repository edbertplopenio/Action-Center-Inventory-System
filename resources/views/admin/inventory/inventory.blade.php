
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/phosphor-icons@1.4.2/dist/phosphor-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

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
            padding: 0.3rem 1rem; /* Reduced padding */
            font-size: 0.8rem; /* Reduced font size */
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
            background-color: #4A90E2; /* Active tab background color */
        }

        /* Flex container for Tabs and Add Item Button */
        .tab-container {
            display: flex;
            align-items: center;
            margin-bottom: -0.5rem; /* Slightly smaller margin */
            margin-top: .5rem;
        }
                .tab-button-container {
            display: flex;
        }

        .tab-button + .tab-button {
            margin-left: 0.4rem; /* Reduced margin between tabs */
        }

    
        #add-item-btn {
            font-size: 0.9rem; /* Slightly smaller font */
            margin-left: auto; /* Push the button to the far right */
            background-color: #4cc9f0;; /* Green */
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 60px 60px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #add-item-btn:hover {
            background-color: #3fb3d1; /* Darker green for hover effect */
            opacity: 0.8; /* Slight opacity change on hover */
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
            padding: 12px; /* Match the padding from the second code */
            text-align: center; /* Center align text */
            border-bottom: 1px solid #E5E5E5;
            font-size: 12px; /* Match the font size from the second code */
        }
        table th {
        background-color: #EBF8FD; /* Match header background color */
        color: #4a5568; /* Match header text color */
        font-weight: 600; /* Match header font weight */
    }

/* Hover effect on table headers */
table th:hover {
        background-color: #f0f0f0; /* Light grey background color on hover */
        color: #2D3748; /* Dark text color on hover */
        cursor: pointer; /* Pointer cursor to indicate interactivity */
    }
    /* Add hover effect for rows */
    table tr:hover {
        background-color: #b3eaff; /* Match hover effect from the second code */
    }


        .table-container {
            width: 100%; /* Ensure it takes full width */
            height: auto; /* Fixed height for vertical scrolling */
            overflow-x: auto; /* Enable horizontal scrolling only */
            overflow-y: hidden; /* Prevent vertical scrollbar in outer container */
            margin-top: 0.3rem; /* Adjust margin for spacing */  
            margin-bottom: -1.7rem;  
            
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

    table th:nth-child(11), table td:nth-child(11) {
    width: 180px !important;  /* Set a fixed width for the action column */
    padding: 0.6rem;  /* Ensure padding is consistent */
    }
    table td .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    /* Styling for the Action Buttons */
    .action-buttons {
    position: relative;
    display: flex; /* Changes the layout to flex */
    justify-content: center; /* Center buttons */
    align-items: center; /* Vertically center buttons */
}

.button-container {
    display: flex;
    flex-direction: column; /* Arrange buttons in a column */
    gap: 5px; /* Space between buttons */
}

.edit-btn, .archive-btn {
    border-radius: 5px; /* Slightly rounded corners */
    padding: 6px 10px; /* Increased padding for better touch */
    font-size: 12px; /* Consistent font size */
    transition: background-color 0.3s, transform 0.2s; /* Transition effects */
}

.edit-btn {
    top: -10; /* Position the Edit button at the top */
    background-color: #4cc9f0; /* Edit button color */
    color: white;

}

.edit-btn:hover {
    background-color: #36a9c1; /* Darker shade on hover */
    transform: scale(1.05); /* Slight scaling effect */
}

.archive-btn {
    top: 40px; /* Position the Archive button below the Edit button */
    background-color: #57cc99; /* Archive button color */
    color: white;
    margin-bottom: 20px;
}

.archive-btn:hover {
    background-color: #57cc99; /* Darker shade on hover */
    transform: scale(1.05); /* Slight scaling effect */
}

/* Change font size for table headers */
table.dataTable thead th {
    font-size: 11px;  /* Adjust the font size for the headers */
    text-align: center; 
}

/* Change font size for table cells */
table.dataTable tbody td {
    font-size: 14px;  /* Adjust the font size for table data cells */
    text-align: center; 
}

/**/ 
/**/
/* Style the container */
 /* Entries per page Dropdown */
 .dataTables_length {
        display: flex;
        align-items: center;
        gap: 4px; /* Smaller gap */
        font-family: 'Inter', sans-serif;
        font-size: 10px; /* Smaller font size */
        margin-bottom: 6px;
        padding: 2px 4px;
        background-color: #e6f7ff;
        border-radius: 6px;
        border: 1px solid #b3eaff;
    }

    .dataTables_length select {
        padding: 4px 8px;
        border: 1px solid #b3eaff;
        border-radius: 4px;
        background-color: #ffffff;
        color: #4aaed4;
        font-size: 10px;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease-in-out;
        width: 50px; /* Reduced width */
    }

    /* Adjust Search Box */
    .dataTables_filter input {
        padding: 4px 8px;
        border: 1px solid #b3eaff;
        border-radius: 4px;
        background-color: #ffffff;
        color: #4aaed4;
        font-size: 10px;
        cursor: text;
        outline: none;
        width: 150px; /* Make the search box smaller */
    }
    .dataTables_length select, .dataTables_filter input {
    font-size: 9px; /* Reduced font size */
    padding: 3px 6px; /* Reduced padding */
}

    /* Pagination Controls */
    .dataTables_paginate {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .dataTables_paginate a {
    padding: 3px 6px; /* Reduced padding */
    font-size: 9px; /* Smaller font size */
}

    .dataTables_paginate a {
        padding: 4px 8px;
        background-color: #4A90E2;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 10px; /* Smaller font size */
        transition: background-color 0.2s ease;
    }

    .dataTables_paginate a:hover {
        background-color: #0073e6;
    }

    /* Scrollable tbody */
    .dataTables_scrollBody {
        max-height: 400px; /* Adjust height as needed */
        overflow-y: auto;
    }

/* Shrink DataTable control elements consistently */
.dt-length,
.dt-search,
.dt-info,
.dt-paging {
    font-size: 10px !important;
    padding: 2px 5px !important;
}

/* Dropdown for entries per page */
.dt-length select {
    font-size: 10px !important;
    padding: 2px 4px !important;
}

/* Search bar input */
.dt-search input[type="search"] {
    font-size: 10px !important;
    padding: 4px 6px !important;
}

/* Pagination buttons */
.dt-paging .paginate_button {
    font-size: 10px !important;
    padding: 2px 5px !important;
}

</style>


<style>
        /* Center table header and body content */
        #allItemsTable th,
        #allItemsTable td {
            text-align: center;
        }
    </style>

<style>
.new-indicator {
    position: absolute; /* Position it absolutely */
    top: -10px; /* Adjust distance from the top of the row */
    left: 5px; /* Adjust distance from the left of the row */
    background-color: #4CAF50;
    color: white;
    font-size: 0.8rem;
    padding: 2px 6px;
    border-radius: 3px;
    cursor: pointer;
}

.new-item {
    position: relative; /* Ensure the row can hold the absolute positioned label */
}

</style>


</head>
<body class="bg-gray-100">
<!-- Main Content -->
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
            <button id="add-item-btn" class="tab-button add-item-btn">
                + Add Item
            </button>
        </div>

<!-- All Items Tab -->
<div id="all-items-content" class="tab-content active">
    <!--<h3 class="text-xl font-semibold mb-4">All Items</h3>-->
    <div class="table-container">
        <table id="allItemsTable" class="display">
            <thead>
                <tr>
                    <th>Item Code</th>
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
                    <tr id="item-{{ $item->id }}" class="{{ \Carbon\Carbon::parse($item->added_at)->diffInDays(now()) <= 5 ? 'new-item' : '' }}" data-added-at="{{ $item->added_at }}">
                        <td>{{ $item->item_code }}</td>
                        <td>
                            {{ $item->name }}
                            @if(\Carbon\Carbon::parse($item->added_at)->diffInDays(now()) <= 5)
                                <span class="new-indicator">New!</span>
                            @endif
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 80px;"></td>
                        <td class="action-buttons">
                            <div class="button-container">
                                <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                                <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- DRRM Equipment Tab -->
<div id="equipment-content" class="tab-content">
    <!--<h3 class="text-xl font-semibold mb-4">DRRM Equipment</h3>--->
    <div class="table-container">
        <table id="equipmentTable" class="display">
            <thead>
                <tr>
                    <th>Item Code</th>
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
                    <td>{{ $item->item_code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 80px;"></td>
                        <td class="action-buttons">
                            <div class="button-container">
                                <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                                <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Office Supplies Tab -->
<div id="office-supplies-content" class="tab-content">
    <!--<h3 class="text-xl font-semibold mb-4">Office Supplies</h3>--->
    <div class="table-container">
        <table id="officeSuppliesTable" class="display">
            <thead>
                <tr>
                    <th>Item Code</th>
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
                    <td>{{ $item->item_code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 80px;"></td>
                        <td class="action-buttons">
                            <div class="button-container">
                                <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                                <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Emergency Kits Tab -->
<div id="emergency-kits-content" class="tab-content">
    <!--<h3 class="text-xl font-semibold mb-4">Emergency Kits</h3>-->
    <div class="table-container">
        <table id="emergencyKitsTable" class="display">
            <thead>
                <tr>
                <th>Item Code</th>
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
                    <td>{{ $item->item_code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 80px;"></td>
                        <td class="action-buttons">
                            <div class="button-container">
                                <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                                <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Other Items Tab -->
<div id="other-items-content" class="tab-content">
    <!--<h3 class="text-xl font-semibold mb-4">Other Items</h3>--->
    <div class="table-container">
        <table id="otherItemsTable" class="display">
            <thead>
                <tr>
                <th>Item Code</th>
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
                    <td>{{ $item->item_code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 80px;"></td>
                        <td class="action-buttons">
                            <div class="button-container">
                                <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                                <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Archives Tab -->
<div id="archives-content" class="tab-content">
    <!--<h3 class="text-xl font-semibold mb-4">Archives</h3>-->
    <div class="table-container">
        <table id="archivesTable" class="display">
            <thead>
                <tr>
                <th>Item Code</th>
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
                    <td>{{ $item->item_code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->storage_location }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>{{ $item->date_purchased }}</td>
                        <td>{{ $item->status }}</td>
                        <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 80px;"></td>
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

<script>
$(document).ready(function () {
    var currentDate = new Date();  // Get the current date (this is your "now")

    // Loop through all items in the table
    $('#allItemsTable tbody tr').each(function () {
        var addedDate = $(this).data('added-at'); // Get the 'added_at' from data attribute

        // Parse the addedDate into a proper Date object
        var addedDateObj = new Date(addedDate);  // Parse the string into a Date object

        // Check if the date is invalid (NaN) after parsing
        if (isNaN(addedDateObj.getTime())) {
            console.log("Invalid date format: " + addedDate);
            return;  // Skip this item if the date is invalid
        }

        // Calculate the time difference in milliseconds between the current time and added time
        var timeDiff = currentDate - addedDateObj;  // This gives the difference in milliseconds

        // Calculate hours and minutes from the time difference in milliseconds
        var hoursDiff = Math.floor(timeDiff / (1000 * 60 * 60));  // Calculate the full hours
        var minutesDiff = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));  // Calculate the remaining minutes

        // Add the "New!" indicator if the item was added within the last 5 days
        var daysDiff = Math.floor(timeDiff / (1000 * 3600 * 24));  // Convert milliseconds to days
        if (daysDiff <= 5) {
            $(this).addClass('new-item');  // Add the "new-item" class

            // Add the "New!" indicator in the first column (or adjust as needed)
            var indicator = '<span class="new-indicator">New!</span>';
            $(this).find('td:first').append(indicator);  // Append "New!" next to the Item Code column
        }

        // Add hover effect to show the time difference (including hours and minutes) when hovering over the "New!" label
        $(this).find('.new-indicator').hover(function() {
            // Format the time difference
            var elapsedTime = hoursDiff + " hours and " + minutesDiff + " minutes ago";

            // Set the "added_at" value as the tooltip text (this will show the time difference on hover)
            $(this).attr('title', 'Item added: ' + elapsedTime);  // Show the time difference on hover
        });
    });
});

</script>


<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
<script src="https://unpkg.com/phosphor-icons@1.4.2/dist/index.js"></script>


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
    $(document).ready(function () {
        $('#allItemsTable').DataTable({
            scrollY: '425px', 
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 10,
            "initComplete": function(settings, json) {
                $('#allItemsTable').css('font-size', '12px');
                $('#allItemsTable thead th').css('font-size', '10px');
                $('#allItemsTable tbody td').css('font-size', '10px');
            }
        });

        $('#equipmentTable').DataTable({
            scrollY: '425px',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 10,
            "initComplete": function(settings, json) {
                $('#equipmentTable').css('font-size', '12px');
                $('#equipmentTable thead th').css('font-size', '10px');
                $('#equipmentTable tbody td').css('font-size', '10px');
            }
        });

        $('#officeSuppliesTable').DataTable({
            scrollY: '425px',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 10,
            "initComplete": function(settings, json) {
                $('#officeSuppliesTable').css('font-size', '12px');
                $('#officeSuppliesTable thead th').css('font-size', '10px');
                $('#officeSuppliesTable tbody td').css('font-size', '10px');
            }
        });

        $('#emergencyKitsTable').DataTable({
            scrollY: '425px',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 10,
            "initComplete": function(settings, json) {
                $('#emergencyKitsTable').css('font-size', '12px');
                $('#emergencyKitsTable thead th').css('font-size', '10px');
                $('#emergencyKitsTable tbody td').css('font-size', '10px');
            }
        });

        $('#otherItemsTable').DataTable({
            scrollY: '425px',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 10,
            "initComplete": function(settings, json) {
                $('#otherItemsTable').css('font-size', '12px');
                $('#otherItemsTable thead th').css('font-size', '10px');
                $('#otherItemsTable tbody td').css('font-size', '10px');
            }
        });

        $('#archivesTable').DataTable({
            scrollY: '425px',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "pageLength": 10,
            "initComplete": function(settings, json) {
                $('#archivesTable').css('font-size', '12px');
                $('#archivesTable thead th').css('font-size', '10px');
                $('#archivesTable tbody td').css('font-size', '10px');
            }
        });
    });
</script>

<script>
$(document).ready(function () {
    // Show the Add Item Modal when the button is clicked
    $("#add-item-btn").click(function () {
        $("#addItemModal").removeClass("hidden");
    });

    // Validate quantity to ensure it is not 0 or empty
    $('#quantity').on('input', function () {
        var quantity = $(this).val();
        if (quantity == 0 || quantity == "") {
            $("#saveButton").prop('disabled', true); // Disable save button if quantity is 0 or empty
        } else {
            $("#saveButton").prop('disabled', false); // Enable save button
        }
    });

    // Storage location dropdown logic
    $('#storage_location').on('change', function () {
        if ($(this).val() == 'Other') {
            $('#other_storage_location').removeClass('hidden'); // Show input if "Other" is selected
        } else {
            $('#other_storage_location').addClass('hidden'); // Hide input if not "Other"
        }
    });

    // Unit dropdown logic: Show input field inline next to "Other"
    $('#unit').on('change', function () {
        if ($(this).val() == 'Other') {
            $('#other_unit').removeClass('hidden'); // Show inline input if "Other" is selected
        } else {
            $('#other_unit').addClass('hidden'); // Hide inline input if not "Other"
        }
    });

    // Ensure no future dates can be selected for Arrival Date and Date Purchased
    const today = new Date().toISOString().split('T')[0];
    $('#arrival_date, #date_purchased').attr('max', today);

    // On form submission, submit the data to save both items and individual items
    $("#itemForm").submit(function (e) {
        // Get the Arrival Date and Date Purchased
        var arrivalDate = $("#arrival_date").val();
        var purchasedDate = $("#date_purchased").val();

        // Compare the Arrival Date with Date Purchased
        if (new Date(arrivalDate) < new Date(purchasedDate)) {
            // Show an alert if Arrival Date is earlier than Date Purchased
            Swal.fire({
                title: 'Error!',
                text: 'Arrival Date cannot be earlier than the Date Purchased.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            e.preventDefault(); // Prevent the form from submitting
            return false;
        }

        e.preventDefault();  // Prevent default form submission

        // Grabs the form data and explicitly append required fields
        var formData = new FormData(this);  // Grabs the form data
        
        // Explicitly append required fields if they aren't automatically added
        formData.append('name', $('#name').val());  // Add 'name' field
        formData.append('unit', $('#unit').val());  // Add 'unit' field
        formData.append('category', $('#category').val());  // Add 'category' field

        // If "Other" is selected for unit, append the value from other_unit field
        if ($('#unit').val() === 'Other') {
            formData.append('unit', $('#other_unit').val());  // Add custom unit if "Other" is selected
        }

        // Optional: Log the FormData to check what is being sent
        console.log(formData);  // This will print the form data in the browser console

        // Show SweetAlert loading spinner before the request
        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we save the item.',
            icon: 'info',
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading(); // Show loading spinner
            }
        });

        // Proceed with the AJAX request to submit the form data
        $.ajax({
            url: "{{ route('items.store') }}",  // Your URL for item saving
            method: 'POST',
            data: formData,
            processData: false,  // Don't process the data (since it's FormData)
            contentType: false,  // Set content type to false to let FormData handle it
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Item saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });

                // Prepend the new item to the top of the table (specifically to the all items table)
                var newItemRow = `
                    <tr id="item-${response.id}">
                        <td>${response.item_code}</td>
                        <td>${response.name}</td>
                        <td>${response.quantity}</td>
                        <td>${response.unit}</td>
                        <td>${response.category}</td>
                        <td>${response.description}</td>
                        <td>${response.storage_location}</td>
                        <td>${response.arrival_date}</td>
                        <td>${response.date_purchased}</td>
                        <td>${response.status}</td>
                        <td><img src="${response.image_url}" alt="${response.name}" class="w-10 h-10"></td>
                        <td class="action-buttons">
                            <button onclick="openEditModal('${response.id}')" class="edit-btn">Edit</button>
                            <button type="button" class="archive-btn" onclick="archiveItem('${response.id}')">Archive</button>
                        </td>
                    </tr>`;

                // Prepend the new item row to the table (this will put it at the top)
                $('#allItemsTable tbody').prepend(newItemRow);

                // Optionally, reset the modal and reload the page or form
                $("#addItemModal").addClass("hidden");
                $('#itemForm')[0].reset();  // Reset form fields
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error saving the item.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Search functionality for existing items
    $('#search-item').on('input', function () {
        var itemName = $(this).val();
        if (itemName.length > 0) {
            $.ajax({
                url: '/search-item/' + itemName,  // Replace with your search route
                method: 'GET',
                success: function (data) {
                    if (data) {
                        // Fill in the form with the existing item data
                        $('#name').val(data.name).prop('disabled', true);
                        $('#category').val(data.category).prop('disabled', true);
                        $('#unit').val(data.unit).prop('disabled', true);
                        $('#description').val(data.description).prop('disabled', true);
                        $('#image_url').prop('disabled', true);

                        // Make editable fields available
                        $('#quantity').val('').prop('disabled', false);
                        $('#storage_location').val('').prop('disabled', false);
                        $('#arrival_date').val('').prop('disabled', false);
                        $('#date_purchased').val('').prop('disabled', false);
                        $('#status').val('Available').prop('disabled', false);
                    } else {
                        // Reset the form if no item found
                        $('#name').val('').prop('disabled', false);
                        $('#category').val('').prop('disabled', false);
                        $('#unit').val('').prop('disabled', false);
                        $('#description').val('').prop('disabled', false);
                        $('#image_url').prop('disabled', false);

                        $('#quantity').val('').prop('disabled', false);
                        $('#storage_location').val('').prop('disabled', false);
                        $('#arrival_date').val('').prop('disabled', false);
                        $('#date_purchased').val('').prop('disabled', false);
                        $('#status').val('Available').prop('disabled', false);
                    }
                }
            });
        } else {
            // If the input is empty, reset the form
            $('#name').val('').prop('disabled', false);
            $('#category').val('').prop('disabled', false);
            $('#unit').val('').prop('disabled', false);
            $('#description').val('').prop('disabled', false);
            $('#image_url').prop('disabled', false);

            $('#quantity').val('').prop('disabled', false);
            $('#storage_location').val('').prop('disabled', false);
            $('#arrival_date').val('').prop('disabled', false);
            $('#date_purchased').val('').prop('disabled', false);
            $('#status').val('Available').prop('disabled', false);
        }
    });

    // Cancel button functionality for Add Item modal
    $("#cancelModal").click(function () {
        $("#addItemModal").addClass("hidden");  // Hide the modal when cancel is clicked
    });

    // Clear button functionality for the Add Item modal
    $("#clearForm").click(function () {
        // Clear all input fields and reset the dropdowns to their default value
        $('#itemForm').find('input[type="text"], input[type="number"], input[type="date"], input[type="file"], textarea').val('');
        $('#itemForm').find('select').prop('selectedIndex', 0); // Reset all dropdowns to the first option

        // If you have a field for "Other" input (for unit or storage location), hide them and clear their values
        $('#other_unit').addClass('hidden').val('');
        $('#other_storage_location').addClass('hidden').val('');

        // Clear the search bar field and reset it to an empty state
        $('#search-item').val('');

        // Re-enable the input fields to make them editable again
        $('#itemForm').find('input, select, textarea').prop('disabled', false);
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
            beforeSend: function() {
                // Show SweetAlert loading spinner before archiving the item
                Swal.fire({
                    title: 'Archiving...',
                    text: 'Please wait while we archive the item.',
                    icon: 'info',
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Item archived successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                $('#item-' + itemId).remove(); // Remove the item row from the table
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error archiving item.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
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
            beforeSend: function() {
                // Show SweetAlert loading spinner before restoring the item
                Swal.fire({
                    title: 'Restoring...',
                    text: 'Please wait while we restore the item.',
                    icon: 'info',
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Item restored successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                location.reload(); // Reload the page to update the table
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error restoring item.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
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
            $('#edit_item_name').val(item.name);
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
            Swal.fire({
                title: 'Error!',
                text: 'Error fetching item data.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

// Save the updated item data when the form is submitted
$('#editItemForm').submit(function(e) {
    e.preventDefault();  // Prevent default form submission

    // Show SweetAlert loading spinner before the request
    Swal.fire({
        title: 'Updating...',
        text: 'Please wait while we update the item.',
        icon: 'info',
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Send the form data using AJAX
    $.ajax({
        url: $(this).attr('action'),  // Get the form's action URL
        method: 'POST',  // Use 'POST' for the AJAX request
        data: $(this).serialize(),   // Serialize the form data
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: 'Item updated successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            $('#editItemModal').addClass('hidden');
            location.reload();  // Refresh the page to show the updated data
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Error updating item.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});

// Close the Edit Item Modal when clicking the "Cancel" button or the "Close" button (×)
$(document).ready(function () {
    $("#cancelEditModal, #closeEditModal").click(function () {
        $("#editItemModal").addClass("hidden");  // Hide the modal
    });
});
</script>



<!-- Modal Overlay for Adding Item -->
<div id="addItemModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50">
    <div class="relative z-10 flex items-center justify-center">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 90%; height: auto;">
            <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Item</h3>

                <!-- Search for Item -->
                <div class="mb-4">
                    <label for="search-item" class="block text-xs font-medium text-gray-900">Search Item by Name</label>
                    <input type="text" id="search-item" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Search Item Name">
                </div>

                <form id="itemForm" action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-medium text-gray-900">Item Name</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <div>
                                <label for="category" class="block text-xs font-medium text-gray-900">Category</label>
                                <select id="category" name="category" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                                    <option value="DRRM Equipment">DRRM Equipment</option>
                                    <option value="Office Supplies">Office Supplies</option>
                                    <option value="Emergency Kits">Emergency Kits</option>
                                    <option value="Other Items">Other Items</option>
                                </select>
                            </div>

                            <div>
                                <label for="quantity" class="block text-xs font-medium text-gray-900">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <div>
                                <label for="unit" class="block text-xs font-medium text-gray-900">Unit</label>
                                <div class="flex items-center">
                                    <select id="unit" name="unit" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                                        <option value="Piece">Piece</option>
                                        <option value="Set">Set</option>
                                        <option value="Box">Box</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <!-- Inline input field next to 'Other' -->
                                    <input type="text" id="other_unit" name="other_unit" class="mt-1 ml-2 hidden py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs w-20" maxlength="12" placeholder="Type unit">
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-medium text-gray-900">Description</label>
                                <textarea id="description" name="description" rows="3" maxlength="50" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"></textarea>
                            </div>

                            <div>
                                <label for="storage_location" class="block text-xs font-medium text-gray-900">Storage Location</label>
                                <select id="storage_location" name="storage_location" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                                    <option value="Shelf A">Shelf A</option>
                                    <option value="Shelf B">Shelf B</option>
                                    <option value="Shelf C">Shelf C</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" id="other_storage_location" name="other_storage_location" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs hidden" maxlength="12" placeholder="Type other location here">
                            </div>

                            <div>
                                <label for="arrival_date" class="block text-xs font-medium text-gray-900">Arrival Date</label>
                                <input type="date" id="arrival_date" name="arrival_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <div>
                                <label for="date_purchased" class="block text-xs font-medium text-gray-900">Date Purchased</label>
                                <input type="date" id="date_purchased" name="date_purchased" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <div>
                                <label for="status" class="block text-xs font-medium text-gray-900">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                                    <option value="Available">Available</option>
                                </select>
                            </div>

                            <div>
                                <label for="image_url" class="block text-xs font-medium text-gray-900">Image</label>
                                <input type="file" id="image_url" name="image_url" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <button type="button" id="cancelModal" class="text-xs font-semibold text-gray-900 px-4 py-2 bg-gray-400 rounded-md transition duration-300 hover:bg-gray-600 hover:text-white">
                                Cancel
                            </button>
                            <button type="submit" id="saveButton" class="rounded-md bg-green-400 px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-green-600 hover:text-white">
                                Save
                            </button>
                            <!-- Clear Button -->
                            <button type="button" id="clearForm" class="text-xs font-semibold text-gray-900 px-4 py-2 bg-gray-400 rounded-md transition duration-300 hover:bg-gray-600 hover:text-white">
                                Clear
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Editing Item -->
<div id="editItemModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50">
    <div class="relative z-10 flex items-center justify-center">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 90%; height: auto;">
            <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Item</h3>

                <form id="editItemForm" action="{{ route('items.update', ['id' => '__ID__']) }}" method="POST">
                    @csrf
                    @method('PUT')  <!-- Use PUT method for updates -->
                    <input type="hidden" id="edit_item_id" name="item_id">

                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_item_name" class="block text-xs font-medium text-gray-900">Item Name</label>
                                <input type="text" id="edit_item_name" name="name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <div>
                                <label for="edit_category" class="block text-xs font-medium text-gray-900">Category</label>
                                <select id="edit_category" name="category" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                    <option value="DRRM Equipment">DRRM Equipment</option>
                                    <option value="Office Supplies">Office Supplies</option>
                                    <option value="Emergency Kits">Emergency Kits</option>
                                    <option value="Other Items">Other Items</option>
                                </select>
                            </div>

                            <div>
                                <label for="edit_quantity" class="block text-xs font-medium text-gray-900">Quantity</label>
                                <input type="number" id="edit_quantity" name="quantity" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <div>
                                <label for="edit_unit" class="block text-xs font-medium text-gray-900">Unit</label>
                                <input type="text" id="edit_unit" name="unit" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>

                            <div>
                                <label for="edit_description" class="block text-xs font-medium text-gray-900">Description</label>
                                <textarea id="edit_description" name="description" rows="3" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"></textarea>
                            </div>

                            <div>
                                <label for="edit_storage_location" class="block text-xs font-medium text-gray-900">Storage Location</label>
                                <input type="text" id="edit_storage_location" name="storage_location" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>

                            <div>
                                <label for="edit_arrival_date" class="block text-xs font-medium text-gray-900">Arrival Date</label>
                                <input type="date" id="edit_arrival_date" name="arrival_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>

                            <div>
                                <label for="edit_date_purchased" class="block text-xs font-medium text-gray-900">Date Purchased</label>
                                <input type="date" id="edit_date_purchased" name="date_purchased" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>

                            <div>
                                <label for="edit_status" class="block text-xs font-medium text-gray-900">Status</label>
                                <select id="edit_status" name="status" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>

                            <div>
                                <label for="edit_image" class="block text-xs font-medium text-gray-900">Image</label>
                                <input type="file" id="edit_image" name="image_url" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <button type="button" id="cancelEditModal" class="text-xs font-semibold text-gray-900 px-4 py-2 bg-gray-400 rounded-md transition duration-300 hover:bg-gray-600 hover:text-white">
                                Cancel
                            </button>
                            <button type="submit" class="rounded-md bg-green-400 px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-green-600 hover:text-white">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>