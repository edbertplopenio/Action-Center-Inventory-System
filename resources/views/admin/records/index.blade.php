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
            font-family: 'Inter', Arial, sans-serif;
            font-size: 12px;
        }

        /* Table Styling */
        #myTable {
            width: 100%;
            border-collapse: collapse;
        }

        /* Table Header Styling */
        #myTable th {
            background-color: #EBF8FD;
            color: #4a5568;
            font-weight: 600;
            text-align: center;
            padding: 15px;
            border-bottom: 2px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        /* Table Data Styling */
        #myTable td {
            background-color: #ffffff;
            color: #2d3748;
            text-align: center;
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Add hover effect for rows */
        #myTable tr:hover {
            background-color: #b3eaff;
        }
    </style>
</head>

<div class="mx-auto p-2" style="width: 1220px; height: 700px; font-family: 'Inter', sans-serif;">
    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <!-- Title and Button inside this div -->
        <div class="flex justify-between items-center mb-1 pt-0">
            <h1 class="text-3xl text-left">Records and Appraisal</h1>
            <button id="openModalBtn" class="px-6 py-2 bg-[#4cc9f0] text-white border-2 border-[#4cc9f0] rounded-full hover:bg-[#3fb3d1] mb-2 text-sm">
                + Add Record
            </button>
        </div>

        <!-- Table for displaying records -->
        <div style="height: 600px; overflow-y: auto;">
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
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24 editModalBtn">
                                Edit
                            </button>
                            <!-- Archive Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#57cc99] text-white rounded hover:bg-[#45a17e] focus:outline-none focus:ring-2 focus:ring-[#57cc99] text-xs w-24">
                                Archive
                            </button>
                        </td>
                    </tr>
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
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24 editModalBtn">
                                Edit
                            </button>



                            <!-- Archive Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#57cc99] text-white rounded hover:bg-[#45a17e] focus:outline-none focus:ring-2 focus:ring-[#57cc99] text-xs w-24">
                                Archive
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
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24 editModalBtn">
                                Edit
                            </button>



                            <!-- Archive Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#57cc99] text-white rounded hover:bg-[#45a17e] focus:outline-none focus:ring-2 focus:ring-[#57cc99] text-xs w-24">
                                Archive
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
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24 editModalBtn">
                                Edit
                            </button>

                            <!-- Archive Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#57cc99] text-white rounded hover:bg-[#45a17e] focus:outline-none focus:ring-2 focus:ring-[#57cc99] text-xs w-24">
                                Archive
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
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24 editModalBtn">
                                Edit
                            </button>



                            <!-- Archive Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#57cc99] text-white rounded hover:bg-[#45a17e] focus:outline-none focus:ring-2 focus:ring-[#57cc99] text-xs w-24">
                                Archive
                            </button>
                        </td>
                    </tr>
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


<!-- Modal for Add Record -->
<div class="relative z-10" id="addRecordModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
    <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-lg transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 70%; height: auto;">
                <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Add New Record</h3>
                    <form>
                        <div class="space-y-6">
                            <div class="border-b border-gray-900/10 pb-6">
                                <p class="mt-1 text-xs text-gray-600">Please fill in the information about the record.</p>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <label for="title" class="block text-xs font-medium text-gray-900">Records Series Title</label>
                                        <input type="text" name="title" id="title" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter Title and Description">
                                    </div>
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
                                        <label for="edittime_value" class="block text-xs font-medium text-gray-900">Time Value</label>
                                        <select name="time_value" id="edittime_value" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
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
                                            <option value="Digital">Digital</option>
                                            <option value="Physical">Physical</option>
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

                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <button type="button" class="text-xs font-semibold text-gray-900" id="closeAddModalBtn">Cancel</button>
                                <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-xs hover:bg-blue-500">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Edit Record -->
<div class="relative z-10" id="editRecordModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
    <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-lg transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 70%; height: auto;">
                <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Edit Record</h3>
                    <form>
                        <div class="space-y-6">
                            <div class="border-b border-gray-900/10 pb-6">
                                <p class="mt-1 text-xs text-gray-600">Please fill in the information about the record.</p>
                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">

                                
                                    <!-- Fields for Edit Record Modal -->
                                    <div class="sm:col-span-1">
                                        <label for="editTitle" class="block text-xs font-medium text-gray-900">Records Series Title</label>
                                        <input type="text" name="title" id="editTitle" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter Title and Description">
                                    </div>


                                    <div class="sm:col-span-1">
                                        <label for="editFrequency" class="block text-xs font-medium text-gray-900">Frequency of Use</label>
                                        <select name="frequency" id="editFrequency" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="as_needed">As Needed</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="yearly">Yearly</option>
                                        </select>
                                    </div>


                                    <!-- Related Documents -->
                                    <div class="sm:col-span-1">
                                        <label for="editDocuments" class="block text-xs font-medium text-gray-900">Related Documents</label>
                                        <input type="text" name="documents" id="editDocuments" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter Title">
                                    </div>


                                    <!-- Duplication -->
                                    <div class="sm:col-span-1">
                                        <label for="editDuplication" class="block text-xs font-medium text-gray-900">Duplication</label>
                                        <input type="text" name="duplication" id="editDuplication" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter duplication details">
                                    </div>


                                    <!-- Period Covered / Inclusive Dates -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-xs font-medium text-gray-900">Period Covered</label>
                                        <div class="flex space-x-4">
                                            <input type="date" name="start_date" id="editStartDate" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <input type="date" name="end_date" id="editEndDate" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                        </div>
                                    </div>

                                    <!-- TIME VALUE -->
                                    <div class="sm:col-span-1">
                                        <label for="editTimeValue" class="block text-xs font-medium text-gray-900">Time Value</label>
                                        <select name="time_value" id="editTimeValue" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="Temporary">Temporary</option>
                                            <option value="Permanent">Permanent</option>
                                        </select>
                                    </div>



                                    <!-- Volume -->
                                    <div class="sm:col-span-1">
                                        <label for="editVolume" class="block text-xs font-medium text-gray-900">Volume</label>
                                        <input type="number" name="volume" id="editVolume" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter volume">
                                    </div>


                                    <!-- UTILITY VALUE (Adm/F/L/A, Multiple Selections, 4 Columns for Checkboxes) -->
                                    <div class="sm:col-span-1">
                                        <label for="editUtilityValue" class="block text-xs font-medium text-gray-900">Utility Value</label>
                                        <div class="grid grid-cols-4 gap-4 mt-2">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="editAdm" name="utility_value[]" value="Adm" class="w-4 h-4 mr-2">
                                                <label for="editAdm" class="text-xs">Administrative</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="editFiscal" name="utility_value[]" value="F" class="w-4 h-4 mr-2">
                                                <label for="editFiscal" class="text-xs">Fiscal</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="editLegal" name="utility_value[]" value="L" class="w-4 h-4 mr-2">
                                                <label for="editLegal" class="text-xs">Legal</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="editArchival" name="utility_value[]" value="A" class="w-4 h-4 mr-2">
                                                <label for="editArchival" class="text-xs">Archival</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- RECORDS MEDIUM -->
                                    <div class="sm:col-span-1">
                                        <label for="editmedium" class="block text-xs font-medium text-gray-900">Records Medium</label>
                                        <select name="medium" id="editmedium" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="Digital">Digital</option>
                                            <option value="Physical">Physical</option>
                                        </select>
                                    </div>


                                    <!-- Retention Period -->
                                    <div class="sm:col-span-1">
                                        <label for="editRetention" class="block text-xs font-medium text-gray-900">Retention Period</label>
                                        <div class="grid grid-cols-3 gap-4 mt-2">
                                            <div class="flex flex-col items-center">
                                                <label for="editActive" class="text-xs mb-1">Active</label>
                                                <input type="number" name="active" id="editActive" class="w-16 py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="0 or 1" min="0" max="1" onchange="calculateTotal()">
                                            </div>
                                            <div class="flex flex-col items-center">
                                                <label for="editStorage" class="text-xs mb-1">Storage</label>
                                                <input type="number" name="storage" id="editStorage" class="w-16 py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="0 or 1" min="0" max="1" onchange="calculateTotal()">
                                            </div>
                                            <div class="flex flex-col items-center">
                                                <label for="editTotal" class="text-xs mb-1">Total</label>
                                                <input type="text" name="total" id="editTotal" class="w-16 py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Total" readonly>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Restriction -->
                                    <div class="sm:col-span-1">
                                        <label for="editRestriction" class="block text-xs font-medium text-gray-900">Restriction/S</label>
                                        <select name="restriction" id="editRestriction" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="open-access">Open Access</option>
                                            <option value="confidential">Confidential</option>
                                        </select>
                                    </div>


                                    <!-- Disposition Provision -->
                                    <div class="sm:col-span-1">
                                        <label for="editDisposition" class="block text-xs font-medium text-gray-900">Disposition Provision</label>
                                        <input type="text" name="disposition" id="editDisposition" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter disposition provision">
                                    </div>


                                    <!-- Location of Records -->
                                    <div class="sm:col-span-1">
                                        <label for="editLocation" class="block text-xs font-medium text-gray-900">Location of Records</label>
                                        <input type="text" name="location" id="editLocation" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter location">
                                    </div>


                                    <!-- GRDS Item # -->
                                    <div class="sm:col-span-1">
                                        <label for="editGrdsItem" class="block text-xs font-medium text-gray-900">GRDS Item #</label>
                                        <input type="text" name="grds_item" id="editGrdsItem" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter GRDS item number">
                                    </div>
                                </div>
                            </div>
                            <!-- Action Buttons -->
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <button type="button" class="text-xs font-semibold text-gray-900" id="closeEditModalBtn">Cancel</button>
                                <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-xs hover:bg-blue-500">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {

// Open Edit Record modal with proper event delegation
$(document).on('click', '.editModalBtn', function() {

    // Populate modal inputs from table row
    $('#editTitle').val(row.find('td').eq(0).text());
    $('#editDocuments').val(row.find('td').eq(1).text());

    var period = row.find('td').eq(2).text().split(' to ');
    $('#editStartDate').val(period[0]);
    $('#editEndDate').val(period[1]);

    $('#editVolume').val(row.find('td').eq(3).text());
    $('#editmedium').val(row.find('td').eq(4).text());
    $('#editLocation').val(row.find('td').eq(5).text());
    $('#editTimeValue').val(row.find('td').eq(6).text());
    $('#editUtilityValue').val(row.find('td').eq(7).text());
    $('#editDisposition').val(row.find('td').eq(8).text());
    $('#editGrdsItem').val(row.find('td').eq(9).text());
    $('#editDuplication').val(row.find('td').eq(10).text());

    // Reset and populate retention checkboxes
    $('input[name="retention"]').prop('checked', false);
    var retentionValues = row.find('td').eq(7).text().split(',');
    retentionValues.forEach(function(value) {
        $('#edit' + value.trim()).prop('checked', true);
    });

    $('#editRecordModal').show();
});

// Save edits and update table row correctly
$('#saveEditBtn').on('click', function() {
    var row = $('tr.editing');

    row.find('td').eq(0).text($('#editTitle').val());
    row.find('td').eq(1).text($('#editDocuments').val());
    row.find('td').eq(2).text($('#editStartDate').val() + ' to ' + $('#editEndDate').val());
    row.find('td').eq(3).text($('#editVolume').val());
    row.find('td').eq(4).text($('#editmedium').val());
    row.find('td').eq(5).text($('#editLocation').val());
    row.find('td').eq(6).text($('#editTimeValue').val());
    row.find('td').eq(7).text($('#editUtilityValue').val());
    row.find('td').eq(8).text($('#editDisposition').val());
    row.find('td').eq(9).text($('#editGrdsItem').val());
    row.find('td').eq(10).text($('#editDuplication').val());

    row.removeClass('editing');
    $('#editRecordModal').hide();
});

// Close the Edit Record modal
$('#closeEditModalBtn').on('click', function() {
    $('tr.editing').removeClass('editing');
    $('#editRecordModal').hide();
});

// Open Add Record modal
$('#openModalBtn').on('click', function() {
    $('#addRecordModal').show();
});

// Close Add Record modal
$('#closeAddModalBtn').on('click', function() {
    $('#addRecordModal').hide();
});

});
</script>

@endsection