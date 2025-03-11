@extends('layouts.app')

@section('title', 'Records')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Add Google Fonts link for Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <!-- Include jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    <!-- Added scrollbar in the tbody -->
    <style>
        /* Apply font size and font family */
        body,
        #myTable {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        table.dataTable thead th {
            text-align: center;
        }



        /* Table Header Styling */
        #myTable th {
            background-color: #EBF8FD;
            color: #4a5568;
            font-weight: 600;
            text-align: center;
            padding: 15px;
            border-bottom: 2px solid #e2e8f0;
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

        /* Scrollable tbody */
        .dataTables_scrollBody {
            max-height: 400px;
            /* Adjust height as needed */
            overflow-y: auto;
        }
    </style>



    <!-- <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "scrollY": false,  // Disable vertical scrolling
            "scrollX": false,  // Disable horizontal scrolling
            "paging": true,    // Enable pagination (optional)
            "searching": true, // Enable search (optional)
            "ordering": true   // Enable sorting (optional)
        });
    });
</script> -->



    <!-- CSS for Pagination -->
    <style>
        /* Style the container */
        .dataTables_length {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #5ad4f5;
            /* Lighter shade of #4cc9f0 */
            margin-bottom: 6px;
            padding: 4px 8px;
            background-color: #e6f7ff;
            /* Light blue background */
            border-radius: 6px;
            border: 1px solid #b3eaff;
            /* Soft blue border */
        }

        /* Style the dropdown select */
        .dt-length select {
            padding: 4px 8px;
            border: 1px solid #b3eaff;
            /* Soft blue border */
            border-radius: 4px;
            background-color: #ffffff;
            /* White dropdown background */
            color: #4aaed4;
            /* Slightly darker text */
            font-size: 12px;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease-in-out;
        }

        /* Hover and Focus Effects */
        .dt-length select:hover {
            border-color: #87dff7;
            /* Brighter blue */
            background-color: #def3ff;
            /* Slightly darker background */
        }

        .dt-length select:focus {
            border-color: #4cc9f0;
            box-shadow: 0 0 3px rgba(76, 201, 240, 0.4);
            background-color: #c9efff;
        }

        /* Style the label */
        .dt-length label {
            font-weight: 500;
            color: rgb(0, 0, 0);
            /* Primary blue shade */
        }
    </style>


    <!-- CSS for Search Bar -->
    <style>
        /* Style the search container */
        .dt-search {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
        }

        /* Style the search input */
        .dt-search input[type="search"] {
            padding: 4px 8px;
            border: 1px solid #b3eaff;
            /* Soft blue border */
            border-radius: 4px;
            background-color: #ffffff;
            /* White input background */
            color: #4aaed4;
            /* Slightly darker text */
            font-size: 12px;
            cursor: text;
            outline: none;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        /* Keep only focus effect */
        .dt-search input[type="search"]:focus {
            border-color: #4cc9f0;
            box-shadow: 0 0 3px rgba(76, 201, 240, 0.4);
            background-color: #c9efff;
        }

        /* Style the label */
        .dt-search label {
            font-weight: 500;
            color: rgb(0, 0, 0);
            /* Primary blue shade */
        }
    </style>







</head>

<div class="mx-auto p-2" style="width: 1220px; height: 700px; font-family: 'Inter', sans-serif;">


    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <!-- Title and Button inside this div -->
        <div class="flex justify-between items-center mb-1 pt-0">
            <h1 class="text-3xl text-left">Records and Appraisal</h1>
            <div class="flex space-x-2 w-auto">
                <button id="openModalBtn" class="px-6 py-2 min-w-[140px] max-w-[160px] bg-[#4cc9f0] text-white border-2 border-[#4cc9f0] rounded-full hover:bg-[#3fb3d1] mb-2 text-sm">
                    Add Record
                </button>
                <a href="{{ route('records.archive') }}">
                    <button class="px-6 py-2 min-w-[140px] max-w-[160px] bg-[#f0b84c] text-white border-2 border-[#f0b84c] rounded-full hover:bg-[#d19b3f] mb-2 text-sm">
                        Archive
                    </button>
                </a>

            </div>
        </div>


        <!-- Table for displaying users -->
        <div style="height: 600px; overflow-y: auto;"> <!-- Added overflow-y-auto -->
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Department</th>
                        <th>Cellphone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>johndoe@example.com</td>
                        <td>Admin</td>
                        <td>Active</td>
                        <td>IT Department</td>
                        <td>09123456789</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
                                Edit
                            </button>

                            <!-- Deactivate/Activate Button -->
                            <button class="px-2 py-1 m-1 bg-[#f0b84c] text-white rounded hover:bg-[#d19b3f] focus:outline-none focus:ring-2 focus:ring-[#f0b84c] text-xs w-24">
                                Deactivate
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>janesmith@example.com</td>
                        <td>Borrower</td>
                        <td>Inactive</td>
                        <td>Library Services</td>
                        <td>09234567890</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
                                Edit
                            </button>

                            <!-- Activate Button -->
                            <button class="px-2 py-1 m-1 bg-[#57cc99] text-white rounded hover:bg-[#45a17e] focus:outline-none focus:ring-2 focus:ring-[#57cc99] text-xs w-24">
                                Activate
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>




<!-- Edit Record Modal -->
<div class="relative z-10" id="editRecordModal" aria-labelledby="editRecordModalTitle" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop with stronger blur effect -->
    <div class="fixed inset-0 bg-black/50 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 90%; height: auto;">
                <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="editRecordModalTitle">Edit Record</h3>

                    <!-- Modal Form HTML -->
                    <form id="editRecordForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div class="border-b border-gray-900/10 pb-6">
                                <p class="mt-1 text-xs text-gray-600">Please fill in the information about the record.</p>

                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                                    <!-- RECORDS SERIES TITLE AND DESCRIPTION -->
                                    <div class="sm:col-span-1">
                                        <label for="editTitle" class="block text-xs font-medium text-gray-900">Records Series Title</label>
                                        <input
                                            type="text"
                                            name="title"
                                            id="editTitle"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"
                                            placeholder="Enter Title and Description">
                                    </div>

                                    <!-- FREQUENCY OF USE -->
                                    <div class="sm:col-span-1">
                                        <label for="editFrequency" class="block text-xs font-medium text-gray-900">Frequency of Use</label>
                                        <select
                                            name="frequency"
                                            id="editFrequency"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="as_needed">As Needed</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="yearly">Yearly</option>
                                        </select>
                                    </div>

                                    <!-- RELATED DOCUMENTS -->
                                    <div class="sm:col-span-1">
                                        <label for="editRelatedDocuments" class="block text-xs font-medium text-gray-900">Related Documents</label>
                                        <input
                                            type="text"
                                            name="related_documents"
                                            id="editRelatedDocuments"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"
                                            placeholder="Enter Related Documents">
                                    </div>

                                    <!-- DUPLICATION -->
                                    <div class="sm:col-span-1">
                                        <label for="editDuplication" class="block text-xs font-medium text-gray-900">Duplication</label>
                                        <input
                                            type="text"
                                            name="duplication"
                                            id="editDuplication"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"
                                            placeholder="Enter duplication details">
                                    </div>

                                    <!-- PERIOD COVERED / INCLUSIVE DATES -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-xs font-medium text-gray-900" for="editStartYear">Period Covered</label>
                                        <div class="flex space-x-4">
                                            <!-- START YEAR DROPDOWN -->
                                            <select
                                                name="start_year"
                                                id="editStartYear"
                                                class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                                <option value="">-- Select Start Year --</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                                <option value="2000">2000</option>
                                                <!-- etc. -->
                                            </select>

                                            <!-- END YEAR DROPDOWN -->
                                            <select
                                                name="end_year"
                                                id="editEndYear"
                                                class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                                <option value="">-- Select End Year --</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                                <option value="2000">2000</option>
                                                <!-- etc. -->
                                            </select>
                                        </div>
                                    </div>

                                    <!-- TIME VALUE (T/P) -->
                                    <div class="sm:col-span-1">
                                        <label for="editTimeValue" class="block text-xs font-medium text-gray-900">Time Value</label>
                                        <select
                                            name="time_value"
                                            id="editTimeValue"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="T">Temporary</option>
                                            <option value="P">Permanent</option>
                                        </select>
                                    </div>

                                    <!-- VOLUME -->
                                    <div class="sm:col-span-1">
                                        <label for="editVolume" class="block text-xs font-medium text-gray-900">Volume</label>
                                        <input
                                            type="text"
                                            name="volume"
                                            id="editVolume"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"
                                            placeholder="Enter volume">
                                    </div>

                                    <!-- UTILITY VALUE (Adm/F/L/A) -->
                                    <div class="sm:col-span-1">
                                        <label class="block text-xs font-medium text-gray-900">Utility Value</label>
                                        <div class="grid grid-cols-4 gap-4 mt-2">
                                            <div class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    id="editAdm"
                                                    name="utility_value[]"
                                                    value="Adm"
                                                    class="w-4 h-4 mr-2">
                                                <label for="editAdm" class="text-xs">Admin</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    id="editFiscal"
                                                    name="utility_value[]"
                                                    value="F"
                                                    class="w-4 h-4 mr-2">
                                                <label for="editFiscal" class="text-xs">Fiscal</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    id="editLegal"
                                                    name="utility_value[]"
                                                    value="L"
                                                    class="w-4 h-4 mr-2">
                                                <label for="editLegal" class="text-xs">Legal</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    id="editArchival"
                                                    name="utility_value[]"
                                                    value="A"
                                                    class="w-4 h-4 mr-2">
                                                <label for="editArchival" class="text-xs">Archival</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- RECORDS MEDIUM -->
                                    <div class="sm:col-span-1">
                                        <label for="editMedium" class="block text-xs font-medium text-gray-900">Records Medium</label>
                                        <select
                                            name="medium"
                                            id="editMedium"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="paper">Paper</option>
                                            <option value="electronic">Electronic</option>
                                        </select>
                                    </div>

                                    <!-- RETENTION PERIOD (Active, Storage, Permanent) -->
                                    <div class="sm:col-span-1">
                                        <label for="editActive" class="block text-xs font-medium text-gray-900">
                                            Retention Period
                                        </label>
                                        <div class="grid grid-cols-3 gap-6 mt-2 items-center">
                                            <!-- Active Retention Period -->
                                            <div class="flex flex-col items-center">
                                                <label class="text-xs mb-1">Active</label>
                                                <div class="flex space-x-2">
                                                    <input
                                                        type="number"
                                                        id="editActive"
                                                        name="active"
                                                        class="w-14 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs text-center"
                                                        min="0">
                                                    <select
                                                        id="editActiveUnit"
                                                        name="active_unit"
                                                        class="py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                                        <option value="years">Years</option>
                                                        <option value="months">Months</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Storage Retention Period -->
                                            <div class="flex flex-col items-center">
                                                <label class="text-xs mb-1">Storage</label>
                                                <div class="flex space-x-2">
                                                    <input
                                                        type="number"
                                                        id="editStorage"
                                                        name="storage"
                                                        class="w-14 py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs text-center"
                                                        min="0">
                                                    <select
                                                        id="editStorageUnit"
                                                        name="storage_unit"
                                                        class="py-1 px-2 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                                        <option value="years">Years</option>
                                                        <option value="months">Months</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Permanent Checkbox -->
                                            <div class="flex flex-col items-center">
                                                <label class="text-xs mb-1">Permanent</label>
                                                <div class="flex justify-center">
                                                    <input
                                                        type="checkbox"
                                                        id="editPermanent"
                                                        name="permanent"
                                                        value="1"
                                                        class="w-6 h-6 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs text-center"
                                                        onchange="toggleEditPermanent()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        // Update retention units based on user input
                                        document.addEventListener("DOMContentLoaded", function() {
                                            function updateRetentionUnits() {
                                                let activeField = document.getElementById("editActive");
                                                let storageField = document.getElementById("editStorage");
                                                let activeUnit = document.getElementById("editActiveUnit");
                                                let storageUnit = document.getElementById("editStorageUnit");

                                                activeUnit.disabled = (activeField.value === "0" || activeField.value === "");
                                                storageUnit.disabled = (storageField.value === "0" || storageField.value === "");
                                            }

                                            document.getElementById("editActive").addEventListener("input", updateRetentionUnits);
                                            document.getElementById("editStorage").addEventListener("input", updateRetentionUnits);

                                            // Disable units if fields are empty on load
                                            updateRetentionUnits();
                                        });

                                        // Toggle permanent logic
                                        function toggleEditPermanent() {
                                            var activeField = document.getElementById('editActive');
                                            var storageField = document.getElementById('editStorage');
                                            var activeUnit = document.getElementById('editActiveUnit');
                                            var storageUnit = document.getElementById('editStorageUnit');
                                            var permanentCheckbox = document.getElementById('editPermanent');

                                            if (permanentCheckbox.checked) {
                                                console.log("✅ Permanent selected. Disabling active/storage inputs.");

                                                // Disable and clear active/storage fields
                                                activeField.value = "";
                                                storageField.value = "";
                                                activeUnit.value = "";
                                                storageUnit.value = "";
                                                activeField.disabled = true;
                                                storageField.disabled = true;
                                                activeUnit.disabled = true;
                                                storageUnit.disabled = true;

                                                // Optionally add hidden inputs
                                                addHiddenInput('permanent_hidden', '1');
                                                addHiddenInput('active_unit_hidden', 'Permanent');
                                                addHiddenInput('storage_unit_hidden', 'Permanent');
                                            } else {
                                                console.log("🛑 Permanent unselected. Enabling active/storage inputs.");

                                                // Re-enable active/storage fields
                                                activeField.disabled = false;
                                                storageField.disabled = false;
                                                activeUnit.disabled = false;
                                                storageUnit.disabled = false;

                                                // Remove the hidden inputs we added
                                                removeHiddenInput('permanent_hidden');
                                                removeHiddenInput('active_unit_hidden');
                                                removeHiddenInput('storage_unit_hidden');
                                            }
                                        }

                                        function addHiddenInput(name, value) {
                                            let existing = document.querySelector(`input[name="${name}"]`);
                                            if (!existing) {
                                                let hiddenInput = document.createElement("input");
                                                hiddenInput.type = "hidden";
                                                hiddenInput.name = name;
                                                hiddenInput.value = value;
                                                document.querySelector("form").appendChild(hiddenInput);
                                                console.log(`➕ Added hidden input: ${name} = ${value}`);
                                            }
                                        }

                                        function removeHiddenInput(name) {
                                            let existing = document.querySelector(`input[name="${name}"]`);
                                            if (existing) {
                                                existing.remove();
                                                console.log(`❌ Removed hidden input: ${name}`);
                                            }
                                        }
                                    </script>

                                    <!-- RESTRICTION/S -->
                                    <div class="sm:col-span-1">
                                        <label for="editRestriction" class="block text-xs font-medium text-gray-900">Restriction</label>
                                        <select
                                            name="restriction"
                                            id="editRestriction"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="open-access">Open Access</option>
                                            <option value="confidential">Confidential</option>
                                        </select>
                                    </div>

                                    <!-- DISPOSITION PROVISION -->
                                    <div class="sm:col-span-1">
                                        <label for="editDisposition" class="block text-xs font-medium text-gray-900">Disposition Provision</label>
                                        <input
                                            type="text"
                                            name="disposition"
                                            id="editDisposition"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"
                                            placeholder="Enter disposition provision">
                                    </div>

                                    <!-- LOCATION OF RECORDS -->
                                    <div class="sm:col-span-1">
                                        <label for="editLocation" class="block text-xs font-medium text-gray-900">Location of Records</label>
                                        <input
                                            type="text"
                                            name="location"
                                            id="editLocation"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"
                                            placeholder="Enter location">
                                    </div>

                                    <!-- GRDS ITEM # -->
                                    <div class="sm:col-span-1">
                                        <label for="editGrdsItem" class="block text-xs font-medium text-gray-900">GRDS Item #</label>
                                        <input
                                            type="text"
                                            name="grds_item"
                                            id="editGrdsItem"
                                            class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs"
                                            placeholder="Enter GRDS item number">
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <button type="button" class="text-xs font-semibold text-gray-900" id="closeEditRecordModalBtn">Cancel</button>
                                <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-xs hover:bg-blue-500">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Edit JS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Function to update the form fields dynamically
        function populateForm(recordData) {
            console.log("Populating Form with Data:", recordData); // Debugging

            document.getElementById("editRecordForm").action = `/admin/records/${recordData.id}`;

            document.getElementById("editTitle").value = recordData.title ?? "";
            document.getElementById("editFrequency").value = recordData.frequency ?? "";
            document.getElementById("editRelatedDocuments").value = recordData.relatedDocuments ?? "";
            document.getElementById("editDuplication").value = recordData.duplication ?? "";
            document.getElementById("editStartYear").value = recordData.startYear || "";
            document.getElementById("editEndYear").value = recordData.endYear || "";
            document.getElementById("editTimeValue").value = recordData.timeValue === "P" ? "P" : "T";
            document.getElementById("editVolume").value = recordData.volume ?? "";

            // ✅ Correcting "Records Medium" Dropdown Value
            let mediumDropdown = document.getElementById("editMedium");
            let mediumValue = recordData.medium ? recordData.medium.toLowerCase() : "paper"; // Default to "paper" if empty

            console.log("Medium Before Setting:", mediumValue); // Debugging

            if (mediumValue === "paper" || mediumValue === "electronic") {
                mediumDropdown.value = mediumValue;
            } else {
                mediumDropdown.value = "paper"; // Fallback to paper if value is incorrect
            }

            // Handle utility checkboxes
            const utilities = (recordData.utility || "").split(",").map(u => u.trim().toLowerCase());
            document.getElementById("editAdm").checked = utilities.includes("adm");
            document.getElementById("editFiscal").checked = utilities.includes("f");
            document.getElementById("editLegal").checked = utilities.includes("l");
            document.getElementById("editArchival").checked = utilities.includes("a");

            // Handle retention periods
            document.getElementById("editActive").value = recordData.retentionActive || "";
            document.getElementById("editActiveUnit").value = recordData.retentionActiveUnit || "";
            document.getElementById("editStorage").value = recordData.retentionStorage || "";
            document.getElementById("editStorageUnit").value = recordData.retentionStorageUnit || "";

            // Handle permanent selection
            if (recordData.retentionActiveUnit === "Permanent" || recordData.retentionStorageUnit === "Permanent") {
                document.getElementById("editPermanent").checked = true;
                toggleEditPermanent();
            } else {
                document.getElementById("editPermanent").checked = false;
                toggleEditPermanent();
            }

            document.getElementById("editRestriction").value = recordData.restriction ?? "open-access";
            document.getElementById("editDisposition").value = recordData.disposition ?? "";
            document.getElementById("editLocation").value = recordData.location ?? "";
            document.getElementById("editGrdsItem").value = recordData.grdsItem ?? "";
        }

        // Open edit modal and populate form
        document.querySelectorAll(".edit-record-btn").forEach(button => {
            button.addEventListener("click", function (event) {
                event.stopPropagation();
                const row = this.closest(".record-row");
                const recordData = row.dataset;

                console.log("Clicked Edit, Record Data:", recordData); // Debugging

                populateForm(recordData);
                document.getElementById("editRecordModal").style.display = "block";
            });
        });

        // Close edit modal
        document.getElementById("closeEditRecordModalBtn").addEventListener("click", function () {
            document.getElementById("editRecordModal").style.display = "none";
        });

        // Handle form submission with AJAX
        $("#editRecordForm").on("submit", function (event) {
            event.preventDefault();

            let form = $(this);
            let formData = form.serialize();
            let recordId = form.attr("action").split("/").pop();

            $.ajax({
                url: form.attr("action"),
                type: "POST",
                data: formData,
                success: function (response) {
                    console.log("AJAX Success, Updated Record:", response.updatedRecord); // Debugging

                    if (response.success) {
                        let updatedRecord = response.updatedRecord;
                        let row = $(`tr[data-id='${recordId}']`);

                        row.find("td:eq(0)").text(updatedRecord.title);
                        row.find("td:eq(1)").text(updatedRecord.related_documents);
                        row.find("td:eq(2)").text(updatedRecord.start_year + " to " + updatedRecord.end_year);
                        row.find("td:eq(3)").text(updatedRecord.volume);
                        row.find("td:eq(4)").text(updatedRecord.medium);
                        row.find("td:eq(5)").text(updatedRecord.location);
                        row.find("td:eq(6)").text(updatedRecord.time_value === 'P' ? 'Permanent' : 'Temporary');

                        let retentionHTML = `
                        <div style="display: flex; justify-content: space-between;">
                            <span>${updatedRecord.active} ${updatedRecord.active_unit}</span>
                            <span>${updatedRecord.storage} ${updatedRecord.storage_unit}</span>
                            <span>${updatedRecord.total_retention}</span>
                        </div>`;
                        row.find("td:eq(7)").html(retentionHTML);

                        row.find("td:eq(8)").text(updatedRecord.disposition);
                        row.find("td:eq(9)").text(updatedRecord.grds_item);

                        $("#editRecordModal").hide();
                        showSuccessModal();
                    } else {
                        showErrorModal("Update failed.");
                    }
                },
                error: function (xhr) {
                    console.log("AJAX Error:", xhr.responseText);
                    let errorMessage = "An error occurred while updating the record.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showErrorModal(errorMessage);
                }
            });
        });

        // Function to show success modal
        function showSuccessModal() {
            $("#successModal").removeClass("hidden");

            // Close modal on button click
            $("#closeSuccessModalBtn").on("click", function () {
                $("#successModal").addClass("hidden");
            });
        }

        // Function to show error modal with message
        function showErrorModal(message) {
            $("#errorMessage").text(message);
            $("#errorModal").removeClass("hidden");

            // Close modal on button click
            $("#closeErrorModalBtn").on("click", function () {
                $("#errorModal").addClass("hidden");
            });
        }
    });
</script>








<!-- Success Modal -->
<div id="successModal" class="relative z-10 hidden" aria-labelledby="success-modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:size-10">
                            <svg class="size-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="success-modal-title">Success</h3>
                            <p class="text-sm text-gray-500">Record has been successfully updated.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="closeSuccessModalBtn" class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 sm:w-auto">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="relative z-10 hidden" aria-labelledby="error-modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                            <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="error-modal-title">Error</h3>
                            <p class="text-sm text-gray-500" id="errorMessage">Something went wrong while updating the record.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="closeErrorModalBtn" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:w-auto">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

















<!-- Archive Modal -->
<div class="relative z-10" id="archiveModal" aria-labelledby="archiveModal-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Panel -->
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                            <!-- Icon for error or success -->
                            <svg class="size-6 text-red-600" id="archiveModalIcon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" id="archiveModalIconPath" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="archiveModal-title">Confirm Archive</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="archiveModal-message">Are you sure you want to archive this record? This action can be undone later.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto" id="confirmArchiveBtn">Confirm Archive</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto" id="cancelArchiveBtn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Modal -->
<div class="relative z-10" id="resultModal" aria-labelledby="resultModal-title" role="dialog" aria-modal="true" style="display: none;">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal Panel -->
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:size-10">
                            <!-- Success Icon -->
                            <svg class="size-6 text-green-600" id="resultModalIcon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" id="resultModalIconPath" d="M9 12l2 2l4 -4m-5 0a7 7 0 1 1 7 7a7 7 0 0 1 -7 -7Z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="resultModal-title">Action Successful</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="resultModal-message">The record has been successfully archived!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 sm:ml-3 sm:w-auto" id="resultModalCloseBtn">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listener for the "Confirm Archive" button only once
        document.getElementById('confirmArchiveBtn').addEventListener('click', function() {
            const recordId = this.getAttribute('data-id');
            console.log('Confirm archive clicked for record ID:', recordId);

            // Show success modal immediately after confirm
            showResultModal('success', 'The record is being archived...');

            // Perform the archive action (AJAX call or form submission)
            archiveRecord(recordId);

            // Close the modal after the action
            document.getElementById('archiveModal').style.display = 'none';
            console.log('Modal closed after archiving');
        });

        // Loop through all Archive buttons and add event listeners
        document.querySelectorAll('[id^="archiveBtn"]').forEach(button => {
            button.addEventListener('click', function() {
                // Get the record ID from the data-id attribute
                const recordId = this.getAttribute('data-id');
                console.log('Record ID:', recordId); // Log the record ID

                // Show the archive modal
                document.getElementById('archiveModal').style.display = 'block';
                console.log('Modal should now be displayed');

                // Set the data-id of the Confirm Archive button to the current recordId
                document.getElementById('confirmArchiveBtn').setAttribute('data-id', recordId);
            });
        });

        // Close the modal if the cancel button is clicked
        document.getElementById('cancelArchiveBtn').addEventListener('click', function() {
            document.getElementById('archiveModal').style.display = 'none';
            console.log('Modal closed without archiving');
        });
    });

    // Function to archive the record
    function archiveRecord(recordId) {
        // Log to check if the function is being called
        console.log('Archiving record with ID:', recordId);

        // Example of an AJAX request to archive the record
        fetch(`/admin/records/archive/${recordId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    id: recordId
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Archive response:', data); // Log the response from the server
                // Show success modal
                showResultModal('success', 'The record has been successfully archived!');

                // Remove the row from the table after successful archiving
                removeArchivedRow(recordId);
            })
            .catch(error => {
                console.error('Error archiving record:', error); // Log any errors
                // Show error modal
                showResultModal('error', 'Failed to archive the record. Please try again.');
            });
    }

    // Function to remove the row from the table after archiving
    function removeArchivedRow(recordId) {
        // Find the row in the table based on the record ID
        const row = document.querySelector(`.record-row[data-id="${recordId}"]`);

        // If the row exists, remove it
        if (row) {
            row.remove();
            console.log(`Record with ID ${recordId} has been removed from the table.`);
        }
    }

    // Function to show the result modal (success or error)
    function showResultModal(status, message) {
        // Hide the archive modal if visible
        document.getElementById('archiveModal').style.display = 'none';

        // Set content for the result modal
        const resultModal = document.getElementById('resultModal');
        const resultMessage = document.getElementById('resultModal-message');
        const resultTitle = document.getElementById('resultModal-title');
        const resultIcon = document.getElementById('resultModalIcon');
        const resultIconPath = document.getElementById('resultModalIconPath');

        if (status === 'success') {
            resultIcon.classList.replace('text-red-600', 'text-green-600');
            resultIconPath.setAttribute('d', 'M9 12l2 2l4 -4m-5 0a7 7 0 1 1 7 7a7 7 0 0 1 -7 -7Z');
            resultTitle.textContent = 'Action Successful';
            resultMessage.textContent = message;
        } else {
            resultIcon.classList.replace('text-green-600', 'text-red-600');
            resultIconPath.setAttribute('d', 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z');
            resultTitle.textContent = 'Action Failed';
            resultMessage.textContent = message;
        }

        // Show the result modal immediately
        resultModal.style.display = 'block';

        // Close the result modal when clicking the close button
        document.getElementById('resultModalCloseBtn').addEventListener('click', function() {
            resultModal.style.display = 'none';
        });
    }
</script>

<!-- Modal Display HTML -->
<div class="relative z-10" id="showRecord" aria-labelledby="showRecord-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 transition-opacity" aria-hidden="true"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 90%; height: auto;">
                <div class="bg-white px-5 py-4 sm:p-5 sm:pb-3">
                    <h3 class="text-sm font-bold text-gray-900" id="showRecord-title">Record Details</h3>

                    <!-- Display Record Details -->
                    <div class="space-y-4">
                        <div class="border-b border-gray-300 pb-4">
                            <p class="mt-1 text-xs text-gray-500">Below are the details of the selected record.</p>

                            <div class="mt-4 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2 text-xs">
                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Records Series Title:</p>
                                    <p class="text-gray-600 record-title"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Related Documents:</p>
                                    <p class="text-gray-600 record-related-documents"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Period Covered:</p>
                                    <p class="text-gray-600 record-period"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Volume:</p>
                                    <p class="text-gray-600 record-volume"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Records Medium:</p>
                                    <p class="text-gray-600 record-medium"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Location of Records:</p>
                                    <p class="text-gray-600 record-location"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Time Value:</p>
                                    <p class="text-gray-600 record-time-value"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Retention Period:</p>
                                    <p class="text-gray-600">
                                        Active: <span class="record-retention-active"></span>,
                                        Storage: <span class="record-retention-storage"></span>,
                                        Total: <span class="record-retention-total"></span>
                                    </p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Disposition Provision:</p>
                                    <p class="text-gray-600 record-disposition"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">GRDS Item #:</p>
                                    <p class="text-gray-600 record-grds-item"></p>
                                </div>

                                <!-- New Fields -->
                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Restriction:</p>
                                    <p class="text-gray-600 record-restriction"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Utility:</p>
                                    <p class="text-gray-600 record-utility"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Duplication:</p>
                                    <p class="text-gray-600 record-duplication"></p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Frequency of Use:</p>
                                    <p class="text-gray-600 record-frequency"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex items-center justify-end gap-x-4">
                        <button type="button" class="text-xs font-semibold text-gray-700" id="closeShowRecordBtn">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- JS for modal tbody Capitalize the modal -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("✅ Script Loaded: Event listeners added");

        // -----------------------------------
        // Function to Capitalize First Letter
        // -----------------------------------
        function capitalizeFirstLetter(string) {
            return string.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());
        }

        // -----------------------------------
        // Function to Calculate Retention Period
        // -----------------------------------
        function formatRetentionPeriod(active, activeUnit, storage, storageUnit) {
            let totalYears = 0,
                totalMonths = 0;
            let totalDisplay = "";

            console.log(`🔹 Calculating Retention: Active(${active} ${activeUnit}), Storage(${storage} ${storageUnit})`);

            if (activeUnit === "Permanent" || storageUnit === "Permanent") {
                return "Permanent";
            }

            if (activeUnit === "years") {
                totalYears += active;
            } else if (activeUnit === "months") {
                totalMonths += active;
            }

            if (storageUnit === "years") {
                totalYears += storage;
            } else if (storageUnit === "months") {
                totalMonths += storage;
            }

            totalYears += Math.floor(totalMonths / 12);
            totalMonths = totalMonths % 12;

            if (totalYears > 0) totalDisplay += `${totalYears} ${totalYears > 1 ? 'yrs' : 'yr'}`;
            if (totalMonths > 0) {
                totalDisplay += totalYears > 0 ? `, ${totalMonths} ${totalMonths > 1 ? 'mos' : 'mo'}` :
                    `${totalMonths} ${totalMonths > 1 ? 'mos' : 'mo'}`;
            }
            if (!totalDisplay) totalDisplay = "0";

            console.log(`✔️ Final Retention Total: ${totalDisplay}`);
            return totalDisplay;
        }

        // -----------------------------------
        // DISPLAY MODAL (SHOW RECORD)
        // -----------------------------------
        function updateDisplayModal(recordData) {
            console.log("🔹 Displaying Record:", recordData);

            let active = parseInt(recordData.retentionActive) || 0;
            let activeUnit = recordData.retentionActiveUnit || "";
            let storage = parseInt(recordData.retentionStorage) || 0;
            let storageUnit = recordData.retentionStorageUnit || "";

            let retentionTotal = formatRetentionPeriod(active, activeUnit, storage, storageUnit);

            document.querySelector('.record-title').textContent = capitalizeFirstLetter(recordData.title);
            document.querySelector('.record-related-documents').textContent = capitalizeFirstLetter(recordData.relatedDocuments);
            document.querySelector('.record-period').textContent = `${recordData.startYear ?? 'N/A'} to ${recordData.endYear ?? 'N/A'}`;
            document.querySelector('.record-volume').textContent = recordData.volume ?? "N/A";
            document.querySelector('.record-medium').textContent = capitalizeFirstLetter(recordData.medium);
            document.querySelector('.record-location').textContent = capitalizeFirstLetter(recordData.location);
            document.querySelector('.record-time-value').textContent = capitalizeFirstLetter(recordData.timeValue);
            document.querySelector('.record-retention-active').textContent = `${active} ${activeUnit}`;
            document.querySelector('.record-retention-storage').textContent = `${storage} ${storageUnit}`;
            document.querySelector('.record-retention-total').textContent = retentionTotal;
            document.querySelector('.record-disposition').textContent = capitalizeFirstLetter(recordData.disposition);
            document.querySelector('.record-grds-item').textContent = capitalizeFirstLetter(recordData.grdsItem);
            document.querySelector('.record-restriction').textContent = capitalizeFirstLetter(recordData.restriction);
            document.querySelector('.record-utility').textContent = capitalizeFirstLetter(recordData.utility);
            document.querySelector('.record-duplication').textContent = capitalizeFirstLetter(recordData.duplication);
            document.querySelector('.record-frequency').textContent = capitalizeFirstLetter(recordData.frequency);

            document.getElementById('showRecord').style.display = 'block';
            console.log("✔️ Display Modal Opened");
        }

        document.querySelectorAll('.record-row').forEach(row => {
            row.addEventListener('click', function(event) {
                if (event.target.closest('button')) return;
                updateDisplayModal(this.dataset);
            });
        });

        document.getElementById('closeShowRecordBtn').addEventListener('click', function() {
            document.getElementById('showRecord').style.display = 'none';
            console.log("✔️ Display Modal Closed");
        });

        // -----------------------------------
        // EDIT MODAL (EDIT RECORD)
        // -----------------------------------
        function updateEditModal(recordData) {
            console.log("🔹 Edit Button Clicked. Record data:", recordData);

            document.getElementById("editTitle").value = recordData.title ?? "";
            document.getElementById("editFrequency").value = recordData.frequency ?? "";
            document.getElementById("editRelatedDocuments").value = recordData.relatedDocuments ?? "";
            document.getElementById("editDuplication").value = recordData.duplication ?? "";
            document.getElementById("editStartYear").value = recordData.startYear || "";
            document.getElementById("editEndYear").value = recordData.endYear || "";
            document.getElementById("editTimeValue").value = recordData.timeValue === "Permanent" ? "P" : "T";
            document.getElementById("editVolume").value = recordData.volume ?? "";

            ["Adm", "F", "L", "A"].forEach(value => {
                document.getElementById(`edit${value}`).checked = recordData.utility?.toLowerCase().includes(value.toLowerCase());
            });

            document.getElementById("editMedium").value = recordData.medium.toLowerCase();
            document.getElementById("editActive").value = parseInt(recordData.retentionActive) || 0;
            document.getElementById("editStorage").value = parseInt(recordData.retentionStorage) || 0;
            document.getElementById("editActiveUnit").value = recordData.retentionActiveUnit ?? "";
            document.getElementById("editStorageUnit").value = recordData.retentionStorageUnit ?? "";

            document.getElementById("editPermanent").checked =
                recordData.retentionActiveUnit === "Permanent" || recordData.retentionStorageUnit === "Permanent";

            toggleEditPermanent();

            document.getElementById("editRestriction").value = recordData.restriction ?? "";
            document.getElementById("editDisposition").value = recordData.disposition ?? "";
            document.getElementById("editLocation").value = recordData.location ?? "";
            document.getElementById("editGrdsItem").value = recordData.grdsItem ?? "";

            document.getElementById("editRecordModal").style.display = "block";
            console.log("✔️ Edit Modal Opened");
        }

        document.querySelectorAll(".edit-record-btn").forEach(button => {
            button.addEventListener("click", function(event) {
                event.stopPropagation();
                updateEditModal(this.closest(".record-row").dataset);
            });
        });

        document.getElementById("closeEditRecordModalBtn").addEventListener("click", function() {
            document.getElementById("editRecordModal").style.display = "none";
            console.log("✔️ Edit Modal Closed");
        });

        // -----------------------------------
        // SUCCESS & ERROR MODALS
        // -----------------------------------
        function showSuccessModal() {
            $("#successModal").removeClass("hidden");
            $("#closeSuccessModalBtn").on("click", function() {
                $("#successModal").addClass("hidden");
            });
        }

        function showErrorModal(message) {
            $("#errorMessage").text(message);
            $("#errorModal").removeClass("hidden");
            $("#closeErrorModalBtn").on("click", function() {
                $("#errorModal").addClass("hidden");
            });
        }
    });
</script>





<!-- Customed modal -->

<script>
    // Select the success/error modal elements
    const resultModal = document.getElementById("resultModal");
    const resultModalTitle = document.getElementById("resultModal-title");
    const resultModalMessage = document.getElementById("resultModal-message");
    const resultModalIcon = document.getElementById("resultModalIcon");
    const resultModalIconPath = document.getElementById("resultModalIconPath");
    const resultModalCloseBtn = document.getElementById("resultModalCloseBtn");

    // Function to show the result modal
    function showResultModal(title, message, isSuccess = true) {
        resultModalTitle.textContent = title;
        resultModalMessage.textContent = message;

        resultModal.style.display = "block";
        resultModal.style.zIndex = "50"; // Set higher z-index than myModal



        // Change the icon based on success/error
        if (isSuccess) {
            resultModalIcon.classList.remove("text-red-600", "bg-red-100");
            resultModalIcon.classList.add("text-green-600", "bg-green-100");
            resultModalIconPath.setAttribute("d", "M9 12l2 2l4 -4m-5 0a7 7 0 1 1 7 7a7 7 0 0 1 -7 -7Z"); // Success icon
        } else {
            resultModalIcon.classList.remove("text-green-600", "bg-green-100");
            resultModalIcon.classList.add("text-red-600", "bg-red-100");
            resultModalIconPath.setAttribute("d", "M6 18L18 6M6 6l12 12"); // Error icon
        }

        resultModal.style.display = "block";
    }

    // Close the modal when the close button is clicked
    resultModalCloseBtn.addEventListener("click", function() {
        resultModal.style.display = "none";
    });
</script>


<!-- Modal Form HTML -->
<div class="relative z-10" id="myModal" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-lg transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full" style="max-width: 500px;">
                <div class="bg-white px-6 py-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Add New User</h3>

                    <!-- User Form -->
                    <form id="userForm">
                        <div class="space-y-6">
                            <div class="border-b border-gray-900/10 pb-6">
                                <p class="mt-1 text-xs text-gray-600">Fill in the user details.</p>

                                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-1">
                                    <div class="grid grid-cols-2 gap-6">
                                        <!-- First Name -->
                                        <div>
                                            <label for="first_name" class="block text-xs font-medium text-gray-900">First name</label>
                                            <input type="text" name="first_name" id="first_name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter first name">
                                        </div>

                                        <!-- Last Name -->
                                        <div>
                                            <label for="last_name" class="block text-xs font-medium text-gray-900">Last name</label>
                                            <input type="text" name="last_name" id="last_name" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter last name">
                                        </div>
                                    </div>


                                    <!-- Email -->
                                    <div class="sm:col-span-1">
                                        <label for="email" class="block text-xs font-medium text-gray-900">Email</label>
                                        <input type="email" name="email" id="email" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter email">
                                    </div>

                                    <!-- Role -->
                                    <div class="sm:col-span-1">
                                        <label for="role" class="block text-xs font-medium text-gray-900">Role</label>
                                        <select name="role" id="role" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="Admin">Admin</option>
                                            <option value="Borrower">Borrower</option>
                                        </select>
                                    </div>

                                    <!-- Status -->
                                    <div class="sm:col-span-1">
                                        <label for="status" class="block text-xs font-medium text-gray-900">Status</label>
                                        <select name="status" id="status" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <!-- Department -->
                                    <div class="sm:col-span-1">
                                        <label for="department" class="block text-xs font-medium text-gray-900">Department</label>
                                        <input type="text" name="department" id="department" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter department">
                                    </div>

                                    <!-- Cellphone Number -->
                                    <div class="sm:col-span-1">
                                        <label for="cellphone_number" class="block text-xs font-medium text-gray-900">Cellphone Number</label>
                                        <input type="text" name="cellphone_number" id="cellphone_number" class="mt-1 block w-full py-1.5 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none sm:text-xs" placeholder="Enter cellphone number">
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <button type="button" class="text-xs font-semibold text-gray-900" id="closeUserModal">Cancel</button>
                                <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-xs hover:bg-blue-500">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("myModal");
        const form = document.getElementById("userForm");
        const requiredFields = ["name", "email", "role", "status", "department", "cellphone_number"];

        // Open Modal
        document.getElementById("openModalBtn").addEventListener("click", function() {
            modal.style.display = "block";
        });

        // Close Modal
        document.getElementById("closeUserModal").addEventListener("click", function() {
            modal.style.display = "none";
        });

        // Close Modal When Clicking Outside
        document.querySelector(".fixed.inset-0").addEventListener("click", function(event) {
            if (!event.target.closest(".relative.transform")) {
                modal.style.display = "none";
            }
        });

        // Form Submission with Validation
        form.addEventListener("submit", async function(event) {
            event.preventDefault();
            let isValid = true;
            let formData = {};

            // Validate Required Fields
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (input.value.trim() === "") {
                    isValid = false;
                    input.classList.add("border-red-500");
                } else {
                    input.classList.remove("border-red-500");
                    formData[field] = input.value.trim();
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please fill in all required fields!",
                    confirmButtonColor: "#d33"
                });
                return;
            }

            console.log("Form Data Ready for Submission:", formData);

            try {
                // Simulated API request
                let response = await fetch("/submit-user", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(formData)
                });

                let result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "User added successfully!",
                        showConfirmButton: false,
                        timer: 2000
                    });

                    // Close modal and reset form
                    setTimeout(() => {
                        modal.style.display = "none";
                        form.reset();
                    }, 1500);
                } else {
                    throw new Error(result.message || "Failed to add user.");
                }
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Database Error",
                    text: "Failed to add user. Check console for details.",
                    confirmButtonColor: "#d33"
                });
                console.error("Database Error:", error.message);
            }
        });

        // Remove red border when typing
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            input.addEventListener("input", function() {
                if (input.value.trim() !== "") {
                    input.classList.remove("border-red-500");
                }
            });
        });
    });
</script>
@endsection




<!-- AYusin mo yung tbody scrollbar -->