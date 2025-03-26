@extends('layouts.app')

@section('title', 'Borrowing Requests')

@section('content')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Add Google Fonts link for Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">

    <!-- Include jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

    <!-- Include SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="https://unpkg.com/jsqr/dist/jsQR.min.js"></script>

    <link href="https://unpkg.com/phosphor-icons@1.4.2/css/phosphor.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>

    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>


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
        /* Center table header and body content */
        #requestsTable th,
        #requestsTable td {
            text-align: center;
        }
    </style>

    <style>
        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>




    <style>
        .highlight {
            background-color: #90ee90;
            /* Light green for highlight */
            color: #000;
        }
    </style>


</head>

<div class="mx-auto p-2" style="width: 1220px; height: 700px; font-family: 'Inter', sans-serif;">
    <div class="bg-white p-6 shadow-lg rounded-lg h-full">
        <div class="flex justify-between items-center mb-4 pt-0">
            <h1 class="text-3xl text-left">Borrowing Requests</h1>
        </div>

        <div style="height: 550px; overflow-y: auto;">
            <table id="requestsTable" class="display" style="width:100%">
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
                    @forelse($borrowing_requests as $request)
                    <tr>
                        <td>
                            @if($request->borrower)
                            {{ $request->borrower->first_name }} {{ $request->borrower->last_name }}
                            @else
                            <span class="text-red-500">No Borrower Found</span>
                            @endif
                        </td>

                        <td>{{ $request->item->name }}</td>
                        <td>{{ $request->quantity_borrowed }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->borrow_date)->format('Y-m-d') }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->due_date)->format('Y-m-d') }}</td>
                        <td>
                            <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                {{ $request->status == 'Pending' ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500' : '' }}
                {{ $request->status == 'Approved' ? 'bg-green-500/10 text-green-500 border border-green-500' : '' }}
                {{ $request->status == 'Rejected' ? 'bg-red-500/10 text-red-500 border border-red-500' : '' }}
                {{ $request->status == 'Borrowed' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                {{ $request->status == 'Returned' ? 'bg-purple-500/10 text-purple-500 border border-purple-500' : '' }}
                {{ $request->status == 'Overdue' ? 'bg-orange-500/10 text-orange-500 border border-orange-500' : '' }}
                {{ $request->status == 'Lost' ? 'bg-gray-500/10 text-gray-500 border border-gray-500' : '' }}
                {{ $request->status == 'Damaged' ? 'bg-pink-500/10 text-pink-500 border border-pink-500' : '' }}">
                                {{ $request->status }}
                            </span>
                        </td>
                        <td>
                            <button class="approve-btn px-2 py-1 m-1 bg-green-500 text-white rounded 
    hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 text-xs w-24"
                                onclick="openQRScanner('{{ $request->item->id }}')"
                                @if(in_array($request->status, ['Approved', 'Rejected', 'Borrowed', 'Returned', 'Overdue', 'Lost', 'Damaged']))
                                disabled
                                style="opacity: 0.5;"
                                data-toggle="tooltip" data-placement="top" title="This request cannot be approved because it is already in a final state."
                                @endif>
                                Approve
                            </button>



                            <button class="reject-btn px-2 py-1 m-1 bg-red-500 text-white rounded 
    hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 text-xs w-24"
                                onclick="updateStatus('{{ $request->id }}', 'Rejected')"
                                @if(in_array($request->status, ['Approved', 'Rejected', 'Borrowed', 'Returned', 'Overdue', 'Lost', 'Damaged']))
                                disabled
                                style="opacity: 0.5;"
                                data-toggle="tooltip" data-placement="top" title="This request cannot be rejected because it is already in a final state."
                                @endif>
                                Reject
                            </button>
                        </td>


                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No borrowing requests found.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#requestsTable').DataTable({
            scrollY: '420px',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>





<!-- Modal for QR Code Scanner -->
<div id="qr-modal" class="mx-auto p-2 hidden fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm bg-black bg-opacity-50 transition-all duration-300 ease-in-out" style="font-family: 'Inter', sans-serif;">
    <div class="bg-white p-8 rounded-lg max-w-4xl w-full max-h-[680px] flex">


        <div class="h-full overflow-y-auto w-1/2">
            <table id="codeTable" class="display" style="width: 100%; height: 100%; border: 2px solid #ccc; border-collapse: collapse; table-layout: fixed;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 50%;">QR Code</th>
                        <th style="text-align: center; width: 50%;">Status</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                    @foreach ($items as $item)
                    @foreach ($item->individualItems as $individualItem)
                    <tr>
                        <!-- Display the QR code -->
                        <td style="text-align: center;">{{ $individualItem->qr_code }}</td>
                        <!-- Display the status -->
                        <td style="text-align: center;">{{ $individualItem->status }}</td>
                    </tr>
                    @endforeach
                    @endforeach
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

                <!-- Undo Button -->
                <button class="px-4 py-2 bg-gray-500 text-white rounded w-1/2" onclick="undoAction()" id="undoButton" disabled>Undo</button>
            </div>
        </div>

    </div>
</div>




<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#codeTable').DataTable({
            paging: true,
            searching: true,
            ordering: false,
            pageLength: 10, // Set number of rows per page to 10
            lengthChange: false, // Disable the entries per page dropdown
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });

    let isScanning = false; // Controls if scanning is ongoing
    let scannedQRCodeList = []; // To store scanned QR codes for reference
    let scannedRows = []; // Store each row with its original index for undo functionality

    function openQRScanner(itemId) {
        // Show the QR code modal
        document.getElementById('qr-modal').classList.remove('hidden');

        // Clear the table body before updating it with new data
        const resultDiv = document.getElementById('codeTable').getElementsByTagName('tbody')[0];
        resultDiv.innerHTML = ''; // Clear previous QR code data

        // Display loading message while fetching QR codes
        resultDiv.innerHTML = '<tr><td colspan="2" class="text-center">Loading QR Codes...</td></tr>';

        // Fetch QR codes for the selected item using AJAX
        $.ajax({
            url: '/admin/get-item-qr-codes/' + itemId, // Make sure this URL is correct
            method: 'GET',
            success: function(response) {
                // Clear the loading message once QR codes are fetched
                resultDiv.innerHTML = '';

                // Check if we received QR codes
                if (response.qr_codes && response.qr_codes.length > 0) {
                    // Clear the table using DataTable API
                    var table = $('#codeTable').DataTable();
                    table.clear(); // Clear existing rows

                    // Add the new rows from the response
                    response.qr_codes.forEach(function(qrCode) {
                        const row = document.createElement('tr');
                        const qrCell = document.createElement('td');
                        const statusCell = document.createElement('td');

                        // Insert QR code and status into the table
                        qrCell.textContent = qrCode.qr_code;
                        statusCell.textContent = qrCode.status;

                        // Append the row to the table
                        row.appendChild(qrCell);
                        row.appendChild(statusCell);

                        // Use DataTable to add the row and update the view
                        table.row.add($(row)).draw();
                    });
                } else {
                    // If no QR codes are available, show a message
                    const row = document.createElement('tr');
                    const emptyCell = document.createElement('td');
                    emptyCell.colSpan = 2;
                    emptyCell.textContent = "No QR codes found for this item.";
                    row.appendChild(emptyCell);
                    resultDiv.appendChild(row);
                }
            },
            error: function(err) {
                console.error('Error fetching QR codes:', err);
                // Display error message
                const row = document.createElement('tr');
                const errorCell = document.createElement('td');
                errorCell.colSpan = 2;
                errorCell.textContent = "Error loading QR codes.";
                row.appendChild(errorCell);
                resultDiv.appendChild(row);
            }
        });

        // Setup webcam for scanning
        const video = document.getElementById('video');
        const resultText = document.getElementById('result');

        // Start scanning process
        isScanning = true; // Begin scanning
        scannedQRCodeList = []; // Reset the list of scanned QR codes

        navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: "environment"
            }
        }).then(stream => {
            video.srcObject = stream;
            video.setAttribute('playsinline', true); // for iOS
            video.play();
            scanQRCode();
        }).catch(err => {
            resultText.textContent = "Error accessing camera: " + err;
        });

        // QR code scanning function
        function scanQRCode() {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            const scanInterval = setInterval(() => {
                if (!isScanning) {
                    clearInterval(scanInterval); // Stop scanning if flag is set to false
                    return;
                }

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const qrCode = jsQR(imageData.data, canvas.width, canvas.height);

                if (qrCode) {
                    resultText.textContent = 'QR Code detected: ' + qrCode.data;

                    // If QR code is valid and not already scanned, highlight and add it
                    if (!scannedQRCodeList.includes(qrCode.data)) {
                        scannedQRCodeList.push(qrCode.data); // Add scanned QR code to the list
                        highlightAndMoveRow(qrCode.data);
                        updateItemStatus(qrCode.data); // Update status when a valid QR code is scanned
                        document.getElementById('undoButton').disabled = false; // Enable Undo button
                    }
                } else {
                    resultText.textContent = 'Scanning for QR code...';
                }
            }, 100); // Scan every 100ms
        }

        function highlightAndMoveRow(scannedQRCode) {
    const table = $('#codeTable').DataTable();
    const rows = table.rows().nodes();
    let matchFound = false;

    $(rows).each(function(index, row) {
        const qrCodeCell = row.cells[0];
        const qrCode = qrCodeCell ? qrCodeCell.textContent : null;

        if (qrCode && qrCode === scannedQRCode) {
            matchFound = true;

            // Check if the status is already 'Borrowed'
            const statusCell = row.cells[1];
            if (statusCell.textContent === 'Borrowed') {
                // Show SweetAlert if the item is already borrowed
                Swal.fire({
                    icon: 'warning',
                    title: 'Item Already Borrowed',
                    text: 'This item has already been marked as borrowed.',
                });
                return; // Exit the function if the item is already borrowed
            }

            // Highlight the row if the status is not 'Borrowed'
            row.style.backgroundColor = '#D3CBFF';
            row.style.color = '#000';
            row.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });

            // Get the row index in the entire table (not just current page)
            const rowIndex = table.row(row).index();

            // Get the page number where the row is located
            const pageNumber = Math.floor(rowIndex / table.settings()[0]._iDisplayLength);

            // Move to the page containing the QR code
            table.page(pageNumber).draw('page');

            // Update the status to 'Borrowed'
            statusCell.textContent = 'Borrowed';

            // Save the row to scannedRows for undo functionality
            scannedRows.push({
                row: row,
                index: rowIndex,
                originalStatus: row.cells[1].textContent, // Save original status to revert later
                originalPage: pageNumber // Save the original page number
            });
        }
    });

    if (!matchFound) {
        Swal.fire({
            icon: 'error',
            title: 'QR Code not found',
            text: 'The scanned QR code is not present in the table.',
        });
    }
}





        // Update Item Status when a QR code is successfully scanned
        function updateItemStatus(scannedQRCode) {
            // Find the item with the matching QR code
            const row = Array.from(document.querySelectorAll('#codeTable tbody tr')).find(row => {
                const qrCodeCell = row.cells[0]; // QR Code is in the first column
                return qrCodeCell && qrCodeCell.textContent === scannedQRCode;
            });

            if (row) {
                const statusCell = row.cells[1]; // Status is in the second column
                statusCell.textContent = 'Borrowed'; // Update status to 'Borrowed'
            }
        }

        // Undo action: Revert row changes
        // Undo action: Revert row changes
        window.undoAction = function() {
            if (scannedRows.length > 0) {
                // Get the last scanned row
                const lastScanned = scannedRows.pop();

                // Remove highlight and reset status
                lastScanned.row.style.backgroundColor = '';
                lastScanned.row.style.color = '';
                const statusCell = lastScanned.row.cells[1];
                statusCell.textContent = lastScanned.originalStatus; // Reset status to original

                // Move the row back to its original position in the table
                const tbody = document.getElementById('codeTable').getElementsByTagName('tbody')[0];
                const rows = Array.from(tbody.rows);
                tbody.insertBefore(lastScanned.row, rows[lastScanned.index]);

                // Remove the QR code from the scanned list to allow it to be scanned again
                const scannedQRCodeIndex = scannedQRCodeList.indexOf(lastScanned.row.cells[0].textContent);
                if (scannedQRCodeIndex !== -1) {
                    scannedQRCodeList.splice(scannedQRCodeIndex, 1);
                }

                // Move the table back to the original page where the row was located
                const table = $('#codeTable').DataTable();
                table.page(lastScanned.originalPage).draw('page'); // Move to the original page

                // Disable the Undo button if no rows are left to undo
                if (scannedRows.length === 0) {
                    document.getElementById('undoButton').disabled = true;
                }
            }
        }

    }
</script>







<script>
    function closeQRScanner() {
        // Hide the QR modal
        document.getElementById('qr-modal').classList.add('hidden');

        // Stop the camera stream (if it's being used)
        const video = document.getElementById('video');
        const stream = video.srcObject;

        if (stream) {
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop()); // Stop all media tracks (video, audio)
            video.srcObject = null; // Reset the video element's source
        }

        // Stop the scanning process
        isScanning = false;

        // Clear any previously scanned QR codes
        scannedQRCodeList = [];

        // Reset the undo action button to disabled
        document.getElementById('undoButton').disabled = true;
    }
</script>


@endsection