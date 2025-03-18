@extends('layouts.app')

@section('content')
    <h2>Edit Item</h2>
    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Item Name -->
        <label for="name">Item Name</label>
        <input type="text" name="name" id="name" value="{{ $item->name }}" required>

        <!-- Category -->
        <label for="category">Category</label>
        <select name="category" id="category" required>
            <option value="DRRM Equipment" {{ $item->category == 'DRRM Equipment' ? 'selected' : '' }}>DRRM Equipment</option>
            <option value="Office Supplies" {{ $item->category == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
            <option value="Emergency Kits" {{ $item->category == 'Emergency Kits' ? 'selected' : '' }}>Emergency Kits</option>
            <option value="Other Item" {{ $item->category == 'Other Item' ? 'selected' : '' }}>Other Item</option>
        </select>

        <!-- Quantity -->
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" value="{{ $item->quantity }}" required>

        <!-- Add other fields like unit, description, etc. -->

        <!-- Image -->
        <label for="image_url">Image</label>
        <input type="file" name="image_url" id="image_url">

        <button type="submit">Update Item</button>
    </form>
@endsection
