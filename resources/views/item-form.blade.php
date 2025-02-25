<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Inventory Item</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-300">
    <div class="w-full max-w-lg p-6 bg-gradient-to-b from-red-700 to-white border-4 border-white rounded-lg shadow-lg">
        <h2 class="text-center italic font-bold text-black text-xl mb-4">Add New Inventory Item</h2>

        <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data">
            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-black mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category" class="block text-sm font-semibold text-black mb-2">Category</label>
                <select id="category" name="category" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                    <option value="">Select Category</option>
                    <option value="Office Supplies">Office Supplies</option>
                    <option value="First Aid">First Aid</option>
                    <option value="DRRM Equipment">DRRM Equipment</option>
                </select>
            </div>

            <!-- Product Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-semibold text-black mb-2">Product Description</label>
                <input type="text" id="description" name="description" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Date of Purchase & Date Added -->
            <div class="flex gap-4">
                <div class="mb-4 w-1/2">
                    <label for="date_purchase" class="block text-sm font-semibold text-black mb-2">Date of Purchase</label>
                    <input type="date" id="date_purchase" name="date_purchase" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>
                <div class="mb-4 w-1/2">
                    <label for="date_added" class="block text-sm font-semibold text-black mb-2">Date Added</label>
                    <input type="date" id="date_added" name="date_added" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>
            </div>

            <!-- Unit, Status, Quantity -->
            <div class="flex gap-4">
                <div class="mb-4 w-1/3">
                    <label for="unit" class="block text-sm font-semibold text-black mb-2">Unit</label>
                    <input type="text" id="unit" name="unit" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>
                <div class="mb-4 w-1/3">
                    <label for="status" class="block text-sm font-semibold text-black mb-2">Status</label>
                    <select id="status" name="status" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                        <option value="">Select Status</option>
                        <option value="Available">Available</option>
                        <option value="Unavailable">Unavailable</option>
                    </select>
                </div>
                <div class="mb-4 w-1/3">
                    <label for="quantity" class="block text-sm font-semibold text-black mb-2">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                </div>
            </div>

            <!-- Image -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-semibold text-black mb-2">Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Storage Location -->
            <div class="mb-4">
                <label for="storage_location" class="block text-sm font-semibold text-black mb-2">Storage Location</label>
                <input type="text" id="storage_location" name="storage_location" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between mt-4">
                <button type="reset" class="px-4 py-2 bg-green-400 text-black rounded-md transition duration-300 hover:bg-green-600 hover:text-white">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-400 text-black rounded-md transition duration-300 hover:bg-green-600 hover:text-white" onclick="showNotification(event)">Save</button>
            </div>
        </form>

        <!-- Notification -->
        <div id="notification" class="hidden fixed top-5 right-5 bg-green-500 text-white p-4 rounded-md shadow-md">
            Item successfully saved!
        </div>
    </div>

    <script>
        function showNotification(event) {
            event.preventDefault(); // Prevent actual form submission

            // Show notification
            const notification = document.getElementById("notification");
            notification.classList.remove("hidden");

            // Clear the form fields
            document.querySelector("form").reset();

            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.add("hidden");
            }, 3000);
        }
        
    </script>
</body>
</html>