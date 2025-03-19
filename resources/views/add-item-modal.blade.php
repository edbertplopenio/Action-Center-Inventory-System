
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="DRRM Equipment">DRRM Equipment</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Emergency Kits">Emergency Kits</option>
                            <option value="Other Items">Other Items</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>

                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="storage_location" class="form-label">Storage Location</label>
                        <input type="text" class="form-control" id="storage_location" name="storage_location" required>
                    </div>

                    <div class="mb-3">
                        <label for="arrival_date" class="form-label">Arrival Date</label>
                        <input type="date" class="form-control" id="arrival_date" name="arrival_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="date_purchased" class="form-label">Date Purchased</label>
                        <input type="date" class="form-control" id="date_purchased" name="date_purchased" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
