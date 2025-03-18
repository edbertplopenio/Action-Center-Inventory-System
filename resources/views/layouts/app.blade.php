<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Main System')</title>

    <link rel="icon" href="/images/actioncenterlogo.png" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- External Libraries -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery (necessary for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.2.2/css/dataTables.min.css">

    <!-- DataTables Tailwind CSS Integration -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.2.2/css/dataTables.tailwindcss.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

    <!-- DataTables Tailwind Integration JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.2.2/js/dataTables.tailwindcss.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/phosphor-icons@latest/dist/phosphor-icons.min.css">



    <!-- Custom Styles (Ensures Sidebar Does Not Overlap Content) -->
    <style>
        .sidebar {
            width: 16rem;
            /* 64 Tailwind units */
        }

        .main-content {
            margin-left: 16rem;
            /* Ensures no overlap */
        }
    </style>
</head>

<body class="font-inter bg-gray-100" style="font-family: 'Inter', sans-serif;">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="fixed top-0 left-0 h-full bg-white p-6 overflow-y-auto flex flex-col shadow-lg sidebar">
            <!-- User Info -->
            <div class="flex gap-5 pb-5 border-b border-gray-200">
                <div class="w-11 h-11 rounded-full overflow-hidden relative flex items-center justify-center bg-gray-500 text-white">
                    @if(auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                        alt="User Image"
                        class="w-full h-full object-cover"
                        onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');" />
                    @endif

                    <div class="{{ auth()->user()->profile_picture ? 'hidden' : '' }} w-full h-full flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name, 0, 1)) }}
                    </div>
                </div>

                <div>
                    <p class="user-name text-xs font-medium mb-1" style="color:rgb(48, 47, 46);">{{ auth()->user()->first_name ?? 'First' }} {{ auth()->user()->last_name ?? 'Last' }}</p>
                    <p class="user-email text-xs font-medium" style="color:rgb(0, 0, 0);">{{ auth()->user()->email ?? 'user.email@example.com' }}</p>
                </div>

            </div>

            <script>
                // Function to adjust font size dynamically based on the text length
                function adjustFontSize() {
                    // Select the elements for name and email
                    const nameElement = document.querySelector('.user-name');
                    const emailElement = document.querySelector('.user-email');

                    // Set the default font size for both name and email
                    let defaultFontSizeName = 12; // Default font size for the name
                    let defaultFontSizeEmail = 9; // Default font size for the email

                    // If the name is too long, reduce the font size
                    if (nameElement && nameElement.textContent.length > 20) {
                        let newFontSize = defaultFontSizeName * (20 / nameElement.textContent.length);
                        nameElement.style.fontSize = `${newFontSize}px`;
                    } else {
                        nameElement.style.fontSize = `${defaultFontSizeName}px`;
                    }

                    // If the email is too long, reduce the font size
                    if (emailElement && emailElement.textContent.length > 30) {
                        let newFontSize = defaultFontSizeEmail * (30 / emailElement.textContent.length);
                        emailElement.style.fontSize = `${newFontSize}px`;
                    } else {
                        emailElement.style.fontSize = `${defaultFontSizeEmail}px`;
                    }
                }

                // Call the function on page load
                document.addEventListener('DOMContentLoaded', function() {
                    adjustFontSize();
                });
            </script>



            <!-- Navigation Menu -->
            <div class="flex-1 mt-5">
                <ul class="space-y-2">
                    <!-- Dashboard: Visible only to Admin -->
                    @if(Auth::user()->user_role == 'Admin')
                    <li class="{{ Request::routeIs('home') ? 'bg-[#7CD2F8] text-white rounded-xl' : 'text-gray-600' }}">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 rounded-xl">
                            <i class="ph-bold ph-house-simple text-xl"></i>
                            <span class="text-sm">Dashboard</span>
                        </a>
                    </li>
                    @endif

                    <!-- Admin Inventory Management: Visible only to Admin -->
                    @if(Auth::user()->user_role == 'Admin')
                    <li class="{{ Request::routeIs('admin.inventory.index') ? 'bg-[#7CD2F8] text-white rounded-xl' : 'text-gray-600' }}">
                        <a href="{{ route('admin.inventory.index') }}" class="flex items-center gap-3 p-3 rounded-xl">
                            <i class="ph-bold ph-archive text-xl"></i>
                            <span class="text-sm">Inventory Management</span>
                        </a>
                    </li>

                    <!-- Records: Visible only to Admin -->
                    <li class="{{ Request::routeIs('records.index') ? 'bg-[#7CD2F8] text-white rounded-xl' : 'text-gray-600' }}">
                        <a href="{{ route('records.index') }}" class="flex items-center gap-3 p-3 rounded-xl">
                            <i class="ph-bold ph-file-text text-xl"></i>
                            <span class="text-sm">Records</span>
                        </a>
                    </li>
                    @endif

                    <!-- Borrower Inventory Management: Visible only to Borrower -->
                    @if(Auth::user()->user_role == 'Borrower')
                    <li class="{{ Request::routeIs('borrower.inventory.index') ? 'bg-[#7CD2F8] text-white rounded-xl' : 'text-gray-600' }}">
                        <a href="{{ route('borrower.inventory.index') }}" class="flex items-center gap-3 p-3 rounded-xl">
                            <i class="ph-bold ph-archive text-xl"></i>
                            <span class="text-sm">Equipment Inventory</span>
                        </a>
                    </li>

                    <!-- Borrow Equipment: Visible only to Borrower -->
                    <li class="{{ Request::routeIs('borrower.borrow-equipment.index') ? 'bg-[#7CD2F8] text-white rounded-xl' : 'text-gray-600' }}">
                        <a href="{{ route('borrower.borrow-equipment.index') }}" class="flex items-center gap-3 p-3 rounded-xl">
                            <i class="ph-bold ph-file-text text-xl"></i> <!-- Borrow Equipment Icon -->
                            <span class="text-sm">Borrow Equipment</span>
                        </a>
                    </li>
                    @endif

                    <!-- Borrowing Request: Visible only to Admin -->
                    @if(Auth::user()->user_role == 'Admin')
                    <li class="{{ Request::routeIs('admin.borrowing-request.index') ? 'bg-[#7CD2F8] text-white rounded-xl' : 'text-gray-600' }}">
                        <a href="{{ route('admin.borrowing-request.index') }}" class="flex items-center gap-3 p-3 rounded-xl">
                            <i class="ph-bold ph-clipboard text-xl"></i>
                            <span class="text-sm">Borrowing Request</span>
                        </a>

                    </li>
                    @endif
                </ul>
            </div>



            <!-- Account Management -->
            <div class="mt-auto">
                <p class="text-sm font-medium text-gray-500 uppercase mb-3">Account</p>
                <ul class="space-y-2">
                    <!-- Show 'Users Management' only for Admin -->
                    @if(Auth::user()->user_role == 'Admin')
                    <li class="{{ Request::routeIs('users.index') ? 'bg-[#7CD2F8] text-white rounded-xl' : 'text-gray-600' }}">
                        <a href="{{ route('users.index') }}" class="flex items-center gap-3 p-3 rounded-xl">
                            <i class="ph-bold ph-users text-xl"></i>
                            <span class="text-sm">Users Management</span>
                        </a>
                    </li>
                    @endif

                    <!-- Show 'Profile' only for Borrowers -->
                    @if(Auth::user()->user_role == 'Borrower')
                    <li class="{{ Request::routeIs('profile.index') ? 'bg-[#7CD2F8] text-white rounded-xl' : 'text-gray-600' }}">
                        <a href="{{ route('profile.index') }}" class="flex items-center gap-3 p-3 rounded-xl">
                            <i class="ph-bold ph-user text-xl"></i>
                            <span class="text-sm">Profile</span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <button id="logout-btn" class="w-full flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-xl">
                            <i class="ph-bold ph-sign-out text-xl"></i>
                            <span class="text-sm">Logout</span>
                        </button>
                    </li>
                </ul>
            </div>


        </div>

        <!-- Main Content (Ensures Sidebar Does Not Overlap) -->
        <div class="flex-1 p-6 main-content">
            @yield('content')
        </div>
    </div>
</body>

<!-- Modal HTML Structure -->
<div id="logout-modal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                            <svg class="size-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-base font-semibold text-gray-900" id="modal-title">Log out</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to log out? You’ll need to log in again to access your account.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button id="confirm-logout" type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">Yes, Log Out</button>
                    <button id="cancel-logout" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Show the Modal and Handle Actions -->
<script>
    $(document).ready(function() {
        // Trigger the modal when the logout button is clicked
        $('#logout-btn').click(function(e) {
            e.preventDefault(); // Prevent the default action (form submission)

            // Show the modal
            $('#logout-modal').removeClass('hidden');

            // Handle the confirm logout button click
            $('#confirm-logout').click(function() {
                $('#logout-form').submit(); // Submit the logout form
            });

            // Handle the cancel logout button click
            $('#cancel-logout').click(function() {
                $('#logout-modal').addClass('hidden'); // Hide the modal
            });
        });
    });
</script>



<script>
    function getRandomColor() {
        // Generate a random color in hex format
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    function showInitialsWithRandomColor() {
        // Check if the random color already exists in localStorage
        let randomColor = localStorage.getItem('randomColor');

        if (!randomColor) {
            // If no color is stored, generate a new random color
            randomColor = getRandomColor();
            // Store the color in localStorage
            localStorage.setItem('randomColor', randomColor);
        }

        // Set background color of the initials div
        document.getElementById('initials-avatar').style.backgroundColor = randomColor;

        // Show the initials div
        document.getElementById('initials-avatar').style.display = 'flex';
    }

    // Call the function on page load to display the initials with the correct color
    showInitialsWithRandomColor();
</script>

</html>



<!-- YUNG PROFILE PIC AYUSIN MO SHAPE -->