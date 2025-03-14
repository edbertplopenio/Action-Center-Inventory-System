@extends('layouts.app')

@section('title', 'Edit Borrowing Slip')

@section('content')
<div class="w-screen h-screen flex justify-center items-center p-4">
    <div class="bg-white p-6 shadow-lg rounded-lg w-full lg:w-3/4 xl:w-2/3 max-h-full overflow-hidden">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Edit Borrowing Slip</h2>

        <!-- The form to update borrowing slip -->
        <form method="POST" action="{{ route('borrowing-slip.update', $borrowingSlip->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Use PUT method for updates -->

            <!-- ID (hidden, as it's not editable) -->
            <input type="hidden" name="id" value="{{ $borrowingSlip->id }}">

            <!-- Name and Department Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 text-sm" value="{{ $borrowingSlip->name }}" required>
                </div>
                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                    <input type="text" name="department" id="department" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 text-sm" value="{{ $borrowingSlip->department }}" required>
                </div>
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 text-sm" value="{{ $borrowingSlip->email }}" required>
            </div>

            <!-- Responsible Person Field -->
            <div class="mb-4">
                <label for="responsible_person" class="block text-sm font-medium text-gray-700">Responsible Person</label>
                <input type="text" name="responsible_person" id="responsible_person" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 text-sm" value="{{ $borrowingSlip->responsible_person }}" required>
            </div>

            <!-- Item Code and Borrow Date Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="item_code" class="block text-sm font-medium text-gray-700">Item Code</label>
                    <input type="text" name="item_code" id="item_code" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 text-sm" value="{{ $borrowingSlip->item_code }}" required>
                </div>
                <div>
                    <label for="borrow_date" class="block text-sm font-medium text-gray-700">Borrow Date</label>
                    <input type="date" name="borrow_date" id="borrow_date" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 text-sm" value="{{ \Carbon\Carbon::parse($borrowingSlip->borrow_date)->format('Y-m-d') }}" required>
                </div>
            </div>

            <!-- Quantity and Due Date Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 text-sm" value="{{ $borrowingSlip->quantity }}" required>
                </div>
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 text-sm" value="{{ \Carbon\Carbon::parse($borrowingSlip->due_date)->format('Y-m-d') }}" required>
                </div>
            </div>

            <!-- Signature Field (optional) -->
            <div class="mb-4">
                <label for="signature" class="block text-sm font-medium text-gray-700">Signature (Optional)</label>
                <input type="file" name="signature" id="signature" class="form-input w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 text-sm" accept="image/*">

                <!-- If there's an existing signature, display it -->
                @if ($borrowingSlip->signature)
                    <div class="mt-2">
                        <label class="block text-xs text-gray-600">Current Signature:</label>
                        <img src="{{ Storage::url($borrowingSlip->signature) }}" alt="Signature" class="w-20 h-20 object-cover mt-2">
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-4">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none transition duration-300 text-sm">Update Borrowing Slip</button>
                <a href="{{ route('borrowing-slip.index') }}" class="px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 focus:outline-none ml-4 text-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
    <style>
    /* Ensure no scrollbars */
    body, html {
        overflow: hidden; /* Disable all scrolling */
        height: 100%;
        margin: 0;
    }

    /* Custom styling for the form */
    .form-input {
        border-color: #D1D5DB;
        padding: 8px;
        border-radius: 8px;
        font-size: 14px;
        width: 100%; /* Ensures inputs take full width */
    }

    .form-input:focus {
        border-color: #4C51BF;
        outline: none;
        box-shadow: 0 0 5px rgba(76, 81, 191, 0.3);
    }

    .form-input::placeholder {
        color: #A0AEC0;
    }

    .bg-indigo-600:hover {
        background-color: #4C51BF;
    }

    .bg-gray-400:hover {
        background-color: #E2E8F0;
    }

    /* Form container settings */
    .form-container {
        background-color: white;
        padding: 16px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 700px;
        height: auto;
    }

    /* Adjust buttons */
    .submit-button {
        background-color: #4C51BF;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .submit-button:hover {
        background-color: #434190;
    }

    /* Remove all scrollbars for mobile */
    @media (max-width: 768px) {
        .form-container {
            padding: 10px;
        }

        .submit-button {
            width: 100%;
        }
    }
    </style>
@endsection