<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Main System')</title>

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
                <div class="w-11 h-11 rounded-full overflow-hidden">
                    <!-- Check if the image exists, else show initials -->
                    <img src="{{ asset('images/users/user-placeholder.jpg') }}" alt="User Image" class="w-full object-cover" onerror="this.style.display='none'; showInitialsWithRandomColor();" />
                    <div id="initials-avatar" class="w-full h-full text-white flex items-center justify-center text-xs font-bold" style="display:none;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->name, strpos(auth()->user()->name, ' ') + 1, 1)) }}
                    </div>
                </div>

                <div>
                    <!-- Adjusted font size for username and email -->
                    <p class="text-xs font-medium text-gray-500 mb-1">{{ auth()->user()->name ?? 'User Name' }}</p>
                    <p class="text-xs font-medium text-gray-500">{{ auth()->user()->email ?? 'user.email@example.com' }}</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="flex-1 mt-5">
                <ul class="space-y-2">
                    <li class="{{ Request::routeIs('home') ? 'bg-[#EBF8FD] text-black' : 'text-gray-600' }}">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 rounded-md">
                            <i class="ph-bold ph-house-simple text-xl"></i>
                            <span class="text-sm">Dashboard</span>
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('inventory.index') ? 'bg-[#EBF8FD] text-black' : 'text-gray-600' }}">
                        <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 p-3 rounded-md">
                            <i class="ph-bold ph-archive text-xl"></i>
                            <span class="text-sm">Inventory Management</span>
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('records.index') ? 'bg-[#EBF8FD] text-black' : 'text-gray-600' }}">
                        <a href="{{ route('records.index') }}" class="flex items-center gap-3 p-3 rounded-md">
                            <i class="ph-bold ph-file-text text-xl"></i>
                            <span class="text-sm">Records</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Account Management -->
            <div class="mt-auto">
                <p class="text-sm font-medium text-gray-500 uppercase mb-3">Account</p>
                <ul class="space-y-2">
                    <li class="{{ Request::routeIs('users.index') ? 'bg-[#EBF8FD] text-black' : 'text-gray-600' }}">
                        <a href="{{ route('users.index') }}" class="flex items-center gap-3 p-3 rounded-md">
                            <i class="ph-bold ph-users text-xl"></i>
                            <span class="text-sm">Users Management</span>
                        </a>
                    </li>

                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <button id="logout-btn" class="w-full flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
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

<script>
    // Wait until the document is fully loaded
    $(document).ready(function() {
        // Attach the click event handler to the logout button
        $('#logout-btn').click(function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Show SweetAlert2 confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to log out?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, log out!',
                cancelButtonText: 'No, cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, submit the logout form
                    $('#logout-form').submit();
                }
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




