
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024">
    <title>Main System</title>

    <link rel="icon" href="../../frontend/public/images/bmsuiticon.png" type="image/png">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"></script> <!-- Include jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="head">
                <div class="user-img">
                    <img src="../../frontend/public/images/users/default-user.jpg" alt="User Image" />
                </div>
                <div class="user-details">
                    <p class="title">User Role</p>
                    <p class="name">User Name</p>
                </div>
            </div>
            <div class="nav">
                <div class="menu">
                    <ul>
                        <li class="active" id="dashboard-item">
                            <a href="#" id="dashboard-link">
                                <i class="icon ph-bold ph-house-simple"></i>
                                <span class="text">Dashboard</span>
                            </a>
                        </li>
                        <li id="inventory-item">
                            <a href="#" id="inventory-link">
                                <i class="icon ph-bold ph-archive"></i>
                                <span class="text">Inventory</span>
                            </a>
                        </li>
                        <li id="records-item">
                            <a href="#" id="records-link">
                                <i class="icon ph-bold ph-file-text"></i>
                                <span class="text">Records</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="account-section">
                <div class="menu">
                    <p class="title">Account</p>
                    <ul>
                        <li id="user-account-item">
                            <a href="#" id="user-account-link">
                                <i class="icon ph-bold ph-user"></i>
                                <span class="text">User Management</span>
                            </a>
                        </li>
                        <li id="logout-item">
                            <a href="#" id="logout-link">
                                <i class="icon ph-bold ph-sign-out"></i>
                                <span class="text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="main-content" id="main-content">
            <!-- Dashboard content will be loaded here by default -->
        </div>
    </div>

    <!-- JavaScript to dynamically load content -->
    <script>
        $(document).ready(function() {
            // Load dashboard content by default when the page is loaded
            $('#main-content').load('dashboard.html');

            // Function to handle active class toggle
            function setActive(itemId) {
                // Remove active class from all menu items
                $('.menu ul li').removeClass('active');
                // Add active class to the clicked menu item
                $('#' + itemId).addClass('active');
            }

            // Use delegated event listeners for dynamically loaded content
            $('.menu').on('click', 'a', function(e) {
                const linkId = $(this).attr('id');
                let contentUrl = '';

                // Only prevent default for in-app links
                if (linkId !== 'logout-link') {
                    e.preventDefault();
                }

                switch (linkId) {
                    case 'dashboard-link':
                        contentUrl = 'dashboard.html';
                        setActive('dashboard-item');
                        break;
                    case 'inventory-link':
                        contentUrl = 'inventory.html';
                        setActive('inventory-item');
                        break;
                    case 'records-link':
                        contentUrl = 'records.html';
                        setActive('records-item');
                        break;
                    case 'user-account-link':
                        contentUrl = 'user_management.html';
                        setActive('user-account-item');
                        break;
                    default:
                        return; // Do nothing if the link ID is not recognized
                }

                if (contentUrl) {
                    $('#main-content').load(contentUrl, function(response, status, xhr) {
                        if (status === "error") {
                            console.error(`Error loading content: ${xhr.statusText}`);
                        } else {
                            console.log(`Loaded content from ${contentUrl}`);
                            // Re-initialize charts after loading new content
                            initializeCharts(); // This will ensure charts are reinitialized after each content load
                            // Re-initialize checkboxes after loading new content
                            initializeCheckboxes();
                        }
                    });
                }
            });

            // Account section links (example for logout link)
            $('#logout-link').on('click', function(e) {
                e.preventDefault(); // Prevent the default logout behavior

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to logout?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, logout!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to logout page
                        window.location.href = 'logout.html';
                    }
                });
            });
        });
    </script>

</body>

</html>








<style>
    @import url('https://fonts.googleapis.com/css?family=Inter:100,200,300,regular,500,600,700,800,900');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: 'Inter', sans-serif;
    }

    .container {
        display: flex;
        height: 100vh;
        /* Ensure the container takes full height */
        flex-direction: row;
        /* Make sure the flex direction is row */
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 256px;
        height: 100%;
        background-color: white;
        padding: 24px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .sidebar .head {
        display: flex;
        gap: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f6f6f6;
    }

    .user-img {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        overflow: hidden;
    }

    .user-img img {
        width: 100%;
        object-fit: cover;
    }

    .user-details .title {
        font-size: 12px;
        font-weight: 500;
        color: #757575;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .user-details .name {
        font-size: 14px;
        font-weight: 500;
    }

    .nav {
        flex: 1;
    }

    .menu .title {
        font-size: 12px;
        font-weight: 500;
        color: #757575;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .menu ul li {
        list-style: none;
        margin-bottom: 10px;
    }

    .menu ul li a {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
        color: #757575;
        text-decoration: none;
        padding: 12px 8px;
        transition: all 0.3s;
    }

    .menu ul li a:hover,
    .menu ul li.active>a {
        color: #000;
        background-color: #f6f6f6;
    }

    .menu ul li .icon {
        font-size: 20px;
    }

    .menu ul li .text {
        flex: 1;
    }

    .menu ul li .arrow {
        font-size: 14px;
        transition: transform 0.3s ease;
        /* Ensure the arrow smoothly rotates */
    }

    .menu ul li.active .arrow {
        transform: rotate(180deg);
        /* Rotate the arrow when the menu item is active */
    }

    .menu .sub-menu {
        display: none;
        margin-left: 20px;
        padding-left: 20px;
        padding-top: 5px;
        border-left: 1px solid #f6f6f6;
    }

    .menu .sub-menu li a {
        padding: 10px 8px;
        font-size: 12px;
    }

    /* Highlight active submenu item */
    .menu .sub-menu li a.active {
        background-color: #dcdcdc;
        /* Highlight color for active submenu item */
        color: #000;
        /* Text color for active submenu item */
    }

    .menu:not(:last-child) {
        padding-bottom: 10px;
        margin-bottom: 20px;
        border-bottom: 2px solid #f6f6f6;
    }

    /* Account section styling */
    .account-section {
        margin-top: auto;
        /* Pushes the account section to the bottom of the sidebar */
    }

    .account-section .menu {
        padding-top: 20px;
        /* Space above the account section */
        border-top: 2px solid #f6f6f6;
    }

    .account-section ul {
        padding-top: 10px;
    }

    /* Main content styling */
    .main-content {
        margin-left: 256px;
        /* Ensure the content starts next to the sidebar */
        padding: 20px;
        /* Optional padding for some space around the content */
        width: calc(100% - 256px);
        /* Adjust width to fill remaining space */
    }
</style>