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
        #borrowedItemsTable {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        table.dataTable thead th {
            text-align: center;
        }



        /* Table Header Styling */
        #borrowedItemsTable th {
            background-color: #EBF8FD;
            color: #4a5568;
            font-weight: 600;
            text-align: center;
            padding: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        /* Table Data Styling */
        #borrowedItemsTable td {
            background-color: #ffffff;
            color: #2d3748;
            text-align: center;
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Add hover effect for rows */
        #borrowedItemsTable tr:hover {
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


    <style>
        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>




</head>

<div class="mx-auto p-2" style="width: 1220px; height: 700px; font-family: 'Inter', sans-serif;">
    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <div class="flex justify-between items-center mb-4 pt-0">
            <h1 class="text-3xl text-left">Return Items</h1>
        </div>

        <div style="height: 550px; overflow-y: auto;">
            <table id="borrowedItemsTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Borrower</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowedItems as $borrowedItem)
                    <tr>
                        <td>{{ $borrowedItem->borrower->first_name }} {{ $borrowedItem->borrower->last_name }}</td>
                        <td>{{ $borrowedItem->item->name }}</td>
                        <td>{{ $borrowedItem->quantity_borrowed }}</td>
                        <td>{{ $borrowedItem->borrow_date->format('Y-m-d') }}</td>
                        <td>{{ $borrowedItem->due_date->format('Y-m-d') }}</td>
                        <td>
                            <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                                {{ $borrowedItem->status == 'Borrowed' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                                {{ $borrowedItem->status == 'Returned' ? 'bg-purple-500/10 text-purple-500 border border-purple-500' : '' }}">
                                {{ $borrowedItem->status }}
                            </span>
                        </td>
                        <td>
                            <button class="return-btn px-2 py-1 m-1 bg-[#A855F7] text-white rounded hover:bg-[#7038A4] focus:outline-none focus:ring-2 focus:ring-[#A855F7] text-xs w-24"
                                onclick="returnItem('{{ $borrowedItem->id }}')"
                                @if($borrowedItem->status == 'Returned')
                                    disabled
                                    style="opacity: 0.5;"
                                    data-toggle="tooltip" data-placement="top" title="This item has already been returned."
                                @endif>
                                Return
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
   $(document).ready(function() {
    // Initialize DataTable
    $('#borrowedItemsTable').DataTable({
        scrollY: '420px',
        scrollCollapse: true,
        paging: true,
        searching: true,
        ordering: true
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});

    function returnItem(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to return this item.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#A855F7',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, return it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/return-items/mark/' + id,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Returned!', 'The item has been returned.', 'success')
                            .then(() => {
                                location.reload();
                            });
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    }
</script>












<!-- Modal for QR Code Scanner -->
<div id="qr-modal" class="mx-auto p-2 hidden fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm bg-black bg-opacity-50 transition-all duration-300 ease-in-out" style="font-family: 'Inter', sans-serif;">
    <div class="bg-white p-8 rounded-lg max-w-4xl w-full max-h-[600px] flex">


        <!-- Left Side: Table Container with item codes -->
        <div class="h-full overflow-y-auto w-1/2">

            <table id="codeTable" class="display" style="width: 100%; height: 100%; border: 2px solid #ccc; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: center;">Item Code</th>
                        <th style="text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    <tr>
                        <td>ITEM001</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM002</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM003</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM001</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM002</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM003</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM001</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM002</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM003</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM001</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM002</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td>ITEM003</td>
                        <td>Available</td>
                    </tr>
                </tbody>

            </table>
        </div>

        <!-- Right Side: QR Code Scanner -->
        <div class="w-1/2 pl-4 flex flex-col justify-between" style="height: 400px;">
            <h2 class="text-xl mb-4">Scan QR Code</h2>
            <div id="scanner-container" class="flex justify-center" style="height: 100%;">
                <video id="video" autoplay class="w-full max-w-md h-auto border-2 border-gray-300"></video>
            </div>
            <div id="result" class="mt-2">Scanning for QR code...</div>

            <!-- Flex container for buttons -->
            <div class="flex gap-4 mt-4">
                <!-- Close Button -->
                <button class="px-4 py-2 bg-blue-500 text-white rounded w-1/2" onclick="closeQRScanner()">Close</button>

                <!-- Approve Button -->
                <button class="px-4 py-2 bg-green-500 text-white rounded w-1/2">Approve</button>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#codeTable').DataTable({
            scrollY: '420px',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: false
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });

    function openQRScanner(itemCode) {
        document.getElementById('qr-modal').classList.remove('hidden');
        let scannedCode = '';

        // Set up webcam for scanning
        const video = document.getElementById('video');
        const resultDiv = document.getElementById('result');
        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "environment"
                }
            })
            .then(stream => {
                video.srcObject = stream;
                video.setAttribute('playsinline', true); // for iOS
                video.play();
                scanQRCode();
            })
            .catch(err => {
                resultDiv.textContent = "Error accessing camera: " + err;
            });

        // Function to scan QR code from webcam
        function scanQRCode() {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            setInterval(() => {
                // Draw the video frame to the canvas
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Try to decode the QR code
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const qrCode = jsQR(imageData.data, canvas.width, canvas.height);

                if (qrCode) {
                    scannedCode = qrCode.data; // Store the scanned code
                    resultDiv.textContent = 'QR Code detected: ' + scannedCode;
                    if (scannedCode === itemCode) {
                        // The QR code matches the item code, approve the request
                        approveRequest();
                    } else {
                        resultDiv.textContent = 'QR Code does not match the item code.';
                    }
                } else {
                    resultDiv.textContent = 'Scanning for QR code...';
                }
            }, 100); // Scan every 100ms
        }

        // Function to approve the request
        function approveRequest() {
            Swal.fire({
                title: 'QR Code matched!',
                text: "Do you want to approve this request?",
                icon: 'success',
                confirmButtonText: 'Yes, approve it!',
                showCancelButton: true,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(itemCode, 'Approved');
                    closeQRScanner();
                }
            });
        }

        // Close the QR scanner modal
        function closeQRScanner() {
            document.getElementById('qr-modal').classList.add('hidden');
        }
    }

    function closeQRScanner() {
        document.getElementById('qr-modal').classList.add('hidden');
    }

    function updateStatus(itemCode, status) {
        // Send the update to the backend to approve the request
        $.ajax({
            url: '/admin/inventory-requests/update-status',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                itemCode: itemCode,
                status: status
            },
            success: function(response) {
                Swal.fire('Updated!', 'The request has been ' + status.toLowerCase() + '.', 'success')
                    .then(() => {
                        location.reload();
                    });
            },
            error: function() {
                Swal.fire('Error!', 'Something went wrong.', 'error');
            }
        });
    }
</script>



@endsection