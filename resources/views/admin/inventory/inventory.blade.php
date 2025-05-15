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
    html,
    body {
        overflow: hidden;
        /* Prevent scrolling on the entire page */
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
        padding: 0.3rem 1rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
        border: none;
        border-radius: 0.375rem;
    }

    .tab-button:hover {
        opacity: 0.8;
    }

    .tab-button.active {
        font-weight: bold;
        background-color: #4A90E2;
    }

    /* Flex container for Tabs and Add Item Button */
    .tab-container {
        display: flex;
        align-items: center;
        margin-bottom: -0.5rem;
        /* Slightly smaller margin */
        margin-top: 1.5rem;
    }

    .tab-button-container {
        display: flex;
    }

    .tab-button+.tab-button {
        margin-left: 0.4rem;
        /* Reduced margin between tabs */
    }


    #add-item-btn {
        font-size: 0.9rem;
        /* Slightly smaller font */
        margin-left: auto;
        /* Push the button to the far right */
        background-color: #4cc9f0;
        ;
        /* Green */
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 60px 60px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #add-item-btn:hover {
        background-color: #3fb3d1;
        /* Darker green for hover effect */
        opacity: 0.8;
        /* Slight opacity change on hover */
    }

    /* Custom Tab Colors */
    .equipment-tab {
        background-color: #B79CED;
        /* Blue */
    }

    .office-supplies-tab {
        background-color: #B79CED;
        /* Orange */
    }

    .emergency-kits-tab {
        background-color: #B79CED;
        /* Red */
    }

    /* Table Styles */
    table {
        width: 100%;
    border-collapse: collapse;
    margin-top: 2rem;
    margin-bottom: -2rem;
    height: 100%;
    table-layout: fixed; /* Changed to auto for dynamic sizing */
    }

    table th, table td {
        padding: 8px;
    text-align: center;
    border-bottom: 1px solid #E5E5E5;
    font-size: 12px;
    height: 20px !important;
    vertical-align: middle;
    width: auto;
    }

    table td {
        height: 80px !important;
        /* Apply height with higher priority */
        position: relative;
    }

    /* Hover effect only on the table header cell being hovered over */
    table th {
        background-color: transparent;
        color: #4a5568;
        font-weight: bold;
    }

    table th:hover {
        background-color: #f0f0f0;
        color: #2D3748;
        cursor: pointer;
    }

    /* Add hover effect for rows */
    table tr:hover {
        background-color: transparent;
        /* Match hover effect from the second code */
    }

    table td:hover {
        background-color: transparent;
    }

    .table-container {
        width: 100%;
max-height: 850px; /* Set max height for the table container */
overflow-x: auto; /* Allow horizontal scrolling if necessary */
overflow-y: auto; /* Allow vertical scrolling if necessary */
margin-top: 0.3rem;
margin-bottom: -2rem;

    }

    /* Form row layout (two fields per row) */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        /* 2 columns */
        gap: 1rem;
        /* Space between columns */
    }

    .form-row>div {
        margin-bottom: 1rem;
        /* Margin for each field */
    }

    .archives-tab {
        background-color: #B79CED;
        /* Blue color for the Archives tab */
    }

    .restore-btn {
        background-color: rgb(21, 183, 75);
        /* Purple */
        color: white;
        border-radius: 4px;
        font-size: 14px;
        padding: 6px 12px;
        /* Same padding as the other buttons */
        width: auto;
        cursor: pointer;
        text-align: center;
        margin-bottom: 5px;
        margin-top: 2px;
        transition: background-color 0.3s, transform 0.2s;
        /* Added transition for smooth hover effect */
    }

    .restore-btn:hover {
        background-color: rgb(81, 166, 109);
        /* Darker shade of purple for hover effect */
        transform: scale(1.05);
        /* Slight scaling effect on hover for better interactivity */
    }

    #myTable {
        width: 100%;
        overflow-x: auto;
        /* Enable horizontal scrolling */
        overflow-y: auto;
        /* Enable vertical scrolling */
    }

    .all-items-tab {
        background-color: #B79CED;
        /* Gray */
    }

    .other-items-tab {
        background-color: #B79CED;
        /* Yellow */
    }

    table td img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        max-width: 70px;
        max-height: 65px;
    }

    /* Fix specific column width for image and action columns */
    table th:nth-child(11),
    table td:nth-child(11) {
        width: 140px !important;
    }

    table th:nth-child(12),
    table td:nth-child(12) {
        width: 160px !important;
    }

     /* Ensuring all columns behave consistently */
     table th:nth-child(1),
    table td:nth-child(1) { width: 80px; }

    table th:nth-child(2),
    table td:nth-child(2) { width: 80px; }

    table th:nth-child(3),
    table td:nth-child(3) { width: 100px; }

    table th:nth-child(4),
    table td:nth-child(4) { width: 100px; }

    table th:nth-child(5),
    table td:nth-child(5) { width: 100px; }

    table th:nth-child(6),
    table td:nth-child(6) { width: 120px; }

    table th:nth-child(7),
    table td:nth-child(7) { width: 150px; }

    table th:nth-child(8),
    table td:nth-child(8) { width: 100px; }

    table th:nth-child(9),
    table td:nth-child(9) { width: 100px; }

    table th:nth-child(10),
    table td:nth-child(10) { width: 100px; }

    table th:nth-child(11),
    table td:nth-child(11) { width: 70px; }

    table th:nth-child(12),
    table td:nth-child(12) { width: 70px; }

    table th:nth-child(13),
    table td:nth-child(13) { width: 100px; }

    table th:nth-child(14),
    table td:nth-child(14) { width: 80px; }

    table th:nth-child(15),
    table td:nth-child(15) { width: 120px; }

    table th:nth-child(16),
    table td:nth-child(16) { width: 120px; }

    table td .action-buttons {
        display: flex;
        justify-content: space-around;
        align-items: center;
        height: 100%;
        gap: 5px;
        /* Space between buttons */
    }

    /* Styling for the Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: space-around;
        /* Space between buttons */
        align-items: center;
        height: 100%;
        gap: 5px
    }

    .button-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .edit-btn,
    .archive-btn {
        border-radius: 5px;
        /* Slightly rounded corners */
        padding: 5px 30px;
        /* Increased padding for better touch */
        font-size: 12px;
        /* Font size adjustment */
        white-space: nowrap;
        /* Prevent text overflow */
        overflow: hidden;
        /* Hide overflow if the button text is too long */
    }

    .edit-btn {
        top: 0;
        /* Position the Edit button at the top */
        background-color: #4cc9f0;
        /* Edit button color */
        color: white;

    }

    .edit-btn:hover {
        background-color: #36a9c1;
        /* Darker shade on hover */
        transform: scale(1.05);
        /* Slight scaling effect */
    }

    .archive-btn {
        top: 40px;
        /* Position the Archive button below the Edit button */
        background-color: #57cc99;
        /* Archive button color */
        color: white;
        margin-bottom: -3px;
    }

    .archive-btn:hover {
        background-color: #57cc99;
        /* Darker shade on hover */
        transform: scale(1.05);
        /* Slight scaling effect */
    }

    /* Default Styles for Table Header */
    table thead th {
        background-color: transparent;
        /* No background color */
        border: 1px solid transparent;
        /* Default border color */
        padding: 10px;
        font-size: 11px;
        text-align: center;
        color: #4a5568;
    font-weight: bold;
    position: sticky;
    top: 0;  /* Stick to the top of the table */
    z-index: 1;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
    }


    /* Hover Effect */
    table thead th:hover {
        border-color: gray;
        /* Change border to gray on hover */
    }

    /* Change font size for table headers */
    table.dataTable thead th {
        font-size: 11px;
        /* Adjust the font size for the headers */
        text-align: center;

    }

    /* Change font size for table cells */
    table.dataTable tbody td {
        font-size: 14px;
        /* Adjust the font size for table data cells */
        text-align: center;
    }

    /**/
    /**/
    /* Style the container */
    /* Entries per page Dropdown */
    .dataTables_length {
        display: flex;
        align-items: center;
        gap: 4px;
        /* Smaller gap */
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        /* Smaller font size */
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
        width: 50px;
        /* Reduced width */
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
        width: 150px;
        /* Make the search box smaller */
    }

    .dataTables_length select,
    .dataTables_filter input {
        font-size: 9px;
        /* Reduced font size */
        padding: 3px 6px;
        /* Reduced padding */
    }

    /* Pagination Controls */
    .dataTables_paginate {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .dataTables_paginate a {
        padding: 3px 6px;
        /* Reduced padding */
        font-size: 9px;
        /* Smaller font size */
    }

    .dataTables_paginate a {
        padding: 4px 8px;
        background-color: #4A90E2;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 10px;
        /* Smaller font size */
        transition: background-color 0.2s ease;
    }

    .dataTables_paginate a:hover {
        background-color: #0073e6;
    }

    /* Scrollable tbody */
    .dataTables_scrollBody {
        max-height: 400px;
        /* Adjust height as needed */
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
        position: absolute;
        top: -5px;
        left: 0;
        background-color: rgb(143, 234, 146);
        color: white;
        font-size: 0.8rem;
        padding: 2px 6px;
        border-radius: 3px;
    }

    .new-item {
        position: relative;
        /* Ensure the row can hold the absolute positioned label */
    }

    /* For DRRM Equipment Table */
    #equipmentTable th,
    #equipmentTable td {
        font-family: 'Arial', sans-serif;
        /* Set a consistent font family */
        font-size: 12px;
        /* Ensure a uniform font size */
    }

    /* For Office Supplies Table */
    #officeSuppliesTable th,
    #officeSuppliesTable td {
        font-family: 'Arial', sans-serif;
        /* Set a consistent font family */
        font-size: 12px;
        /* Ensure a uniform font size */
    }

    /* For Emergency Kits Table */
    #emergencyKitsTable th,
    #emergencyKitsTable td {
        font-family: 'Arial', sans-serif;
        /* Set a consistent font family */
        font-size: 12px;
        /* Ensure a uniform font size */
    }

    /* For Other Items Table */
    #otherItemsTable th,
    #otherItemsTable td {
        font-family: 'Arial', sans-serif;
        /* Set a consistent font family */
        font-size: 12px;
        /* Ensure a uniform font size */
    }

    /* For Archives Table */
    #archivesTable th,
    #archivesTable td {
        font-family: 'Arial', sans-serif;
        /* Set a consistent font family */
        font-size: 12px;
        /* Ensure a uniform font size */
    }

    /* Ensuring all DataTable controls fit well within container */
    .dataTables_wrapper .dataTables_scroll {
        overflow-x: auto !important;
        table-layout: fixed;
    }

    .dataTables_wrapper .dataTables_paginate {
        font-size: 12px !important;
    }

    table.dataTable tbody td {
        font-size: 12px;
        /* Make sure the font size remains consistent */
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

<!-- All Items Table -->
<div id="all-items-content" class="tab-content active">
    <div class="table-container">
        <table id="allItemsTable" class="display">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Inventory Date</th>
                    <th>Expiration Date</th>
                    <th>Date Tested/Inspected</th>
                    <th>Status</th>
                    <th>Consumable</th> <!-- New Consumable Column -->
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allItems as $item)
                <tr id="item-{{ $item->id }}" class="{{ \Carbon\Carbon::parse($item->added_at)->diffInDays(now()) <= 5 ? 'new-item' : '' }}" data-added-at="{{ $item->added_at }}">
                <td>{{ $item->name }}</td>
                <td>{{ $item->item_code }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->storage_location }}</td>
                    <td>{{ $item->arrival_date }}</td>
                    <td>{{ $item->inventory_date ?? 'N/A' }}</td>
                    <td>{{ $item->expiration_date ?? 'N/A' }}</td>
                    <td>{{ $item->date_tested_inspected ?? 'N/A' }}</td>
                    <td>
                        <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                        {{ $item->status == 'Available' ? 'bg-green-500/10 text-green-500 border border-green-500' : '' }}
                        {{ $item->status == 'Unavailable' ? 'bg-red-500/10 text-red-500 border border-red-500' : '' }}
                        {{ $item->status == 'Pending' ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500' : '' }}
                        {{ $item->status == 'Approved' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                        {{ $item->status == 'In Progress' ? 'bg-orange-500/10 text-orange-500 border border-orange-500' : '' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->is_consumable === 1 ? 'Yes' : 'No' }}</td> <!-- Display Consumable Status -->
                    <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 65px;"></td>
                    <td class="action-buttons">
                        <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                        <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Equipment Table -->
<div id="equipment-content" class="tab-content">
    <div class="table-container">
        <table id="equipmentTable" class="display">
            <thead>
                <tr>
                <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Inventory Date</th>
                    <th>Expiration Date</th>
                    <th>Date Tested/Inspected</th>
                    <th>Status</th>
                    <th>Consumable</th> <!-- New Consumable Column -->
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drrmItems as $item)
                <tr id="item-{{ $item->id }}" class="{{ \Carbon\Carbon::parse($item->added_at)->diffInDays(now()) <= 5 ? 'new-item' : '' }}" data-added-at="{{ $item->added_at }}">
                <td>{{ $item->name }}</td>    
                <td>{{ $item->item_code }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->storage_location }}</td>
                    <td>{{ $item->arrival_date }}</td>
                    <td>{{ $item->inventory_date ?? 'N/A' }}</td>
                    <td>{{ $item->expiration_date ?? 'N/A' }}</td>
                    <td>{{ $item->date_tested_inspected ?? 'N/A' }}</td>
                    <td>
                        <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                        {{ $item->status == 'Available' ? 'bg-green-500/10 text-green-500 border border-green-500' : '' }}
                        {{ $item->status == 'Unavailable' ? 'bg-red-500/10 text-red-500 border border-red-500' : '' }}
                        {{ $item->status == 'Pending' ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500' : '' }}
                        {{ $item->status == 'Approved' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                        {{ $item->status == 'In Progress' ? 'bg-orange-500/10 text-orange-500 border border-orange-500' : '' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->is_consumable === 1 ? 'Yes' : 'No' }}</td> <!-- Display Consumable Status -->
                    <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 65px;"></td>
                    <td class="action-buttons">
                        <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                        <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Office Supplies Table -->
<div id="office-supplies-content" class="tab-content">
    <div class="table-container">
        <table id="officeSuppliesTable" class="display">
            <thead>
                <tr>
                <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Inventory Date</th>
                    <th>Expiration Date</th>
                    <th>Date Tested/Inspected</th>
                    <th>Status</th>
                    <th>Consumable</th> <!-- New Consumable Column -->
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($officeItems as $item)
                <tr id="item-{{ $item->id }}" class="{{ \Carbon\Carbon::parse($item->added_at)->diffInDays(now()) <= 5 ? 'new-item' : '' }}" data-added-at="{{ $item->added_at }}">
                <td>{{ $item->name }}</td>    
                <td>{{ $item->item_code }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->storage_location }}</td>
                    <td>{{ $item->arrival_date }}</td>
                    <td>{{ $item->inventory_date ?? 'N/A' }}</td>
                    <td>{{ $item->expiration_date ?? 'N/A' }}</td>
                    <td>{{ $item->date_tested_inspected ?? 'N/A' }}</td>
                    <td>
                        <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                        {{ $item->status == 'Available' ? 'bg-green-500/10 text-green-500 border border-green-500' : '' }}
                        {{ $item->status == 'Unavailable' ? 'bg-red-500/10 text-red-500 border border-red-500' : '' }}
                        {{ $item->status == 'Pending' ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500' : '' }}
                        {{ $item->status == 'Approved' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                        {{ $item->status == 'In Progress' ? 'bg-orange-500/10 text-orange-500 border border-orange-500' : '' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->is_consumable === 1 ? 'Yes' : 'No' }}</td> <!-- Display Consumable Status -->
                    <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 65px;"></td>
                    <td class="action-buttons">
                        <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                        <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Emergency Kits Table -->
<div id="emergency-kits-content" class="tab-content">
    <div class="table-container">
        <table id="emergencyKitsTable" class="display">
            <thead>
                <tr>
                <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Inventory Date</th>
                    <th>Expiration Date</th>
                    <th>Date Tested/Inspected</th>
                    <th>Status</th>
                    <th>Consumable</th> <!-- New Consumable Column -->
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emergencyItems as $item)
                <tr id="item-{{ $item->id }}" class="{{ \Carbon\Carbon::parse($item->added_at)->diffInDays(now()) <= 5 ? 'new-item' : '' }}" data-added-at="{{ $item->added_at }}">
                <td>{{ $item->name }}</td>    
                <td>{{ $item->item_code }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->storage_location }}</td>
                    <td>{{ $item->arrival_date }}</td>
                    <td>{{ $item->inventory_date ?? 'N/A' }}</td>
                    <td>{{ $item->expiration_date ?? 'N/A' }}</td>
                    <td>{{ $item->date_tested_inspected ?? 'N/A' }}</td>
                    <td>
                        <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                        {{ $item->status == 'Available' ? 'bg-green-500/10 text-green-500 border border-green-500' : '' }}
                        {{ $item->status == 'Unavailable' ? 'bg-red-500/10 text-red-500 border border-red-500' : '' }}
                        {{ $item->status == 'Pending' ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500' : '' }}
                        {{ $item->status == 'Approved' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                        {{ $item->status == 'In Progress' ? 'bg-orange-500/10 text-orange-500 border border-orange-500' : '' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->is_consumable === 1 ? 'Yes' : 'No' }}</td> <!-- Display Consumable Status -->
                    <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 65px;"></td>
                    <td class="action-buttons">
                        <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                        <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Other Items Table -->
<div id="other-items-content" class="tab-content">
    <div class="table-container">
        <table id="otherItemsTable" class="display">
            <thead>
                <tr>
                <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Inventory Date</th>
                    <th>Expiration Date</th>
                    <th>Date Tested/Inspected</th>
                    <th>Status</th>
                    <th>Consumable</th> <!-- New Consumable Column -->
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($otherItems as $item)
                <tr id="item-{{ $item->id }}" class="{{ \Carbon\Carbon::parse($item->added_at)->diffInDays(now()) <= 5 ? 'new-item' : '' }}" data-added-at="{{ $item->added_at }}">
                <td>{{ $item->name }}</td>
                <td>{{ $item->item_code }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->storage_location }}</td>
                    <td>{{ $item->arrival_date }}</td>
                    <td>{{ $item->inventory_date ?? 'N/A' }}</td>
                    <td>{{ $item->expiration_date ?? 'N/A' }}</td>
                    <td>{{ $item->date_tested_inspected ?? 'N/A' }}</td>
                    <td>
                        <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                        {{ $item->status == 'Available' ? 'bg-green-500/10 text-green-500 border border-green-500' : '' }}
                        {{ $item->status == 'Unavailable' ? 'bg-red-500/10 text-red-500 border border-red-500' : '' }}
                        {{ $item->status == 'Pending' ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500' : '' }}
                        {{ $item->status == 'Approved' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                        {{ $item->status == 'In Progress' ? 'bg-orange-500/10 text-orange-500 border border-orange-500' : '' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->is_consumable === 1 ? 'Yes' : 'No' }}</td> <!-- Display Consumable Status -->
                    <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 65px;"></td>
                    <td class="action-buttons">
                        <button onclick="openEditModal('{{ $item->id }}')" class="edit-btn">Edit</button>
                        <button type="button" class="archive-btn" onclick="archiveItem('{{ $item->id }}')">Archive</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Archives Table -->
<div id="archives-content" class="tab-content">
    <div class="table-container">
        <table id="archivesTable" class="display">
            <thead>
                <tr>
                <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Storage Location</th>
                    <th>Arrival Date</th>
                    <th>Inventory Date</th>
                    <th>Expiration Date</th>
                    <th>Date Tested/Inspected</th>
                    <th>Status</th>
                    <th>Consumable</th> <!-- New Consumable Column -->
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($archivedItems as $item)
                <tr id="item-{{ $item->id }}" class="{{ \Carbon\Carbon::parse($item->added_at)->diffInDays(now()) <= 5 ? 'new-item' : '' }}" data-added-at="{{ $item->added_at }}">
                <td>{{ $item->name }}</td>    
                <td>{{ $item->item_code }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->storage_location }}</td>
                    <td>{{ $item->arrival_date }}</td>
                    <td>{{ $item->inventory_date ?? 'N/A' }}</td>
                    <td>{{ $item->expiration_date ?? 'N/A' }}</td>
                    <td>{{ $item->date_tested_inspected ?? 'N/A' }}</td>
                    <td>
                        <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                        {{ $item->status == 'Available' ? 'bg-green-500/10 text-green-500 border border-green-500' : '' }}
                        {{ $item->status == 'Unavailable' ? 'bg-red-500/10 text-red-500 border border-red-500' : '' }}
                        {{ $item->status == 'Pending' ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500' : '' }}
                        {{ $item->status == 'Approved' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                        {{ $item->status == 'In Progress' ? 'bg-orange-500/10 text-orange-500 border border-orange-500' : '' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->is_consumable === 1 ? 'Yes' : 'No' }}</td> <!-- Display Consumable Status -->
                    <td><img src="{{ asset($item->image_url) }}" alt="Item Image" style="max-width: 70px; max-height: 65px;"></td>
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
        console.log("Switching to tab: ", tab); // For debugging

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
    $(document).ready(function() {
        initializeDataTables();
    });
</script>

<script>
    $(document).ready(function() {
        var currentDate = new Date(); // Get the current date (this is your "now")

        // Loop through all items in the table
        $('#allItemsTable tbody tr').each(function() {
            var addedDate = $(this).data('added-at'); // Get the 'added_at' from data attribute

            // Parse the addedDate into a proper Date object
            var addedDateObj = new Date(addedDate); // Parse the string into a Date object

            // Check if the date is invalid (NaN) after parsing
            if (isNaN(addedDateObj.getTime())) {
                console.log("Invalid date format: " + addedDate);
                return; // Skip this item if the date is invalid
            }

            // Calculate the time difference in milliseconds between the current time and added time
            var timeDiff = currentDate - addedDateObj; // This gives the difference in milliseconds

            // Calculate hours and minutes from the time difference in milliseconds
            var hoursDiff = Math.floor(timeDiff / (1000 * 60 * 60)); // Calculate the full hours
            var minutesDiff = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60)); // Calculate the remaining minutes

            // Add the "New!" indicator if the item was added within the last 5 days
            var daysDiff = Math.floor(timeDiff / (1000 * 3600 * 24)); // Convert milliseconds to days
            if (daysDiff <= 5) {
                $(this).addClass('new-item'); // Add the "new-item" class

                // Check if the "New!" indicator is already appended to prevent duplicates
                if (!$(this).find('.new-indicator').length) {
                    // Add the "New!" indicator in the first column (Item Code)
                    var indicator = '<span class="new-indicator">New!</span>';
                    $(this).find('td:first').append(indicator); // Append "New!" next to the Item Code column
                }
            }

            // Add hover effect to show the time difference (including hours and minutes) when hovering over the "New!" label
            $(this).find('.new-indicator').hover(function() {
                // Format the time difference
                var elapsedTime = hoursDiff + " hours and " + minutesDiff + " minutes ago";

                // Set the "added_at" value as the tooltip text (this will show the time difference on hover)
                $(this).attr('title', 'Item added: ' + elapsedTime); // Show the time difference on hover
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
            var targetTab = $(this).data('target'); // data-target is an attribute set to target tab
            $('.tab-content').removeClass('active');
            $('#' + targetTab).addClass('active');
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Function to initialize DataTables for a specific table
        function initializeDataTable(tableId) {
            return $(tableId).DataTable({
                scrollY: '425px',
                scrollCollapse: true,
                paging: true,
                searching: true,
                ordering: true,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "pageLength": 10,
                // Sorting by the 'Arrival Date' or 'added_at' column in descending order (index 7)
                "order": [
                    [8, 'desc']
                ], // Change the index (7) if your column index is different for `added_at` or `Arrival Date`
                "initComplete": function(settings, json) {
                    $(tableId).css('font-size', '12px');
                    $(tableId + ' thead th').css('font-size', '10px');
                    $(tableId + ' tbody td').css('font-size', '10px');
                }
            });
        }

        // Initialize DataTables for each table
        var allItemsTable = initializeDataTable('#allItemsTable');
        var equipmentTable = initializeDataTable('#equipmentTable');
        var officeSuppliesTable = initializeDataTable('#officeSuppliesTable');
        var emergencyKitsTable = initializeDataTable('#emergencyKitsTable');
        var otherItemsTable = initializeDataTable('#otherItemsTable');
        var archivesTable = initializeDataTable('#archivesTable');

        // Hide all tables initially
        $('.tab-content').hide();

        // Function to switch tabs and initialize DataTable for the active tab
        function switchTab(tab) {
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

            // Reinitialize the DataTable for the newly displayed table
            switch (tab) {
                case 'all-items':
                    allItemsTable.ajax.reload();
                    break;
                case 'equipment':
                    equipmentTable.ajax.reload();
                    break;
                case 'office-supplies':
                    officeSuppliesTable.ajax.reload();
                    break;
                case 'emergency-kits':
                    emergencyKitsTable.ajax.reload();
                    break;
                case 'other-items':
                    otherItemsTable.ajax.reload();
                    break;
                case 'archives':
                    archivesTable.ajax.reload();
                    break;
            }

            // Remove 'active' class from all tab buttons and add 'active' class to the clicked tab
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            var activeTabButton = document.getElementById(tab + '-tab');
            if (activeTabButton) {
                activeTabButton.classList.add('active');
            }
        }

        // Initialize the first tab by default (you can change it to whichever tab you want to show first)
        switchTab('all-items');

        // Event listeners for tab switching
        $('#all-items-tab').click(function() {
            switchTab('all-items');
        });
        $('#equipment-tab').click(function() {
            switchTab('equipment');
        });
        $('#office-supplies-tab').click(function() {
            switchTab('office-supplies');
        });
        $('#emergency-kits-tab').click(function() {
            switchTab('emergency-kits');
        });
        $('#other-items-tab').click(function() {
            switchTab('other-items');
        });
        $('#archives-tab').click(function() {
            switchTab('archives');
        });
    });
</script>




<script>
$(document).ready(function() {
    $("#add-item-btn").click(function() {
        $("#addItemModal").removeClass("hidden");
    });

    $('#quantity').on('input', function() {
        var quantity = $(this).val();
        $("#saveButton").prop('disabled', quantity == 0 || quantity === "");
    });

    $('#storage_location').on('change', function() {
        $('#other_storage_location').toggleClass('hidden', $(this).val() !== 'Other');
    });

    $('#unit').on('change', function() {
        $('#other_unit').toggleClass('hidden', $(this).val() !== 'Other');
    });

    // Ensure the consumable checkbox updates the form value correctly
    $('#consumable').on('change', function() {
        // This updates the form data with '1' for checked and '0' for unchecked
        $('input[name="consumable"]').val($(this).is(':checked') ? '1' : '0');
    });

    // Handle form submission
    $("#itemForm").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        // Ensure essential fields are appended
        formData.append('name', $('#name').val());
        formData.append('brand', $('#brand').val());
        formData.append('unit', $('#unit').val());
        formData.append('category', $('#category').val());
        formData.append('status', 'Available');
        formData.append('consumable', $('#consumable').is(':checked') ? 1 : 0);  // This sends '1' for checked, '0' for unchecked
        formData.append('inventory_date', $('#inventory_date').val());

        // Handle conditional fields
        if ($('#unit').val() === 'Other') {
            formData.set('unit', $('#other_unit').val());
        }
        if ($('#storage_location').val() === 'Other') {
            formData.set('storage_location', $('#other_storage_location').val());
        }

        // NEW: Append optional fields
        formData.append('expiration_date', $('#expiration_date').val());
        formData.append('date_tested_inspected', $('#date_tested_inspected').val());

        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we save the item.',
            icon: 'info',
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: "{{ route('items.store') }}", // Ensure this is your correct store route URL
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Item saved successfully!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    willClose: () => location.reload() // Reload the page to reflect the new item
                });
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error saving the item.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Close the modal when the cancel button is clicked
    $("#cancelModal").click(function() {
        $("#addItemModal").addClass("hidden");
    });

    // Clear the form when the clear button is clicked
    $("#clearForm").click(function() {
        $('#itemForm').find('input[type="text"], input[type="number"], input[type="date"], input[type="file"], textarea').val('');
        $('#itemForm').find('select').prop('selectedIndex', 0);
        $('#other_unit, #other_storage_location').addClass('hidden').val('');
        $('#search-item').val('');
        $('#itemForm').find('input, select, textarea').prop('disabled', false);
    });

    // Remove the min/max validation for arrival date field
    $('#arrival_date').removeAttr('min max');
});

</script>

<SCRIPT>
    //ARCHIVES
    function archiveItem(itemId) {
    // Show the SweetAlert confirmation dialog for archiving
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this action!",
        icon: 'warning',
        showCancelButton: true, // Show the Cancel button
        confirmButtonText: 'Yes, archive it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true // Ensure the "No" button is on the right
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user clicked "Yes", proceed with archiving the item
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
        } else {
            // If the user clicked "No", do nothing and show a cancellation message
            Swal.fire({
                title: 'Cancelled',
                text: 'The item was not archived.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
    });
}

function restoreItem(itemId) {
    // Show the SweetAlert confirmation dialog for restoring
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to restore this item?",
        icon: 'warning',
        showCancelButton: true, // Show the Cancel button
        confirmButtonText: 'Yes, restore it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true // Ensure the "No" button is on the right
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user clicked "Yes", proceed with restoring the item
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
        } else {
            // If the user clicked "No", do nothing and show a cancellation message
            Swal.fire({
                title: 'Cancelled',
                text: 'The item was not restored.',
                icon: 'info',
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
        url: '/get-item/' + itemId,
        method: 'GET',
        success: function(item) {
            // Set today's date for max validation
            const today = new Date().toISOString().split('T')[0];

            // Populate the form fields with the item data
            $('#edit_item_id').val(item.id);
            $('#edit_item_name').val(item.name);
            $('#edit_category').val(item.category);
            $('#edit_quantity').val(item.quantity);
            $('#edit_unit').val(item.unit);
            $('#edit_description').val(item.description);
            $('#edit_storage_location').val(item.storage_location);
            $('#edit_arrival_date').val(item.arrival_date);
            $('#edit_status').val(item.status);

            // Populate new fields with the item data
            $('#edit_brand').val(item.brand);
            $('#edit_expiration_date').val(item.expiration_date);
            $('#edit_date_tested_inspected').val(item.date_tested_inspected);
            $('#edit_inventory_date').val(item.inventory_date);
            $('#edit_consumable').prop('checked', item.is_consumable); // Check if consumable

            // Set date constraints
            $('#edit_arrival_date').attr({
                'min': item.date_purchased,
                'max': today
            });

            // Set form action URL
            $('#editItemForm').attr('action', "/items/update/" + item.id);

            // Make fields editable
            $('#edit_item_name').attr('readonly', false);
            $('#edit_category').attr('disabled', false);
            $('#edit_unit').attr('disabled', false);
            $('#edit_description').attr('disabled', false);
            $('#edit_storage_location').attr('disabled', false);
            $('#edit_arrival_date').attr('disabled', false);
            $('#edit_status').attr('disabled', false);
            $('#edit_image').attr('disabled', false);
            $('#edit_brand').attr('disabled', false);
            $('#edit_expiration_date').attr('disabled', false);
            $('#edit_date_tested_inspected').attr('disabled', false);
            $('#edit_inventory_date').attr('disabled', false);
            $('#edit_consumable').attr('disabled', false);

            // Show the modal
            $('#editItemModal').removeClass('hidden');
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Error fetching item data. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

// Date validation for Edit Modal
$(document).ready(function() {
    // When arrival date changes in edit modal
    $('#edit_arrival_date').on('change', function() {
        const arrivalDate = $(this).val();
        const purchasedDate = $('#edit_date_purchased').val();

        if (purchasedDate && new Date(arrivalDate) < new Date(purchasedDate)) {
            Swal.fire({
                title: 'Invalid Date',
                text: 'Arrival Date cannot be earlier than the Date Purchased.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            $(this).val('');
        }
    });

    // When expiration date or tested date changes
    $('#edit_expiration_date, #edit_date_tested_inspected').on('change', function() {
        const expirationDate = $('#edit_expiration_date').val();
        const testedDate = $('#edit_date_tested_inspected').val();

        if (expirationDate && testedDate && new Date(expirationDate) < new Date(testedDate)) {
            Swal.fire({
                title: 'Invalid Date',
                text: 'Expiration Date cannot be earlier than the Date Tested/Inspected.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            $(this).val('');
        }
    });

    // Form submission handler with date validation
    $('#editItemForm').submit(function(e) {
        e.preventDefault();

        // Validate dates
        const arrivalDate = $("#edit_arrival_date").val();
        const purchasedDate = $("#edit_date_purchased").val();
        const expirationDate = $("#edit_expiration_date").val();
        const testedDate = $("#edit_date_tested_inspected").val();

        if (purchasedDate && arrivalDate && new Date(arrivalDate) < new Date(purchasedDate)) {
            Swal.fire({
                title: 'Error!',
                text: 'Arrival Date cannot be earlier than the Date Purchased.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }

        if (expirationDate && testedDate && new Date(expirationDate) < new Date(testedDate)) {
            Swal.fire({
                title: 'Error!',
                text: 'Expiration Date cannot be earlier than the Date Tested/Inspected.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        }

        // Show loading indicator
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait while we update the item.',
            icon: 'info',
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });

        // Submit the form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        willClose: () => {
                            $('#editItemModal').addClass('hidden');
                            updateItemRow(response.item);
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message || 'There was an issue updating the item.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Error updating item. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Cancel button handler
    $("#cancelEditModal").click(function() {
        $("#editItemModal").addClass("hidden");
    });
});
</script>

<script>
$(document).ready(function() {
    // When the item code is clicked
    $('#allItemsTable').on('click', 'td:nth-child(2)', function() {
        var itemCodePrefix = $(this).text().trim();  // Get the item code from the second column (Item Code)

        // Strip any extra text like "New!" from the item code
        itemCodePrefix = itemCodePrefix.replace(/[^A-Za-z0-9-]/g, '');  // Remove non-alphanumeric characters

        console.log("Clicked itemCode prefix:", itemCodePrefix);  // Log the clicked item code prefix

        // Fetch QR codes for the clicked item code prefix
        $.ajax({
            url: '/get-qr-codes/' + encodeURIComponent(itemCodePrefix),  // Pass the base item code prefix
            method: 'GET',
            success: function(data) {
                console.log("QR codes fetched:", data);  // Log the fetched QR codes

                if (data.length > 0) {
                    var qrListHtml = '<ul>';
                    var newlyAddedQrCodes = []; // To store newly added QR codes

                    // Loop through all fetched QR codes and identify the new ones
                    data.forEach(function(qrCode) {
                        // Check if the QR code is newly added by comparing with previously displayed codes
                        if (qrCode.includes(itemCodePrefix + '-04')) {
                            newlyAddedQrCodes.push(qrCode);  // Add to newly added list if it's the newly added QR code
                            qrListHtml += '<li style="color: green;">' + qrCode + ' (New)</li>';  // Highlight new QR code
                        } else {
                            qrListHtml += '<li>' + qrCode + '</li>';  // Normal QR code
                        }
                    });

                    qrListHtml += '</ul>';
                    
                    // Show the QR codes in a SweetAlert modal or overlay
                    Swal.fire({
                        title: 'QR Codes for ' + itemCodePrefix,
                        html: qrListHtml,  // Display the list of QR codes in the modal
                        icon: 'info'
                    });

                    // Log the newly added QR codes
                    if (newlyAddedQrCodes.length > 0) {
                        console.log("Newly Added QR Codes:", newlyAddedQrCodes);
                    }
                } else {
                    Swal.fire({
                        title: 'No QR Codes Found',
                        text: 'There are no QR codes for this item.',
                        icon: 'warning'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error',
                    text: 'Something went wrong. Please try again later.',
                    icon: 'error'
                });
            }
        });
    });
});
</script>



<!-- Modal Overlay for Adding Item -->
<div id="addItemModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50">
    <div class="relative z-10 flex items-center justify-center">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 90%; height: auto;">
            <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Item</h3>
                <form id="itemForm" action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Item Name -->
                            <div>
                                <label for="name" class="block text-xs font-medium text-gray-900">Item Name</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-xs font-medium text-gray-900">Category</label>
                                <select id="category" name="category" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                                    <option value="DRRM Equipment">DRRM Equipment</option>
                                    <option value="Office Supplies">Office Supplies</option>
                                    <option value="Emergency Kits">Emergency Kits</option>
                                    <option value="Other Items">Other Items</option>
                                </select>
                            </div>

                            <!-- Consumable Checkbox -->
                            <div class="col-span-2">
                                <input type="checkbox" id="consumable" name="consumable" value="1" class="form-checkbox">
                                <label for="consumable" class="text-xs font-medium text-gray-900">Consumable</label>
                                <!-- Hidden field to handle the unchecked state -->
                                <input type="hidden" name="consumable" value="0">
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-xs font-medium text-gray-900">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <!-- Unit -->
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

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-xs font-medium text-gray-900">Description</label>
                                <textarea id="description" name="description" rows="3" maxlength="250" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"></textarea>
                            </div>

                            <!-- Storage Location -->
                            <div>
                                <label for="storage_location" class="block text-xs font-medium text-gray-900">Storage Location</label>
                                <select id="storage_location" name="storage_location" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                                    <option value="Shelf A">Shelf A</option>
                                    <option value="Shelf B">Shelf B</option>
                                    <option value="Shelf C">Shelf C</option>
                                    <option value="Shelf D">Shelf D</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" id="other_storage_location" name="other_storage_location" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs hidden" maxlength="12" placeholder="Type other location here">
                            </div>

                            <!-- Arrival Date -->
                            <div>
                                <label for="arrival_date" class="block text-xs font-medium text-gray-900">Arrival Date</label>
                                <input type="date" id="arrival_date" name="arrival_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <!-- Inventory Date -->
                            <div>
                                <label for="inventory_date" class="block text-xs font-medium text-gray-900">Inventory Date</label>
                                <input type="date" id="inventory_date" name="inventory_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>

                            <!-- Image -->
                            <div>
                                <label for="image_url" class="block text-xs font-medium text-gray-900">Image</label>
                                <input type="file" id="image_url" name="image_url" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" accept="image/*">
                            </div>

                            <!-- Brand Field (New) -->
                            <div>
                                <label for="brand" class="block text-xs font-medium text-gray-900">Brand</label>
                                <input type="text" id="brand" name="brand" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <!-- Expiration Date (Optional) -->
                            <div>
                                <label for="expiration_date" class="block text-xs font-medium text-gray-900">Expiration Date (Optional)</label>
                                <input type="date" id="expiration_date" name="expiration_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>

                            <!-- Date Tested/Inspected -->
                            <div>
                                <label for="date_tested_inspected" class="block text-xs font-medium text-gray-900">Date Tested/Inspected (Optional)</label>
                                <input type="date" id="date_tested_inspected" name="date_tested_inspected" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
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


<!-- Edit Item Modal -->
<div id="editItemModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50">
    <div class="relative z-10 flex items-center justify-center">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 90%; height: auto;">
            <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Item</h3>

                <!-- Edit Item Form -->
                <form id="editItemForm" action="{{ route('items.update', ['id' => '__ID__']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Use PUT method for updates -->
                    <input type="hidden" id="edit_item_id" name="item_id">

                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Item Name -->
                            <div>
                                <label for="edit_item_name" class="block text-xs font-medium text-gray-900">Item Name</label>
                                <input type="text" id="edit_item_name" name="name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required readonly> <!-- readonly for non-editable -->
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="edit_category" class="block text-xs font-medium text-gray-900">Category</label>
                                <select id="edit_category" name="category" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" disabled>
                                    <option value="DRRM Equipment">DRRM Equipment</option>
                                    <option value="Office Supplies">Office Supplies</option>
                                    <option value="Emergency Kits">Emergency Kits</option>
                                    <option value="Other Items">Other Items</option>
                                </select>
                            </div>

                            <!-- Consumable Checkbox -->
                            <div>
                                <input type="checkbox" id="edit_consumable" name="consumable" value="1" class="form-checkbox">
                                <label for="edit_consumable" class="text-xs font-medium text-gray-900">Consumable</label>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="edit_quantity" class="block text-xs font-medium text-gray-900">Quantity</label>
                                <input type="number" id="edit_quantity" name="quantity" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <!-- Unit -->
                            <div>
                                <label for="edit_unit" class="block text-xs font-medium text-gray-900">Unit</label>
                                <input type="text" id="edit_unit" name="unit" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" disabled>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="edit_description" class="block text-xs font-medium text-gray-900">Description</label>
                                <textarea id="edit_description" name="description" rows="3" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" disabled></textarea>
                            </div>

                            <!-- Storage Location -->
                            <div>
                                <label for="edit_storage_location" class="block text-xs font-medium text-gray-900">Storage Location</label>
                                <input type="text" id="edit_storage_location" name="storage_location" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" disabled>
                            </div>

                            <!-- Arrival Date -->
                            <div>
                                <label for="edit_arrival_date" class="block text-xs font-medium text-gray-900">Arrival Date</label>
                                <input type="date" id="edit_arrival_date" name="arrival_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" disabled>
                            </div>

                            <!-- Inventory Date -->
                            <div>
                                <label for="edit_inventory_date" class="block text-xs font-medium text-gray-900">Inventory Date</label>
                                <input type="date" id="edit_inventory_date" name="inventory_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>

                            <!-- Image -->
                            <div>
                                <label for="edit_image" class="block text-xs font-medium text-gray-900">Image</label>
                                <input type="file" id="edit_image" name="image_url" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>

                            <!-- Brand and Status fields on the same line (2 columns) -->
                            <div>
                                <label for="edit_brand" class="block text-xs font-medium text-gray-900">Brand</label>
                                <input type="text" id="edit_brand" name="brand" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" required>
                            </div>

                            <div>
                                <label for="edit_status" class="block text-xs font-medium text-gray-900">Status</label>
                                <select id="edit_status" name="status" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                    <option value="Available">Available</option>
                                    <option value="Borrowed">Borrowed</option>
                                    <option value="Reserved">Reserved</option>
                                    <option value="Out Of Stock">Out of Stock</option>
                                    <option value="Needs Repair">Needs Repair</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Lost">Lost</option>
                                    <option value="Retired">Retired</option>
                                </select>
                            </div>

                            <!-- Expiration Date and Date Tested fields on the same line (2 columns) -->
                            <div>
                                <label for="edit_expiration_date" class="block text-xs font-medium text-gray-900">Expiration Date (Optional)</label>
                                <input type="date" id="edit_expiration_date" name="expiration_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                            </div>

                            <div>
                                <label for="edit_date_tested_inspected" class="block text-xs font-medium text-gray-900">Date Tested/Inspected (Optional)</label>
                                <input type="date" id="edit_date_tested_inspected" name="date_tested_inspected" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
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
