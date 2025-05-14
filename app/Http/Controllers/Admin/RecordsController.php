<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Record;
use Illuminate\Support\Facades\Log; // Import Log for debugging

class RecordsController extends Controller
{
    /**
     * Display a listing of the records.
     */
    public function index()
    {
        // Fetch all records where status is not 'archived'
        $records = Record::where('status', '!=', 'archived')->get();
        return view('admin.records.index', compact('records'));
    }

    /**
     * Store a newly created record in storage.
     */
    public function store(Request $request)
    {
        // Log incoming request
        Log::info('Incoming Request Data:', $request->all());

        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'related_documents' => 'nullable|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2100',
            'end_year' => 'nullable|integer|min:1900|max:2100',
            'volume' => 'nullable|string|max:255',
            'medium' => 'required|string|max:50',
            'restriction' => 'required|in:open-access,confidential,restricted',
            'location' => 'required|string|max:255',
            'frequency' => 'required|in:as_needed,weekly,monthly,yearly',
            'duplication' => 'nullable|string|max:255',
            'time_value' => 'required|in:T,P',
            'utility_value' => 'nullable|array',
            'active' => 'nullable|integer|min:0',
            'active_unit' => 'nullable|string|max:20',
            'storage' => 'nullable|integer|min:0',
            'storage_unit' => 'nullable|string|max:20',
            'disposition' => 'nullable|string|max:500',
            'grds_item' => 'nullable|string|max:255',
            'permanent' => 'nullable|boolean',
        ]);

        // Ensure utility_value is stored as a comma-separated string
        $validatedData['utility_value'] = isset($validatedData['utility_value']) ? implode(',', $validatedData['utility_value']) : null;

        // Handle Year Range
        if ($request->filled('end_year') && $request->filled('start_year') && $request->end_year < $request->start_year) {
            Log::warning("End year ({$request->end_year}) is earlier than Start year ({$request->start_year}). Adjusting values.");
            $validatedData['end_year'] = $validatedData['start_year']; // Force end_year to match start_year
        }

        if (!$request->filled('end_year')) {
            $validatedData['end_year'] = now()->year; // Default to current year
        }

        if (!$request->filled('start_year')) {
            $validatedData['start_year'] = $validatedData['end_year']; // Match end_year if start_year is missing
        }

        // Handle "Permanent" Checkbox
        if ($request->has('permanent')) {
            Log::info('Permanent checkbox selected. Overriding retention period.');
            $validatedData['active'] = null;
            $validatedData['storage'] = null;
            $validatedData['active_unit'] = 'Permanent';
            $validatedData['storage_unit'] = 'Permanent';
        } else {
            foreach (['active', 'storage', 'active_unit', 'storage_unit'] as $field) {
                if (empty($validatedData[$field])) {
                    $validatedData[$field] = null;
                }
            }
        }

        // Set default status
        $validatedData['status'] = 'active';

        // Store the Record
        try {
            $record = Record::create($validatedData);
            Log::info('Record Stored Successfully:', $record->toArray());

            return response()->json([
                'message' => 'Record added successfully!',
                'record' => $record
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error Storing Record:', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to add record.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display archived records.
     */
    public function archiveIndex()
    {
        $archivedRecords = Record::where('status', 'archived')->get();
        return view('admin.records.archive', compact('archivedRecords'));
    }


    public function archive($id)
    {
        $record = Record::find($id);
        if ($record) {
            // Mark the record as archived in the database
            $record->status = 'archived';
            $record->save();

            return response()->json([
                'message' => 'Record archived successfully!',
            ]);
        }

        return response()->json([
            'message' => 'Record not found.',
        ], 404);
    }




    public function unarchive($id)
    {
        $record = Record::find($id);
        if ($record) {
            // Update the record's status to active
            $record->status = 'active';
            $record->save();

            return response()->json(['message' => 'Record unarchived successfully!']);
        }

        return response()->json(['message' => 'Record not found.'], 404);
    }






    public function update(Request $request, $id)
    {
        $record = Record::find($id);
        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found'], 404);
        }

        // Validate request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'related_documents' => 'nullable|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2100',
            'end_year' => 'nullable|integer|min:1900|max:2100',
            'volume' => 'nullable|string|min:0',
            'medium' => 'required|string|max:50',
            'restriction' => 'required|in:open-access,confidential,restricted',
            'location' => 'required|string|max:255',
            'frequency' => 'required|in:as_needed,weekly,monthly,yearly',
            'duplication' => 'nullable|string|max:255',
            'time_value' => 'required|in:T,P',
            'utility_value' => 'nullable|array',
            'active' => 'nullable|integer|min:0',
            'active_unit' => 'nullable|string|max:20',
            'storage' => 'nullable|integer|min:0',
            'storage_unit' => 'nullable|string|max:20',
            'disposition' => 'nullable|string|max:500',
            'grds_item' => 'nullable|string|max:255',
            'permanent' => 'nullable|boolean',
        ]);

        // Convert utility_value array to comma-separated string
        $validatedData['utility_value'] = isset($validatedData['utility_value'])
            ? implode(',', $validatedData['utility_value'])
            : null;

        // Handle "Permanent" selection
        if ($request->has('permanent')) {
            $validatedData['active'] = null;
            $validatedData['storage'] = null;
            $validatedData['active_unit'] = 'Permanent';
            $validatedData['storage_unit'] = 'Permanent';
        } else {
            // If fields are missing, set them to defaults to prevent errors
            $validatedData['active'] = $validatedData['active'] ?? 0;
            $validatedData['active_unit'] = $validatedData['active_unit'] ?? 'years';
            $validatedData['storage'] = $validatedData['storage'] ?? 0;
            $validatedData['storage_unit'] = $validatedData['storage_unit'] ?? 'years';
        }

        // Update the record
        $record->update($validatedData);

        // Calculate total retention (in years and months)
        $totalYears = 0;
        $totalMonths = 0;

        if ($validatedData['active_unit'] === "years") {
            $totalYears += $validatedData['active'] ?? 0;
        } elseif ($validatedData['active_unit'] === "months") {
            $totalMonths += $validatedData['active'] ?? 0;
        }

        if ($validatedData['storage_unit'] === "years") {
            $totalYears += $validatedData['storage'] ?? 0;
        } elseif ($validatedData['storage_unit'] === "months") {
            $totalMonths += $validatedData['storage'] ?? 0;
        }

        // Convert months into years if applicable
        $totalYears += intdiv($totalMonths, 12);
        $totalMonths = $totalMonths % 12;

        // Format total retention period
        $totalRetention = $totalYears ? "{$totalYears} yrs" : "";
        if ($totalMonths) {
            $totalRetention .= $totalYears ? ", " : "";
            $totalRetention .= "{$totalMonths} mos";
        }
        if (!$totalRetention) $totalRetention = "0";

        // Return JSON response for AJAX request
        return response()->json([
            'success' => true,
            'message' => 'Record updated successfully!',
            'updatedRecord' => [
                'id' => $record->id,
                'title' => $record->title,
                'related_documents' => $record->related_documents,
                'start_year' => $record->start_year,
                'end_year' => $record->end_year,
                'volume' => $record->volume,
                'medium' => ucfirst(strtolower($record->medium)),
                'location' => $record->location,
                'time_value' => $record->time_value,
                'active' => $record->active,
                'active_unit' => $record->active_unit,
                'storage' => $record->storage,
                'storage_unit' => $record->storage_unit,
                'disposition' => $record->disposition,
                'grds_item' => $record->grds_item,
                'total_retention' => $totalRetention
            ]
        ]);
    }
}
