<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024">
    <title>Main System</title>

    <link rel="icon" href="../../frontend/public/images/bmsuiticon.png" type="image/png">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-inter">
    <div class="flex h-screen">
        <div class="fixed top-0 left-0 w-64 h-full bg-white p-6 overflow-y-auto flex flex-col">
            <!-- Sidebar Header -->
            <div class="flex gap-5 pb-5 border-b border-gray-200">
                <div class="w-11 h-11 rounded-full overflow-hidden">
                    <img src="../../frontend/public/images/users/user-placeholder.jpg" alt="User Image" class="w-full object-cover" />
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">User Name</p>
                    <p class="text-sm font-medium text-gray-500">user.email@example.com</p>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <div class="flex-1">
                <div class="space-y-5">
                    <ul class="space-y-2">
                        <li class="active">
                            <a href="#" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                                <i class="ph-bold ph-house-simple text-xl"></i>
                                <span class="flex-1 text-sm">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                                <i class="ph-bold ph-archive text-xl"></i>
                                <span class="flex-1 text-sm">Inventory Management</span>
                            </a>
                            <a href="{{ route('borrowing-slip.index') }}">
                    <i class="ph-bold ph-file-text text-xl"></i>
                    Borrowing Slip
                </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                                <i class="ph-bold ph-file-text text-xl"></i>
                                <span class="flex-1 text-sm">Records</span>
                            </a>
            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Account Section -->
            <div class="mt-auto">
                <div class="space-y-5">
                    <p class="text-sm font-medium text-gray-500 uppercase mb-3">Account</p>
                    <ul class="space-y-2">
                        <!-- For Admin only (this will be styled in the same way as the other items) -->
                        <li>
                            <a href="#" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                                <i class="ph-bold ph-user text-xl"></i>
                                <span class="flex-1 text-sm">Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="../../backend/views/logout.php" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-100 hover:text-black rounded-md">
                                <i class="ph-bold ph-sign-out text-xl"></i>
                                <span class="flex-1 text-sm">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>