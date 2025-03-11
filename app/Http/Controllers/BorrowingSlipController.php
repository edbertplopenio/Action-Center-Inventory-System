<?php

namespace App\Http\Controllers;

use App\Models\BorrowingSlip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage for file handling

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
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Signature is optional on create
        ]);

        // Handle the file upload if a signature is provided
        $signaturePath = null;
        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            $signaturePath = $signature->storeAs('public/signatures', time() . '.' . $signature->extension());
        }

        // Create the borrowing slip
        BorrowingSlip::create([
            'name' => $request->name,
            'department' => $request->department,
            'email' => $request->email,
            'responsible_person' => $request->responsible_person,
            'item_code' => $request->item_code,
            'borrow_date' => $request->borrow_date,
            'quantity' => $request->quantity,
            'due_date' => $request->due_date,
            'signature' => $signaturePath,
        ]);

        return redirect()->route('borrowing-slip.index')->with('success', 'Borrowing Slip Created Successfully!');
    }

    public function destroy($id)
    {
        $slip = BorrowingSlip::findOrFail($id);

        // Delete the signature file if it exists
        if ($slip->signature && Storage::exists($slip->signature)) {
            Storage::delete($slip->signature);
        }

        $slip->delete();

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        // Fetch the borrowing slip to edit
        $borrowingSlip = BorrowingSlip::findOrFail($id);

        // Return the edit view with borrowing slip data
        return view('borrowing-slip.edit', compact('borrowingSlip'));
    }

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
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Signature is optional during update
        ]);

        // Find the borrowing slip
        $borrowingSlip = BorrowingSlip::findOrFail($id);

        // Handle the file upload if a new signature is provided
        if ($request->hasFile('signature')) {
            // Delete old signature if exists
            if ($borrowingSlip->signature && Storage::exists($borrowingSlip->signature)) {
                Storage::delete($borrowingSlip->signature);
            }

            // Store the new signature
            $signature = $request->file('signature');
            $signaturePath = $signature->storeAs('public/signatures', time() . '.' . $signature->extension());

            // Update signature path in the request
            $borrowingSlip->signature = $signaturePath;
        }

        // Update the borrowing slip fields
        $borrowingSlip->update([
            'name' => $request->name,
            'department' => $request->department,
            'email' => $request->email,
            'responsible_person' => $request->responsible_person,
            'item_code' => $request->item_code,
            'borrow_date' => $request->borrow_date,
            'quantity' => $request->quantity,
            'due_date' => $request->due_date,
        ]);

        // Save changes
        $borrowingSlip->save();

        return redirect()->route('borrowing-slip.index')->with('success', 'Borrowing Slip Updated Successfully!');
    }
}
