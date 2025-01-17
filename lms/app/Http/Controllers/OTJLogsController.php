<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Learner;
use App\Models\OTJLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;




class OTJLogsController extends Controller
{
    

    public function indexForLearner()
    {
        $learner = auth()->user()->learner;

        $learning_types = $this->getEnumValues('otj_hours', 'learning_type');

        // Fetch all logs for the learner
        $logs = OTJLog::where('learner_id', $learner->id)
            ->orderBy('date', 'asc')
            ->get();

        // Group logs by week and calculate total hours using only approved logs
        $groupedLogs = $logs->groupBy(function ($log) {
            return Carbon::parse($log->date)->startOfWeek()->format('d M Y') 
                . ' - ' . 
                Carbon::parse($log->date)->endOfWeek()->format('d M Y');
        })->map(function ($weekLogs) {
            return [
                // Total hours is calculated only for approved logs
                'total_hours' => $weekLogs->where('status', 'approved')->sum('hours'),
                // Include all logs (approved, pending, rejected) in the weekly group
                'logs' => $weekLogs,
            ];
        });

        return view('off-the-job-logs.index', compact('groupedLogs', 'learner', 'learning_types'));
    }



    public function showForLearner(Learner $learner)
    {
        $user = auth()->user(); // The currently logged-in user

        // Check if the user is the assigned coach or a manager
        if ($user->role === 'coach' && $learner->trainer_id !== $user->id) {
            abort(403, "Unauthorized access to this learner's logs.");
        }
        
        // Fetch all logs for the learner
        $logs = OTJLog::where('learner_id', $learner->id)
            ->orderBy('date', 'asc')
            ->get();

        // Group logs by week and calculate total hours using only approved logs
        $groupedLogs = $logs->groupBy(function ($log) {
            return Carbon::parse($log->date)->startOfWeek()->format('d M Y') 
                . ' - ' . 
                Carbon::parse($log->date)->endOfWeek()->format('d M Y');
        })->map(function ($weekLogs) {
            return [
                // Total hours is calculated only for approved logs
                'total_hours' => $weekLogs->where('status', 'approved')->sum('hours'),
                // Include all logs (approved, pending, rejected) in the weekly group
                'logs' => $weekLogs,
            ];
        });


        return view('off-the-job-logs.show-learner', [
            'learner' => $learner,
            'groupedLogs' => $groupedLogs,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $learner = auth()->user()->learner;

        $enum_values = OTJLog::getEnumValues('otj_hours', 'learning_type');

        $validated = $request->validate([
            'date' => 'required|date',
            'hours' => 'required|integer|min:0',
            'activity_description' => 'required|string',
            'evidence_link' => 'nullable|file|mimes:pdf,doc,docx,txt,png,jpg,jpeg,gif',
            'learning_type' => ['required', Rule::in($enum_values)],
            'comments' => 'required|string',
        ]);

        $file_path = null;

        if ($request->hasFile('evidence_link') && $request->file('evidence_link')->isValid()) {
            $file_path = $request->file('evidence_link')->store('uploads', 'public');
        }
                    
        // Create the log entry
        $log = OTJLog::create([
            'learner_id' => $learner->id,
            'date' => $validated['date'],
            'hours' => $validated['hours'],
            'activity_description' => $validated['activity_description'],
            'evidence_link' => $file_path,
            'learning_type' => $validated['learning_type'],
            'comments' => $validated['comments'],
            'status' => 'pending'
        ]);

        return redirect()
            ->route('otj.indexForLearner', $learner)
            ->with('success', 'Log submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Learner $learner, $id)
    {
        $log = OTJLog::findOrFail($id); 
        $validated = $request->validate([
            'status' => 'nullable|in:approved,pending,rejected',
            'feedback' => 'nullable'
        ]);

        if(isset($validated['feedback'])) {
            $log->feedback = $validated['feedback'];
        }

        if (isset($validated['status'])) {
            $originalStatus = $log->status;
            $newStatus = $validated['status'];
            $hours = $log->hours;


    
            // Update total_hours if the status changes
            if ($originalStatus !== $newStatus) {
                $learner = $log->learner; // Assuming OTJLog belongs to a Learner model
    
                if ($newStatus === 'approved' && $originalStatus !== 'approved') {
                    // Add hours if the status changed to 'approved'
                    $learner->otjh_actual += $hours;
                } elseif ($originalStatus === 'approved' && $newStatus !== 'approved') {
                    // Subtract hours if the status changed from 'approved' to 'pending' or 'rejected'
                    $learner->otjh_actual -= $hours;
                }
    
                // Save the updated total hours for the learner
                $learner->save();
            }
        }

        // Update the log
        $log->update($validated);

        return redirect()
            ->route('off-the-job-logs.showForLearner', $learner)
            ->with(['success' => 'Log updated successfully.']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, $learner, $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $log = OTJLog::findOrFail($id); // Find the log entry by ID
        $log->status = $validated['status']; // Update status
        $log->save(); // Save changes

        // If you're using this in a live environment (like AJAX or Alpine.js), return JSON:
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $log->status]);
        }

        return redirect()->back()->with('success', 'Log status updated successfully.');
    }

    public function updateFeedback(Request $request, $learner, $id)
    {
        $validated = $request->validate([
            'feedback' => 'text',
        ]);

        $log = OTJLog::findOrFail($id); // Find the log entry by ID
        $log->feedback = $validated['feedback']; // Update status
        $log->save(); // Save changes

        // If you're using this in a live environment (like AJAX or Alpine.js), return JSON:
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $log->status]);
        }

        return redirect()->back()->with('success', 'Log feedback updated successfully.');
    }


    /**
     * Get enum values from a specific table and column
     *
     * @param string $table
     * @param string $column
     * @return array
     */
    private function getEnumValues(string $table, string $column): array
    {
        // Fetch column details directly with a string query
        $result = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = ?", [$column]);

        // Check if column exists
        if (empty($result)) {
            throw new \Exception("Column '{$column}' does not exist in table '{$table}'.");
        }

        $type = $result[0]->Type;

        // Extract the values inside the enum definition
        preg_match('/^enum\((.*)\)$/', $type, $matches);

        if (!isset($matches[1])) {
            throw new \Exception("Column '{$column}' is not an enum type.");
        }

        $enumValues = array_map(function ($value) {
            $value = trim($value, "'"); // Remove surrounding quotes
            $label = str_replace('_', ' ', $value); // Replace underscores with spaces
            $label = ucwords($label); // Capitalize each word
            return ['value' => $value, 'label' => $label];
        }, explode(',', $matches[1]));

        // Use 'value' as the key and 'label' as the display value
        return array_column($enumValues, 'label', 'value');
    }


}
