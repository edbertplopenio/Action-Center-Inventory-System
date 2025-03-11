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

    <!-- Custom Styles -->
    <style>
        .sidebar {
            width: 20rem;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: white;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            padding-top: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-bottom: 2rem;
        }

        .main-content {
            margin-left: 20rem;
            padding: 2rem;
        }

        /* Profile Section - Horizontal Layout */
        .profile-section {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 1rem;
        }

        .profile-section img {
            width: 70px; /* Profile image size */
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 15px;
        }

        .profile-section div {
            display: flex;
            flex-direction: column; /* Keep name and email vertically aligned */
            justify-content: center;
        }

        .profile-section div p {
            margin: 0;
            font-size: 0.875rem; /* Slightly smaller font size for readability */
            color: #4B5563;
        }

        .profile-section div p:first-child {
            font-weight: bold;
        }

        /* Sidebar Links */
        .sidebar-links a {
            display: flex;
            align-items: center;
            padding: 12px;
            color: #4B5563;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar-links a:hover {
            background-color: #F3F4F6;
            color: #000;
        }

        .sidebar-links i {
            margin-right: 10px;
        }

        /* Footer section for logout */
        .logout-section {
            margin-top: auto;
            padding-top: 1rem;
        }

        /* Button Styles */
        #logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            padding: 12px;
            color: #4B5563;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        #logout-btn:hover {
            background-color: #F3F4F6;
            color: black;
        }

        /* Make sure the sidebar is responsive */
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 16rem;
            }

            .main-content {
                margin-left: 16rem;
            }
        }
    </style>
</head>

<body class="font-inter bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Profile Section -->
            <div class="profile-section">
                <div class="w-16 h-16 rounded-full overflow-hidden">
                    <!-- Profile image with fallback initials -->
                    <img src="{{ asset('images/users/user-placeholder.jpg') }}" alt="User Image" class="w-full object-cover" onerror="this.style.display='none'; showInitialsWithRandomColor();" />
                    <div id="initials-avatar" class="w-full h-full text-white flex items-center justify-center text-lg font-bold" style="display:none;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->name, strpos(auth()->user()->name, ' ') + 1, 1)) }}
                    </div>
                </div>
                <div>
                    <p class="text-lg font-medium text-gray-600 mb-1">{{ auth()->user()->name ?? 'User Name' }}</p>
                    <p class="text-sm font-medium text-gray-500">{{ auth()->user()->email ?? 'user.email@example.com' }}</p>
                </div>
            </div>
<!-- Navigation Links -->
<div class="sidebar-links flex flex-col justify-start space-y-2">
        <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
            <i class="ph-bold ph-house-simple text-xl"></i>
            Dashboard
        </a>
        <a href="{{ route('inventory.index') }}" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
            <i class="ph-bold ph-archive text-xl"></i>
            Inventory Management
        </a>
        <a href="{{ route('borrowing-slip.index') }}" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
            <i class="ph-bold ph-file-text text-xl"></i>
            Borrowing Slip
        </a>
    </div>

    <!-- Logout Section -->
    <div class="logout-section flex justify-center mt-auto">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <button id="logout-btn" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
            <i class="ph-bold ph-sign-out text-xl"></i>
            Logout
        </button>
    </div>
</div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <script>
        // Fallback for initials when no image is provided
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function showInitialsWithRandomColor() {
            let randomColor = localStorage.getItem('randomColor');
            if (!randomColor) {
                randomColor = getRandomColor();
                localStorage.setItem('randomColor', randomColor);
            }
            document.getElementById('initials-avatar').style.backgroundColor = randomColor;
            document.getElementById('initials-avatar').style.display = 'flex';
        }

        showInitialsWithRandomColor();
    </script>

</body>

</html>
