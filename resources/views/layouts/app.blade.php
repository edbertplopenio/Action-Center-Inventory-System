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

        /* Profile Section */
        .profile-section {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 1rem;
        }

        .profile-section img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 15px;
        }

        .profile-section div {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .profile-section div p {
            margin: 0;
            font-size: 0.875rem;
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

        /* Logout Section */
        .logout-section {
            margin-top: auto;
            padding-top: 1rem;
        }

        /* Make sidebar responsive */
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
                    <p class="text-lg font-medium text-gray-600 mb-1">{{ auth()->user()->name ?? 'User Name' }}</p>
                    <p class="text-sm font-medium text-gray-500">{{ auth()->user()->email ?? 'user.email@example.com' }}</p>
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
    </ul>
</div>

            <!-- Logout Section -->
            <div class="logout-section flex justify-center mt-auto px-4">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <button type="button" id="logout-btn"
                    class="w-full flex items-center gap-3 p-3 text-gray-700 hover:bg-gray-100 hover:text-red-600 rounded-md">
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

        // Fix logout button function
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("logout-btn").addEventListener("click", function () {
                document.getElementById("logout-form").submit();
            });
        });
    </script>

</body>

</html>
