<form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <!-- Item Name -->
    <div>
        <label for="item-name" class="block font-medium text-gray-700">Item Name:</label>
        <input type="text" id="item-name" name="item_name" class="w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Category -->
    <div>
        <label for="category" class="block font-medium text-gray-700">Category:</label>
        <input type="text" id="category" name="category" class="w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Quantity -->
    <div>
        <label for="quantity" class="block font-medium text-gray-700">Quantity:</label>
        <input type="number" id="quantity" name="quantity" class="w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Unit -->
    <div>
        <label for="unit" class="block font-medium text-gray-700">Unit:</label>
        <input type="text" id="unit" name="unit" class="w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block font-medium text-gray-700">Description:</label>
        <textarea id="description" name="description" rows="4" class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
    </div>

    <!-- Storage Location -->
    <div>
        <label for="storage-location" class="block font-medium text-gray-700">Storage Location:</label>
        <input type="text" id="storage-location" name="storage_location" class="w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Arrival Date -->
    <div>
        <label for="arrival-date" class="block font-medium text-gray-700">Arrival Date:</label>
        <input type="date" id="arrival-date" name="arrival_date" class="w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Purchase Date -->
    <div>
        <label for="purchase-date" class="block font-medium text-gray-700">Date Purchased:</label>
        <input type="date" id="purchase-date" name="purchase_date" class="w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Status -->
    <div>
        <label for="status" class="block font-medium text-gray-700">Status:</label>
        <input type="text" id="status" name="status" class="w-full p-2 border border-gray-300 rounded-md" required>
    </div>

    <!-- Image -->
    <div>
        <label for="image" class="block font-medium text-gray-700">Image:</label>
        <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-md">
    </div>

    <!-- Action Buttons -->
    <div class="mt-4 flex justify-between">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Add Item</button>
        <a href="{{ url()->previous() }}" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 text-center">Cancel</a>
    </div>
</form>
