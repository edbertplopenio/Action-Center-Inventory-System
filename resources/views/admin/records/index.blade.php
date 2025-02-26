@extends('layouts.app')

@section('title', 'Records')

@section('content')

<head>
    <!-- Add Google Fonts link for Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">


    <!-- Include jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Apply font size and font family */
        body,
        #myTable {
            font-family: 'Intel', Arial, sans-serif;
            /* 'Intel' font or fallback fonts */
            font-size: 12px;
            /* Set font size to 11px */
        }

        #myTable {
            width: 100%;
            border-collapse: collapse;
            /* Remove space between table borders */
        }

        #myTable th,
        #myTable td {
            padding: 12px;
            text-align: center;

            /* Add borders */
        }

        #myTable th {
            position: sticky;
            top: 0;
            z-index: 1;
            color: black;
            background: white;
            /* Remove any background */
            text-align: center;
            /* Center the text */
            font-weight: bold;
            /* Make the text bold */

        }
    </style>
</head>

<div class="mx-auto p-2" style="width: 1220px; height: 660px; font-family: 'Inter', sans-serif;">
    <!-- Title and Button aligned horizontally with reduced margin and padding -->
    <div class="flex justify-between items-center mb-1 pt-0">
        <h1 class="text-3xl text-left">Records Page</h1>
        <button id="openModalBtn" class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 mb-2 text-sm">
    + Add Record
</button>

    </div>

    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <!-- Table for displaying records -->
        <div style="height: 600px; overflow-y: auto;"> <!-- Added overflow-y-auto -->
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Records Series Title</th>
                        <th>Related Documents</th>
                        <th>Period Covered</th>
                        <th>Volume</th>
                        <th>Records Medium</th>
                        <th>Location of Records</th>
                        <th>Time Value</th>
                        <th>Retention Period</th>
                        <th>Disposition Provision</th>
                        <th>GRDS Item #</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sample Record Series Title 1</td>
                        <td>Document A, Document B</td>
                        <td>2020-01-01 to 2020-12-31</td>
                        <td>100</td>
                        <td>Digital</td>
                        <td>Main Office</td>
                        <td>Permanent</td>
                        <td>Active</td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#84a59d] text-white rounded hover:bg-[#49A7D6] focus:outline-none focus:ring-2 focus:ring-[#84a59d] text-xs w-24">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <button class="px-2 py-1 m-1 bg-red-500 text-white rounded hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-red-400 text-xs w-24">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Sample Record Series Title 2</td>
                        <td>Document C</td>
                        <td>2021-01-01 to 2021-12-31</td>
                        <td>200</td>
                        <td>Physical</td>
                        <td>Branch Office</td>
                        <td>Temporary</td>
                        <td>Storage</td>
                        <td>Transfer to archive after 2 years</td>
                        <td>67890</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#54B6EB] text-white rounded hover:bg-[#49A7D6] focus:outline-none focus:ring-2 focus:ring-[#54B6EB] text-xs w-24">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <button class="px-2 py-1 m-1 bg-red-500 text-white rounded hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-red-400 text-xs w-24">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Sample Record Series Title 1</td>
                        <td>Document A, Document B</td>
                        <td>2020-01-01 to 2020-12-31</td>
                        <td>100</td>
                        <td>Digital</td>
                        <td>Main Office</td>
                        <td>Permanent</td>
                        <td>Active</td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#54B6EB] text-white rounded hover:bg-[#49A7D6] focus:outline-none focus:ring-2 focus:ring-[#54B6EB] text-xs w-24">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <button class="px-2 py-1 m-1 bg-red-500 text-white rounded hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-red-400 text-xs w-24">
                                Delete
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>Sample Record Series Title 1</td>
                        <td>Document A, Document B</td>
                        <td>2020-01-01 to 2020-12-31</td>
                        <td>100</td>
                        <td>Digital</td>
                        <td>Main Office</td>
                        <td>Permanent</td>
                        <td>Active</td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#54B6EB] text-white rounded hover:bg-[#49A7D6] focus:outline-none focus:ring-2 focus:ring-[#54B6EB] text-xs w-24">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <button class="px-2 py-1 m-1 bg-red-500 text-white rounded hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-red-400 text-xs w-24">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Sample Record Series Title 2</td>
                        <td>Document C</td>
                        <td>2021-01-01 to 2021-12-31</td>
                        <td>200</td>
                        <td>Physical</td>
                        <td>Branch Office</td>
                        <td>Temporary</td>
                        <td>Storage</td>
                        <td>Transfer to archive after 2 years</td>
                        <td>67890</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#54B6EB] text-white rounded hover:bg-[#49A7D6] focus:outline-none focus:ring-2 focus:ring-[#54B6EB] text-xs w-24">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <button class="px-2 py-1 m-1 bg-red-500 text-white rounded hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-red-400 text-xs w-24">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable(); // Initialize DataTable
    });
</script>



<!-- GAWIN MONG SROLLABLE YUNG DATA NG TABLE TBODY -->









<!-- MODAL -->
<!-- Modal Form HTML -->
<div class="relative z-10" id="myModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop with stronger blur effect -->
    <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-lg transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 70%; height: auto;">
                <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Add New Record</h3>

                    <!-- Modal Form HTML -->
                    <form>
                        <div class="space-y-6">
                            <div class="border-b border-gray-900/10 pb-6">
                                <p class="mt-1 text-xs text-gray-600">Please fill in the information about the record.</p>

                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                                    <!-- RECORDS SERIES TITLE AND DESCRIPTION -->
                                    <div class="sm:col-span-1">
                                        <label for="title" class="block text-xs font-medium text-gray-900">Records Series Title</label>
                                        <input type="text" name="title" id="title" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter Title and Description">
                                    </div>

                                    <!-- FREQUENCY OF USE -->
                                    <div class="sm:col-span-1">
                                        <label for="frequency" class="block text-xs font-medium text-gray-900">Frequency of Use</label>
                                        <select name="frequency" id="frequency" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="as_needed">As Needed</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="yearly">Yearly</option>
                                        </select>
                                    </div>

                                    <!-- RELATED DOCUMENTS -->
                                    <div class="sm:col-span-1">
                                        <label for="title" class="block text-xs font-medium text-gray-900">Related Documents</label>
                                        <input type="text" name="title" id="title" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter Title">
                                    </div>

                                    <!-- DUPLICATION -->
                                    <div class="sm:col-span-1">
                                        <label for="duplication" class="block text-xs font-medium text-gray-900">Duplication</label>
                                        <input type="text" name="duplication" id="duplication" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter duplication details">
                                    </div>

                                    <!-- PERIOD COVERED / INCLUSIVE DATES (Split into two date fields) -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-xs font-medium text-gray-900">Period Covered</label>
                                        <div class="flex space-x-4">
                                            <input type="date" name="start_date" id="start_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <input type="date" name="end_date" id="end_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                        </div>
                                    </div>

                                    <!-- TIME VALUE (T/P) -->
                                    <div class="sm:col-span-1">
                                        <label for="time_value" class="block text-xs font-medium text-gray-900">Time Value</label>
                                        <select name="time_value" id="time_value" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="T">Temporary</option>
                                            <option value="P">Permanent</option>
                                        </select>
                                    </div>


                                    <!-- VOLUME -->
                                    <div class="sm:col-span-1">
                                        <label for="volume" class="block text-xs font-medium text-gray-900">Volume</label>
                                        <input type="number" name="volume" id="volume" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter volume">
                                    </div>

                                    <!-- UTILITY VALUE (Adm/F/L/A, Multiple Selections, 4 Columns for Checkboxes) -->
                                    <div class="sm:col-span-1">
                                        <label for="utility_value" class="block text-xs font-medium text-gray-900">Utility Value</label>
                                        <div class="grid grid-cols-4 gap-4 mt-2">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="adm" name="utility_value[]" value="Adm" class="w-4 h-4 mr-2">
                                                <label for="adm" class="text-xs">Administrative</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="fiscal" name="utility_value[]" value="F" class="w-4 h-4 mr-2">
                                                <label for="fiscal" class="text-xs">Fiscal</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="legal" name="utility_value[]" value="L" class="w-4 h-4 mr-2">
                                                <label for="legal" class="text-xs">Legal</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="archival" name="utility_value[]" value="A" class="w-4 h-4 mr-2">
                                                <label for="archival" class="text-xs">Archival</label>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- RECORDS MEDIUM -->
                                    <div class="sm:col-span-1">
                                        <label for="medium" class="block text-xs font-medium text-gray-900">Records Medium</label>
                                        <select name="medium" id="medium" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="paper">Paper</option>
                                            <option value="electronic">Electronic</option>
                                        </select>
                                    </div>

                                    <!-- RETENTION PERIOD (Active, Storage, Total) -->
                                    <div class="sm:col-span-1">
                                        <label for="retention" class="block text-xs font-medium text-gray-900">Retention Period</label>
                                        <div class="grid grid-cols-3 gap-4 mt-2">
                                            <!-- Active Input -->
                                            <div class="flex flex-col items-center">
                                                <label for="active" class="text-xs mb-1">Active</label>
                                                <input type="number" name="active" id="active" class="w-16 py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="0 or 1" min="0" max="1" onchange="calculateTotal()">
                                            </div>

                                            <!-- Storage Input -->
                                            <div class="flex flex-col items-center">
                                                <label for="storage" class="text-xs mb-1">Storage</label>
                                                <input type="number" name="storage" id="storage" class="w-16 py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="0 or 1" min="0" max="1" onchange="calculateTotal()">
                                            </div>

                                            <!-- Total -->
                                            <div class="flex flex-col items-center">
                                                <label for="total" class="text-xs mb-1">Total</label>
                                                <input type="text" name="total" id="total" class="w-16 py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Total" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        // Function to calculate the total
                                        function calculateTotal() {
                                            var active = parseInt(document.getElementById('active').value) || 0;
                                            var storage = parseInt(document.getElementById('storage').value) || 0;
                                            var total = active + storage;

                                            document.getElementById('total').value = total; // Set the total field
                                        }
                                    </script>


                                    <!-- RESTRICTION/S -->
                                    <div class="sm:col-span-1">
                                        <label for="restriction" class="block text-xs font-medium text-gray-900">Restriction/S</label>
                                        <select name="restriction" id="restriction" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="open-access">Open Access</option>
                                            <option value="confidential">Confidential</option>
                                        </select>
                                    </div>


                                    <!-- DISPOSITION PROVISION -->
                                    <div class="sm:col-span-1">
                                        <label for="disposition" class="block text-xs font-medium text-gray-900">Disposition Provision</label>
                                        <input type="text" name="disposition" id="disposition" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter disposition provision">
                                    </div>

                                    <!-- LOCATION OF RECORDS -->
                                    <div class="sm:col-span-1">
                                        <label for="location" class="block text-xs font-medium text-gray-900">Location of Records</label>
                                        <input type="text" name="location" id="location" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter location">
                                    </div>

                                    <!-- GRDS ITEM # -->
                                    <div class="sm:col-span-1">
                                        <label for="grds_item" class="block text-xs font-medium text-gray-900">GRDS Item #</label>
                                        <input type="text" name="grds_item" id="grds_item" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter GRDS item number">
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <button type="button" class="text-xs font-semibold text-gray-900" id="closeModalBtn">Cancel</button>
                                <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-xs hover:bg-blue-500">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- JavaScript for opening and closing the modal -->
<script>
    // Open the modal
    document.getElementById('openModalBtn').addEventListener('click', function() {
        document.getElementById('myModal').style.display = 'block';
    });

    // Close the modal
    document.getElementById('closeModalBtn').addEventListener('click', function() {
        document.getElementById('myModal').style.display = 'none';
    });

    // Close modal when clicking outside the modal
    document.querySelector('.fixed.inset-0').addEventListener('click', function() {
        document.getElementById('myModal').style.display = 'none';
    });
</script>
@endsection