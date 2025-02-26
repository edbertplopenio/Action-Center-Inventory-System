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

        <!-- Display success message if exists -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Item creation form -->
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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

            <!-- Quantity and Unit -->
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-semibold text-black mb-2">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Unit -->
            <div class="mb-4">
                <label for="unit" class="block text-sm font-semibold text-black mb-2">Unit</label>
                <input type="text" id="unit" name="unit" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-semibold text-black mb-2">Description</label>
                <textarea id="description" name="description" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required></textarea>
            </div>

            <!-- Storage Location -->
            <div class="mb-4">
                <label for="storage_location" class="block text-sm font-semibold text-black mb-2">Storage Location</label>
                <input type="text" id="storage_location" name="storage_location" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Arrival Date -->
            <div class="mb-4">
                <label for="arrival_date" class="block text-sm font-semibold text-black mb-2">Arrival Date</label>
                <input type="date" id="arrival_date" name="arrival_date" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Date Purchased -->
            <div class="mb-4">
                <label for="date_purchased" class="block text-sm font-semibold text-black mb-2">Date Purchased</label>
                <input type="date" id="date_purchased" name="date_purchased" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-semibold text-black mb-2">Status</label>
                <select id="status" name="status" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500" required>
                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
            </div>

            <!-- Image -->
            <div class="mb-4">
                <label for="image_url" class="block text-sm font-semibold text-black mb-2">Image (Optional)</label>
                <input type="file" id="image_url" name="image_url" class="w-full p-2 border border-gray-400 rounded-md bg-transparent text-black focus:ring-2 focus:ring-red-500 focus:border-red-500">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-between mt-4">
                <button type="reset" class="px-4 py-2 bg-green-400 text-black rounded-md transition duration-300 hover:bg-green-600 hover:text-white">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-400 text-black rounded-md transition duration-300 hover:bg-green-600 hover:text-white">Save</button>
            </div>
        </form>
    </div>
</body>
</html>
