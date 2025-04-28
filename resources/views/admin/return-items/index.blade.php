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
        #borrowedItemsTable th,
        #borrowedItemsTable td {
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
            <h1 class="text-3xl text-left">Return Items</h1>
        </div>

        <div style="height: 550px; overflow-y: auto;">
            <table id="borrowedItemsTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th style="display:none;">ID</th> <!-- Hidden ID column -->
                        <th>Borrower</th>
                        <th>Item Name</th>
                        <th>QR Code(s)</th>
                        <th>Quantity</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Returned Items</th>
                        <th>Remarks</th> <!-- New Remarks Column -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($borrowedItems as $borrowedItem)
                    <tr>
                        <td style="display:none;">{{ $borrowedItem->id }}</td> <!-- Hidden ID value -->
                        <td>{{ $borrowedItem->borrower->first_name }} {{ $borrowedItem->borrower->last_name }}</td>
                        <td>{{ $borrowedItem->item->name }}</td>

                        <!-- Display all QR codes for the borrowed item -->
                        <td>
                            @foreach($borrowedItem->individualItems as $individualItem)
                            <span>{{ $individualItem->qr_code }}</span><br>
                            @endforeach
                        </td>

                        <td>{{ $borrowedItem->quantity_borrowed }}</td>
                        <td>{{ $borrowedItem->borrow_date->format('Y-m-d') }}</td>
                        <td>{{ $borrowedItem->due_date->format('Y-m-d') }}</td>

                        <td>
                            @php
                            // Get the return dates from the individual_item_returns relationship
                            $returnDates = $borrowedItem->individualItemReturns->groupBy('return_date');
                            @endphp
                            @foreach($returnDates as $date => $returns)
                            @if($date)
                            <strong>{{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}</strong><br>
                            @foreach($returns as $return)
                            {{ $return->individualItem->qr_code }}<br>
                            @endforeach
                            @endif
                            @endforeach
                        </td>

                        <td>
                            <span class="px-3 py-1 text-xs font-semibold rounded w-24 text-center inline-block
                {{ $borrowedItem->status == 'Borrowed' ? 'bg-blue-500/10 text-blue-500 border border-blue-500' : '' }}
                {{ $borrowedItem->status == 'Returned' ? 'bg-purple-500/10 text-purple-500 border border-purple-500' : '' }}">
                                {{ $borrowedItem->status }}
                            </span>
                        </td>

                        <td>
                            @php
                            // Count how many individual items have been returned (i.e., have a non-null return date)
                            $returnedItemsCount = $borrowedItem->individualItemReturns->whereNotNull('return_date')->count();
                            @endphp
                            {{ $returnedItemsCount }}/{{ $borrowedItem->quantity_borrowed }}
                        </td>

                        <!-- New Remarks Column -->
                        <td>
                            @foreach($borrowedItem->individualItemReturns as $return)
                            @if($return->remarks)
                            <strong>{{ $return->individualItem->qr_code }}</strong> - {{ $return->remarks }}<br>
                            @else
                            <strong>{{ $return->individualItem->qr_code }}</strong> - <span>Not Checked</span><br> <!-- Default text if no remarks -->
                            @endif
                            @endforeach
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



<!-- Modal for QR Code Scanner -->
<div id="qr-modal" class="mx-auto p-2 hidden fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm bg-black bg-opacity-50 transition-all duration-300 ease-in-out" style="font-family: 'Inter', sans-serif;">
    <div class="bg-white p-8 rounded-lg max-w-4xl w-full max-h-[680px] flex">

        <div class="h-full overflow-y-auto w-1/2">
            <table id="codeTable" class="display" style="width: 100%; height: 100%; border: 2px solid #ccc; border-collapse: collapse; table-layout: fixed;">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 40%;">QR Code</th>
                        <th style="text-align: center; width: 40%;">Status</th>
                        <th style="text-align: center; width: 20%;">Remarks</th> <!-- New column for Remarks -->
                    </tr>
                </thead>

                <tbody style="text-align: center;">
                    <!-- QR code data will be populated here dynamically -->
                </tbody>
            </table>
        </div>

        <div class="w-1/2 pl-4 flex flex-col justify-between" style="height: 400px;">
            <h2 class="text-xl mb-4 flex justify-between items-center">
                Scan QR Code
                <span id="request-counter" class="text-lg font-bold text-gray-700">0/0</span>
            </h2>

            <div id="scanner-container" class="flex justify-center" style="height: 100%;">
                <video id="video" autoplay class="w-full max-w-md h-auto border-2 border-gray-300"></video>
            </div>
            <div id="result" class="mt-2">Scanning for QR code...</div>

            <div class="flex gap-4 mt-4">
                <button class="px-4 py-2 bg-blue-500 text-white rounded w-1/2" onclick="closeQRScanner()">Close</button>
                <button id="approveButton" class="px-4 py-2 bg-green-500 text-white rounded w-1/2" disabled>Approve</button>
                <button class="px-4 py-2 bg-gray-500 text-white rounded w-1/2" onclick="undoAction()" id="undoButton" disabled>Undo</button>
            </div>
        </div>

    </div>
</div>





<script>
    $(document).ready(function() {
        $('#borrowedItemsTable').DataTable({
            scrollY: '420px',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true,
            "order": [
                [0, "desc"] // Sort by hidden ID column (index 0)
            ],
            "columnDefs": [{
                "targets": 0,
                "visible": false // Hide ID column
            }]
        });


        $('#codeTable').DataTable({
            paging: true,
            searching: true,
            ordering: false,
            pageLength: 10,
            lengthChange: false
        });

        $('[data-toggle="tooltip"]').tooltip();
    });

    let isScanning = false;
    let scannedQRCodeList = [];
    let scannedCount = 0;
    let totalRequestQuantity = 1;
    let scanLoopId = null;
    let highlightedRows = {}; // Store highlighted rows by QR code
    let returnDates = []; // Store return dates for each scanned QR code


    // Function to highlight the scanned row
    function highlightRow(qrCode) {
        // Find the row that matches the QR code
        const row = Array.from(document.querySelectorAll('#codeTable tbody tr')).find(row => row.cells[0].textContent.trim() === qrCode);
        if (row) {
            // Highlight the row by changing the background color
            row.style.backgroundColor = '#27D29C'; // Light green color for the highlight
            row.style.color = '#000'; // Make text black for readability
            row.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
            highlightedRows[qrCode] = row; // Save it by QR code
        }
    }

    // Function to remove highlight from the row
    function resetHighlight(rowOrCode = null) {
        if (!rowOrCode) {
            // Reset all rows
            const rows = document.querySelectorAll('#codeTable tbody tr');
            rows.forEach(row => {
                row.style.backgroundColor = ''; // Reset background color
                row.style.color = ''; // Reset text color
            });
        } else if (typeof rowOrCode === 'string' && highlightedRows[rowOrCode]) {
            // Reset only the specific row associated with the QR code
            const row = highlightedRows[rowOrCode];
            row.style.backgroundColor = ''; // Reset background color
            row.style.color = ''; // Reset text color
            delete highlightedRows[rowOrCode]; // Clean up the tracked highlight
        } else if (rowOrCode instanceof HTMLElement) {
            // Reset specific row passed as an HTMLElement
            rowOrCode.style.backgroundColor = '';
            rowOrCode.style.color = '';
        }
    }

    // Function to populate the table in the QR modal
    // Modify the returnItem function to pass the current returned count
    // Function to populate the table in the QR modal
    function returnItem(id) {
        $('#qr-modal').removeClass('hidden');
        $('#borrowedItemsTable button').prop('disabled', true);
        $('#qr-modal').data('item-id', id);
        $('#result').text('Scanning for QR code...');

        scannedQRCodeList = [];
        scannedCount = 0;
        document.getElementById('approveButton').disabled = true;
        document.getElementById('undoButton').disabled = true;

        // Fetch the list of borrowed items, including the count of already returned items
        $.ajax({
            url: '/admin/borrowed-items/list/' + id,
            method: 'GET',
            success: function(response) {
                const tableBody = $('#codeTable tbody');
                tableBody.empty();

                let alreadyReturnedCount = 0;

                // Iterate over the borrowed items and populate the table
                response.borrowedItems.forEach(item => {
                    let statusText = item.status;
                    let rowStyle = '';
                    let remarksDisabled = ''; // Default to not disabled

                    // Check if the item has been returned and display 'Returned' in the table
                    if (item.status === 'Available') {
                        statusText = 'Returned';
                        rowStyle = 'background-color: #90ee90; color: #000;';
                        alreadyReturnedCount++; // Increment the returned items count
                        remarksDisabled = 'disabled'; // Disable remarks dropdown for returned items
                    }

                    // Create the row with the dropdown for remarks
                    const row = `<tr style="${rowStyle}">
                    <td>${item.qr_code}</td>
                    <td>${statusText}</td>
                    <td>
                        <select class="remarks-dropdown" data-qr="${item.qr_code}" disabled ${remarksDisabled}>
                            <option value="Good">Good</option>
                            <option value="Damaged">Damaged</option>
                            <option value="Missing">Missing</option>
                            <option value="Not Checked">Not Checked</option>
                        </select>
                    </td>
                </tr>`;
                    tableBody.append(row);
                    // Disable remarks dropdown for all unscanned items
                    const lastRow = tableBody.find('tr').last()[0];
                    const dropdown = lastRow.querySelector('.remarks-dropdown');
                    if (dropdown && statusText !== 'Returned') {
                        dropdown.disabled = true;
                    }

                });

                totalRequestQuantity = response.borrowedItems.length;
                scannedCount = alreadyReturnedCount; // Set scannedCount to the already returned count
                $('#request-counter').text(`${scannedCount}/${totalRequestQuantity}`); // Update counter

                openQRScanner();
            },
            error: function(err) {
                console.error('Error fetching borrowed items:', err);
                Swal.fire('Error!', 'Unable to load borrowed items.', 'error');
            }
        });
    }





    function openQRScanner() {
        const video = document.getElementById('video');
        const resultText = document.getElementById('result');

        isScanning = true;
        navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "environment"
                }
            })
            .then(stream => {
                video.srcObject = stream;
                video.setAttribute('playsinline', true);
                video.play();
                video.addEventListener('playing', () => {
                    if (!scanLoopId) scanQRCode();
                });
            })
            .catch(err => {
                resultText.textContent = "Error accessing camera: " + err;
            });
    }

    let alertedQRCodeList = []; // Store QR codes that have already triggered an alert

    function scanQRCode() {
        const video = document.getElementById('video');
        const resultText = document.getElementById('result');
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        scanLoopId = setInterval(() => {
            if (!isScanning || !video.videoWidth || !video.videoHeight) return;

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const qrCode = jsQR(imageData.data, canvas.width, canvas.height);

            if (qrCode) {
                const code = qrCode.data.trim();
                resultText.textContent = 'QR Code detected: ' + code;

                if (!scannedQRCodeList.includes(code)) {
                    const matchedRow = Array.from(document.querySelectorAll('#codeTable tbody tr'))
                        .find(row => row.cells[0].textContent.trim() === code);

                    if (matchedRow) {
                        const statusCell = matchedRow.cells[1];
                        const status = statusCell.textContent.trim();

                        if (status === 'Returned') {
                            if (!alertedQRCodeList.includes(code)) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Item Already Returned',
                                    text: `The item with QR code ${code} has already been returned.`,
                                });
                                alertedQRCodeList.push(code);
                            }
                        } else {
                            // Automatically set the return date to the current date
                            const returnDate = new Date().toISOString().split('T')[0]; // Get current date (YYYY-MM-DD format)
                            returnDates.push(returnDate); // Save the return date for each scanned item

                            scannedQRCodeList.push(code);
                            statusCell.textContent = 'Returned';
                            scannedCount++;
                            $('#request-counter').text(`${scannedCount}/${totalRequestQuantity}`);

                            // ✅ Enable the remarks dropdown for the scanned QR
                            const remarksDropdown = matchedRow.querySelector('.remarks-dropdown');
                            if (remarksDropdown) {
                                remarksDropdown.disabled = false;
                            }


                            if (scannedCount >= totalRequestQuantity) {
                                document.getElementById('request-counter').style.color = 'green';
                                resultText.textContent = 'Scanning complete. All required QR codes have been scanned.';
                                stopScanning();
                            }

                            if (scannedQRCodeList.length === 1) {
                                document.getElementById('approveButton').disabled = false;
                            }

                            document.getElementById('undoButton').disabled = false;
                            highlightRow(code);
                        }
                    } else {
                        resultText.textContent = 'Invalid QR Code: Not in list.';
                    }
                }
            } else {
                resultText.textContent = 'Scanning for QR code...';
            }
        }, 300); // scan every 300ms
    }



    function stopScanning() {
        isScanning = false;
        if (scanLoopId) {
            clearInterval(scanLoopId);
            scanLoopId = null;
        }
    }

    function undoAction() {
        if (scannedQRCodeList.length > 0) {
            const lastCode = scannedQRCodeList.pop();
            const row = Array.from(document.querySelectorAll('#codeTable tbody tr'))
                .find(row => row.cells[0].textContent.trim() === lastCode);

            if (row) row.cells[1].textContent = 'Borrowed';

            scannedCount--;
            $('#request-counter').text(`${scannedCount}/${totalRequestQuantity}`);

            // Reset counter color if scanning is no longer complete
            if (scannedCount < totalRequestQuantity) {
                document.getElementById('request-counter').style.color = '';
            }

            document.getElementById('approveButton').disabled = true;
            if (scannedQRCodeList.length === 0) {
                document.getElementById('undoButton').disabled = true;
            }

            // Remove highlight from the undone row
            resetHighlight(lastCode);

            // Reset scanning state after undo
            if (scannedCount < totalRequestQuantity) {
                // Allow scanning again if not all QR codes have been scanned
                document.getElementById('result').textContent = 'Scanning for QR code...';
                // Reset the scanning state
                openQRScanner();
            }
        }
    }



    function closeQRScanner() {
        $('#qr-modal').addClass('hidden');
        const video = document.getElementById('video');
        const stream = video.srcObject;

        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            video.srcObject = null;
        }

        isScanning = false;
        if (scanLoopId) {
            clearInterval(scanLoopId);
            scanLoopId = null;
        }

        $('#borrowedItemsTable button').prop('disabled', false);
        $('#result').text('Scanning for QR code...');
        scannedQRCodeList = [];
        scannedCount = 0;
        document.getElementById('approveButton').disabled = true;
        document.getElementById('undoButton').disabled = true;

        // Reset counter color if scanning is incomplete
        if (scannedCount < totalRequestQuantity) {
            document.getElementById('request-counter').style.color = ''; // Reset color
        }
    }

    document.getElementById('approveButton').addEventListener('click', function() {
    const itemId = $('#qr-modal').data('item-id');
    
    // Collect remarks for each scanned QR code
    const remarks = scannedQRCodeList.map(qr => {
        const row = Array.from(document.querySelectorAll('#codeTable tbody tr'))
            .find(row => row.cells[0].textContent.trim() === qr);
        return row.querySelector('.remarks-dropdown').value;
    });

    // Show SweetAlert confirmation
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
            // Send the AJAX request to mark items as returned
            $.ajax({
                url: '/admin/return-items/mark/' + itemId,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    qr_codes: scannedQRCodeList, // Send the list of scanned QR codes
                    return_dates: returnDates, // Send the list of return dates for each item
                    remarks: remarks // Add remarks to the payload
                },
                success: function(response) {
                    Swal.fire('Returned!', 'The items have been returned.', 'success')
                        .then(() => {
                            closeQRScanner();
                            location.reload(); // Reload the page to reflect changes
                        });
                },
                error: function(err) {
                    Swal.fire('Error!', err.responseJSON.message, 'error');
                }
            });
        }
    });
});

</script>






@endsection