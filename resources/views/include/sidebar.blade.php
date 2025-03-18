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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

    <!-- Custom Styles -->
    <style>
        .sidebar {
            width: 20rem; /* Sidebar width */
            height: 100vh;
            background-color: white;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .main-content {
            margin-left: 20rem;
            padding: 2rem;
        }

        /* Profile Section */
        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-bottom: 1rem;
            border-bottom: 1px solid #E5E7EB;
            margin-bottom: 1rem;
        }

        .profile-section img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .profile-section div p {
            margin: 0;
            font-size: 1rem;
            color: #6B7280;
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
            transition: background-color 0.3s ease;
        }

        .sidebar-links a:hover {
            background-color: #F3F4F6;
            color: #000;
        }

        .sidebar-links i {
            margin-right: 10px;
        }

        /* Logout Section */
        .logout-section {
            margin-top: auto;
            padding-top: 1rem;
        }

        /* Logout Button */
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

        /* Responsive Sidebar */
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
            <div class="profile-section px-4">
                <div class="w-12 h-12 rounded-full overflow-hidden">
                    <img src="{{ asset('images/users/user-placeholder.jpg') }}" alt="User Image"
                        class="w-full object-cover" onerror="this.style.display='none'; showInitialsWithRandomColor();" />
                    <div id="initials-avatar" class="w-full h-full text-white flex items-center justify-center text-xs font-bold"
                        style="display:none;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->name, strpos(auth()->user()->name, ' ') + 1, 1)) }}
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">{{ auth()->user()->name ?? 'User Name' }}</p>
                    <p class="text-xs font-medium text-gray-500">{{ auth()->user()->email ?? 'user.email@example.com' }}</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="sidebar-links px-4">
                <a href="{{ route('home') }}">
                    <i class="ph-bold ph-house-simple text-xl"></i>
                    Dashboard
                </a>
                <a href="{{ route('inventory.index') }}">
                    <i class="ph-bold ph-archive text-xl"></i>
                    Inventory Management
                </a>
                <a href="{{ route('borrowing-slip.index') }}">
                    <i class="ph-bold ph-file-text text-xl"></i>
                    Borrowing Slip
                </a>
            </div>

<!-- Account Section -->
<div class="mt-auto px-4">
    <div class="space-y-5">
        <p class="text-sm font-medium text-gray-500 uppercase mb-3">Account</p>
        <ul class="space-y-2">
            <!-- Logout Button -->
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <button type="button" onclick="document.getElementById('logout-form').submit();"
                    class="w-full flex items-center gap-3 p-3 text-gray-700 hover:bg-gray-100 hover:text-red-600 rounded-md">
                    <i class="ph-bold ph-sign-out text-xl"></i>
                    <span class="flex-1 text-sm">Logout</span>
                </button>
            </li>
        </ul>
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
