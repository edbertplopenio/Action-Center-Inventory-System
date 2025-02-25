@extends('layouts.app')

@section('title', 'Records')

@section('content')
<div class="mx-auto p-6" style="width: 1220px; height: 670px;">
    <!-- Title and Button aligned horizontally -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold text-left">Records Page</h1>
        <button id="openModalBtn" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            + Add New Record
        </button>
    </div>

    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <!-- Table for displaying records -->
        <div class="overflow-x-auto h-[calc(100%-120px)]"> <!-- Adjusting table height -->
            <table id="recordsTable" class="min-w-full table-auto bg-white border border-gray-300 shadow-sm rounded-lg">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left text-gray-600">Record ID</th>
                        <th class="px-4 py-2 text-left text-gray-600">Name</th>
                        <th class="px-4 py-2 text-left text-gray-600">Email</th>
                        <th class="px-4 py-2 text-left text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample record row -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-700">1</td>
                        <td class="px-4 py-2 text-gray-700">John Doe</td>
                        <td class="px-4 py-2 text-gray-700">john.doe@example.com</td>
                        <td class="px-4 py-2 text-gray-700">Active</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-700">2</td>
                        <td class="px-4 py-2 text-gray-700">Jane Smith</td>
                        <td class="px-4 py-2 text-gray-700">jane.smith@example.com</td>
                        <td class="px-4 py-2 text-gray-700">Inactive</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form HTML -->
<div class="relative z-10" id="myModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full" style="max-width: 70%; height: auto;">
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
                                        <label class="block text-xs font-medium text-gray-900">Period Covered / Inclusive Dates</label>
                                        <div class="flex space-x-4">
                                            <input type="date" name="start_date" id="start_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <input type="date" name="end_date" id="end_date" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                        </div>
                                    </div>

                                    <!-- TIME VALUE (T/P) -->
                                    <div class="sm:col-span-1">
                                        <label for="time_value" class="block text-xs font-medium text-gray-900">Time Value (T/P)</label>
                                        <select name="time_value" id="time_value" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="T">T</option>
                                            <option value="P">P</option>
                                        </select>
                                    </div>

                                    <!-- VOLUME -->
                                    <div class="sm:col-span-1">
                                        <label for="volume" class="block text-xs font-medium text-gray-900">Volume</label>
                                        <input type="number" name="volume" id="volume" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter volume">
                                    </div>

                                    <!-- UTILITY VALUE (Adm/F/L/A, Multiple Selections, Horizontal Alignment with Bigger Checkboxes) -->
                                    <!-- UTILITY VALUE (Adm/F/L/A, Multiple Selections, 4 Columns for Checkboxes) -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-xs font-medium text-gray-900">Utility Value (Adm/F/L/A)</label>
                                        <div class="grid grid-cols-4 gap-4 mt-2">
                                            <div class="flex items-center">
                                                <input type="checkbox" id="adm" name="utility_value" value="Adm" class="w-4 h-4 mr-2">
                                                <label for="adm" class="text-xs">Adm</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="f" name="utility_value" value="F" class="w-4 h-4 mr-2">
                                                <label for="f" class="text-xs">F</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="l" name="utility_value" value="L" class="w-4 h-4 mr-2">
                                                <label for="l" class="text-xs">L</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="checkbox" id="a" name="utility_value" value="A" class="w-4 h-4 mr-2">
                                                <label for="a" class="text-xs">A</label>
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
                                        <label for="retention" class="block text-xs font-medium text-gray-900">Retention Period (Active, Storage, Total)</label>
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
                                        <input type="text" name="restriction" id="restriction" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter restrictions">
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

