<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Main System')</title>

    <link rel="icon" href="{{ asset('images/bmsuiticon.png') }}" type="image/png">

    <!-- External Libraries -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Custom Styles (Ensures Sidebar Does Not Overlap Content) -->
    <style>
        /* Ensures no scroll and full height for the page */
        html, body {
            height: 100%;
            overflow: hidden;
            margin: 0; /* Remove default margins */
        }

        .flex {
            display: flex;
            height: 100%; /* Ensure the main container takes full height */
        }

        .sidebar {
            width: 16rem; /* Sidebar width */
            height: 100%; /* Sidebar takes full height */
            position: fixed; /* Fix sidebar to the left */
        }

        .main-content {
            margin-left: 16rem; /* Make space for the sidebar */
            width: 100%;
            height: 100%; /* Full height */
            overflow: hidden; /* Ensure no scrolling inside main content */
            display: flex;
            flex-direction: column;
        }

        /* If content exceeds the available space, we ensure it doesn't scroll */
        .content-wrapper {
            flex: 1; /* This takes up the remaining space */
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body class="font-inter bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar bg-white p-6 overflow-y-auto shadow-lg">
            <!-- User Info -->
            <div class="flex gap-5 pb-5 border-b border-gray-200">
                <div class="w-11 h-11 rounded-full overflow-hidden">
                    <img src="{{ asset('images/users/user-placeholder.jpg') }}" alt="User Image" class="w-full object-cover" />
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">{{ auth()->user()->name ?? 'User Name' }}</p>
                    <p class="text-xs font-medium text-gray-500">{{ auth()->user()->email ?? 'user.email@example.com' }}</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="flex-1 mt-5">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                            <i class="ph-bold ph-house-simple text-xl"></i>
                            <span class="text-xs">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                            <i class="ph-bold ph-archive text-xl"></i>
                            <span class="text-xs">Inventory Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                            <i class="ph-bold ph-file-text text-xl"></i>
                            <span class="text-xs">Records</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Account Management -->
            <div class="mt-auto">
                <p class="text-xs font-medium text-gray-500 uppercase mb-3">Account</p>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                            <i class="ph-bold ph-user text-xl"></i>
                            <span class="text-xs">User Management</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                                <i class="ph-bold ph-sign-out text-xl"></i>
                                <span class="text-xs">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
