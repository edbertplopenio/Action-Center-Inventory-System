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

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Added scrollbar in the tbody -->
    <style>
        /* Apply font size and font family */
        body,
        #myTable {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 12px;
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
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                scrollY: '400px', // Enable vertical scrolling
                scrollCollapse: true,
            });
        });
    </script>


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


    <!-- CSS for the highlight of table when clicked -->
    <style>
        /* Styling for highlighting */
        .highlighted {
            background-color: #EBF8FD !important;
            /* Light yellow highlight */
        }
    </style>

    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable(); // Initialize DataTables

            $('#myTable thead th').on('click', function() {
                var columnIndex = $(this).index(); // Get clicked column index

                // Remove previous highlights
                $('#myTable thead th, #myTable tbody td').removeClass('highlighted');

                // Highlight the clicked header
                $(this).addClass('highlighted');

                // Highlight all cells in the same column
                $('#myTable tbody tr').each(function() {
                    $(this).find('td').eq(columnIndex).addClass('highlighted');
                });
            });
        });
    </script>



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
                        <th style="min-width: 150px;">
                            Retention Period <br>
                            <span style="display: flex; justify-content: space-between; font-weight: normal;">
                                <span>Active</span>
                                <span>Storage</span>
                                <span>Total</span>
                            </span>
                        </th>
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Transfer to archive after 2 years</td>
                        <td>67890</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Transfer to archive after 2 years</td>
                        <td>67890</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Transfer to archive after 2 years</td>
                        <td>67890</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Transfer to archive after 2 years</td>
                        <td>67890</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Transfer to archive after 2 years</td>
                        <td>67890</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
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
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Destroy after 5 years</td>
                        <td>12345</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
                                Edit
                            </button>



                            <!-- Archive Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#57cc99] text-white rounded hover:bg-[#45a17e] focus:outline-none focus:ring-2 focus:ring-[#57cc99] text-xs w-24">
                                Archive
                            </button>



                        </td>
                    </tr>
                    <tr>
                        <td>edbert</td>
                        <td>cat</td>
                        <td>2021-01-01 to 2021-12-31</td>
                        <td>200</td>
                        <td>Physical</td>
                        <td>Branch Office</td>
                        <td>Temporary</td>
                        <td>
                            <div style="display: flex; justify-content: space-between;">
                                <span>1</span> <!-- Active -->
                                <span>0</span> <!-- Storage -->
                                <span>1</span> <!-- Total -->
                            </div>
                        </td>
                        <td>Transfer to archive after 2 years</td>
                        <td>67890</td>
                        <td>
                            <!-- Edit Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#4cc9f0] text-white rounded hover:bg-[#36a9c1] focus:outline-none focus:ring-2 focus:ring-[#4cc9f0] text-xs w-24">
                                Edit
                            </button>



                            <!-- Archive Button with custom color -->
                            <button class="px-2 py-1 m-1 bg-[#57cc99] text-white rounded hover:bg-[#45a17e] focus:outline-none focus:ring-2 focus:ring-[#57cc99] text-xs w-24">
                                Archive
                            </button>


                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable(); // Initialize DataTable
    });
</script>






<!-- Modal Display HTML -->
<div class="relative z-10" id="showRecord" aria-labelledby="showRecord-title" role="dialog" aria-modal="true" style="display: none;">
    <!-- Backdrop with stronger blur effect -->
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
                                    <p class="text-gray-600">Example Title and Description</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Frequency of Use:</p>
                                    <p class="text-gray-600">Weekly</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Related Documents:</p>
                                    <p class="text-gray-600">Document 1, Document 2</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Duplication:</p>
                                    <p class="text-gray-600">Some duplication details</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Period Covered:</p>
                                    <p class="text-gray-600">Jan 1, 2020 - Dec 31, 2023</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Time Value:</p>
                                    <p class="text-gray-600">Temporary</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Volume:</p>
                                    <p class="text-gray-600">50</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Utility Value:</p>
                                    <p class="text-gray-600">Admin, Fiscal</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Records Medium:</p>
                                    <p class="text-gray-600">Electronic</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Retention Period:</p>
                                    <p class="text-gray-600">Active: 2 Years, Storage: 5 Years</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Restriction:</p>
                                    <p class="text-gray-600">Confidential</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Disposition Provision:</p>
                                    <p class="text-gray-600">Retain for review</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">Location of Records:</p>
                                    <p class="text-gray-600">Main Archive Room</p>
                                </div>

                                <div class="sm:col-span-1">
                                    <p class="block font-semibold text-gray-800">GRDS Item #:</p>
                                    <p class="text-gray-600">12345</p>
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


<!-- JavaScript for opening and closing the modal and submitting the form -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById('showRecord');
        const form = modal.querySelector("form");
        const requiredFields = [
            "title", "frequency", "related_documents", "duplication",
            "start_date", "end_date", "time_value", "volume", "medium",
            "restriction", "disposition", "location", "grds_item"
        ];

        // Open the modal
        document.getElementById('openModalBtn').addEventListener('click', function() {
            modal.style.display = 'block';
        });

        // Close the modal
        document.getElementById('closeModalBtn').addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside
        document.querySelector('.fixed.inset-0').addEventListener('click', function(event) {
            if (event.target.closest('.relative.transform') === null) {
                modal.style.display = 'none';
            }
        });

        // Toggle retention period fields if "Permanent" is checked
        document.getElementById('permanent').addEventListener('change', function() {
            let activeField = document.getElementById('active_value');
            let storageField = document.getElementById('storage_value');

            if (this.checked) {
                activeField.value = 0;
                storageField.value = 0;
                activeField.disabled = true;
                storageField.disabled = true;
            } else {
                activeField.disabled = false;
                storageField.disabled = false;
            }
        });

        // Validate and submit form
        form.addEventListener("submit", async function(event) {
            event.preventDefault(); // Prevent actual form submission
            let isValid = true;
            let formData = new FormData(form); // Use FormData to handle arrays properly

            // CSRF Token (Required for Laravel)
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('_token', token);

            // Loop through required fields and check if they're filled
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    if (input.value.trim() === "") {
                        isValid = false;
                        input.classList.add("border-red-500"); // Add red border if empty
                        console.error(`Validation Error: ${field} is empty.`);
                    } else {
                        input.classList.remove("border-red-500"); // Remove red border if filled
                    }
                }
            });

            // Check if at least one utility value is selected
            let utilityCheckboxes = document.querySelectorAll("input[name='utility_value[]']:checked");
            if (utilityCheckboxes.length === 0) {
                isValid = false;
                console.error("Validation Error: At least one utility value must be selected.");
            }

            if (!isValid) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please fill in all required fields and select at least one utility value!",
                    confirmButtonColor: "#d33"
                });
                console.error("Form validation failed.");
                return; // Stop submission
            }

            console.log("Form Data Ready for Submission:", Object.fromEntries(formData.entries()));

            try {
                let response = await fetch("{{ route('records.store') }}", {
                    method: "POST",
                    body: formData
                });

                let result = await response.json();
                console.log("Database Response:", result);

                if (response.ok) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Record added successfully!",
                        showConfirmButton: false,
                        timer: 2000
                    });

                    setTimeout(() => {
                        modal.style.display = "none";
                        form.reset();
                        location.reload();
                    }, 1500);
                } else {
                    throw new Error(result.message || "Failed to add record.");
                }
            } catch (error) {
                console.error("Database Error:", error.message);
                Swal.fire({
                    icon: "error",
                    title: "Database Error",
                    text: "Failed to add record. Check console for details.",
                    confirmButtonColor: "#d33"
                });
            }
        });

        // Remove red border when user types in a field
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener("input", function() {
                    if (input.value.trim() !== "") {
                        input.classList.remove("border-red-500");
                    }
                });
            }
        });
    });
</script>



@endsection