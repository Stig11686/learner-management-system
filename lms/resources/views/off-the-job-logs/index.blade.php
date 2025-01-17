<x-app-layout>
    <div class="container mx-auto px-4 py-12">

        <!-- Submission Form -->
        <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg mb-8">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Submit OTJ Hours</h2>

            <form 
                action="{{ route('otj.store', $learner) }}" 
                method="POST" 
                class="space-y-4"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="hidden">
                    <x-text-input 
                        id="learner_id" 
                        name="learner_id" 
                        type="hidden" 
                        value="{{ $learner->id }}"
                        required 
                    />
                </div>

                <div>
                    <x-input-label for="learner_otjh_input_date" :value="__('Date')" />
                    <x-text-input 
                        id="learner_otjh_input_date" 
                        name="date" 
                        type="date" 
                        class="mt-1 block w-full"
                        required 
                    />
                </div>

                <div>
                    <x-input-label for="hours" :value="__('Number of Hours')" />
                    <x-text-input 
                        id="hours" 
                        name="hours" 
                        type="number" 
                        min="0" 
                        step="0.1"
                        class="mt-1 block w-full"
                        required 
                    />
                </div>

                <div>
                    <x-input-label for="activity_description" :value="__('Details of the Activity')" />
                    <x-text-input 
                        id="activity_description" 
                        name="activity_description" 
                        type="text" 
                        class="mt-1 block w-full"
                        required 
                    />
                </div>

                <div>
                    <x-input-label for="comments" :value="__('What did you learn from this and how will you apply it at work?')" />
                    <x-text-input 
                        id="comments" 
                        name="comments" 
                        type="text" 
                        class="mt-1 block w-full"
                        required 
                    />
                </div>

                <div>
                    <x-input-label for="learning_type" :value="__('What Type of Learning Activity Was This?')" />
                    <select name="learning_type" id="learning_type" class="mt-1 block w-full">
                    @foreach ($learning_types as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="evidence_link" :value="__('Would you like to upload a file?')" />
                    <input type="file" name="evidence_link" id="evidence_link" class="mt-1 block w-full">
                </div>

                <x-primary-button>
                    {{ __('Submit Log') }}
                </x-primary-button>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>

        <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Your OTJ Logs - Current Hours: {{ $learner->otjh_actual }}</h2>

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
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                {{ $log->feedback }}
                            </td>
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



    </div>
</x-app-layout>
