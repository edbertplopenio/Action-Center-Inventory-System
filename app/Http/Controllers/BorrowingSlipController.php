<?php

namespace App\Http\Controllers;

use App\Models\BorrowingSlip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import the Storage facade

class BorrowingSlipController extends Controller
{
    public function index()
    {
        // Fetch all borrowing slips from the database
        $borrowingSlips = BorrowingSlip::all();
        return view('borrowing-slip.index', compact('borrowingSlips'));
    }

    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string',
            'department' => 'required|string',
            'email' => 'required|email',
            'responsible_person' => 'required|string',
            'item_code' => 'required|string',
            'borrow_date' => 'required|date',
            'quantity' => 'required|integer',
            'due_date' => 'required|date',
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle the file upload if there's a signature
        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            
            // Store the file in the 'public/signatures' directory
            $path = $signature->storeAs('public/signatures', time() . '.' . $signature->extension());

            // Save the file path to the database
            $request->merge(['signature' => $path]); // Add the file path to the request data
        }

        // Create and store the new borrowing slip
        BorrowingSlip::create($request->all());

        // Redirect back with a success message
        return redirect()->route('borrowing-slip.index')->with('success', 'Borrowing Slip Created Successfully!');
    }

    public function destroy($id)
    {
        $slip = BorrowingSlip::findOrFail($id);
        $slip->delete();

        return response()->json(['success' => true]);
    }

    // Update method to handle editing a borrowing slip
    public function update(Request $request, $id)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string',
            'department' => 'required|string',
            'email' => 'required|email',
            'responsible_person' => 'required|string',
            'item_code' => 'required|string',
            'borrow_date' => 'required|date',
            'quantity' => 'required|integer',
            'due_date' => 'required|date',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image (signature is optional during update)
        ]);

        // Find the existing borrowing slip
        $borrowingSlip = BorrowingSlip::findOrFail($id);

        // If a new signature file is uploaded, handle the file upload
        if ($request->hasFile('signature')) {
            // Delete the old signature file if it exists
            if ($borrowingSlip->signature) {
                Storage::delete($borrowingSlip->signature);
            }

            $signature = $request->file('signature');
            $path = $signature->storeAs('public/signatures', time() . '.' . $signature->extension());
            $request->merge(['signature' => $path]); // Add the file path to the request data
        } else {
            // If no new signature is uploaded, keep the old one
            $request->merge(['signature' => $borrowingSlip->signature]);
        }

        // Update the borrowing slip with the new data
        $borrowingSlip->update($request->all());

        // Redirect back with a success message
        return redirect()->route('borrowing-slip.index')->with('success', 'Borrowing Slip Updated Successfully!');
    }
}
