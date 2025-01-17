<x-app-layout>
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-xl font-bold mb-6">
            Off-The-Job Logs for {{ $learner->user->name }}
        </h1>

        <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Date</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Hours</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Type of Activity</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Description</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">How will this impact your work?</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Evidence</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Status</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Feedback</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupedLogs as $week => $data)
                    <!-- Weekly Header -->
                    <tr class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-bold">
                        <td colspan="7" class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            Week: {{ $week }}
                        </td>
                    </tr>

                    <!-- Individual Logs -->
                    @foreach ($data['logs'] as $log)
                        <tr class="text-gray-800 dark:text-gray-200">
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                {{ \Carbon\Carbon::parse($log->date)->format('d M Y') }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                {{ $log->hours }} hours
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                {{ ucwords(str_replace('_', ' ', $log->learning_type)) }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                {{ $log->activity_description }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                {{ $log->comments }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                @if($log->evidence_link)
                                    <a href="{{ $log->evidence_link }}">View Evidence</a>
                                @else
                                    <span>None Submitted</span>
                                @endif  
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 
                                @if ($log->status === 'approved') bg-green-200 text-white
                                @elseif ($log->status === 'pending') bg-orange-200 text-orange-800
                                @elseif ($log->status === 'rejected') bg-red-200 text-white
                                @else bg-gray-200 text-gray-800 
                                @endif"
                            >
                                {{ ucwords($log->status) }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 ">
                                {{ $log->feedback }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2" onclick="openModal({{ $log->id }}, {{ $learner->id }}, '{{ $log->status }}', '{{ $log->feedback }}')">Mark Log</td>
                        </tr>
                    @endforeach

                    <!-- Weekly Total -->
                    <tr class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-bold">
                        <td colspan="3" class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right" colspan="2">
                            Total Hours for Week:
                        </td>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                            {{ $data['total_hours'] }} hours
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    <!-- Modal for Marking Log -->
    <!-- Single Modal for Marking Log -->
    <div id="markingLogModal" class="modal hidden fixed inset-0 z-40 flex items-center justify-center">
        <div class="modal-overlay absolute inset-0 bg-gray-500 bg-opacity-75" onclick="closeModal()"></div>
        <div class="modal-content bg-white p-6 rounded-lg shadow-lg w-full max-w-md z-50">
            <h2 class="text-xl font-semibold mb-4">Marking Log</h2>

            <form method="POST" id="modalForm" action="" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 dark:border-gray-700 p-2 mt-1" required>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                    <textarea name="feedback" id="feedback" rows="4" class="w-full border border-gray-300 dark:border-gray-700 p-2 mt-1" required></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Submit</button>
                    <button type="button" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>



    <script>
    // Open the modal and populate the fields with data
    function openModal(logId, learnerId, currentStatus, currentFeedback) {
        // Show the modal
        const modal = document.getElementById('markingLogModal');
        modal.classList.remove('hidden');
        
        // Set form action dynamically
        const form = document.getElementById('modalForm');
        form.action = `/learners/${learnerId}/off-the-job-logs/${logId}`;

        // Set the status field to the current log's status
        const statusField = document.getElementById('status');
        statusField.value = currentStatus;

        // Set the feedback field to the current log's feedback
        const feedbackField = document.getElementById('feedback');
        feedbackField.value = currentFeedback;
    }

    // Close the modal
    function closeModal() {
        const modal = document.getElementById('markingLogModal');
        modal.classList.add('hidden');
    }
</script>


</x-app-layout>
