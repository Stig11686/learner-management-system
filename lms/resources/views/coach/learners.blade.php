<x-app-layout>
    
<div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Learners Overview</h1>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="table-auto w-full border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Cohort</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Standard</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">RAG Rating</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Start Date</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Practical End Date</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Time to End</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">OTJ Hours Submitted</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Target OTJ Hours</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">KSBs Hit</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">KSB Target</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Tasks Outstanding</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Attendance %</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($learners as $learner)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">
                                <a 
                                    href="{{ route('learners.show', $learner->id) }}" 
                                    class="text-blue-500 hover:underline">
                                    {{ ucfirst($learner->user->name) }}
                                </a>
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ ucfirst($learner->cohort->name) }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ ucfirst($learner->cohort->course->name) }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-white bg-{{$learner->rag_rating}}-500">{{ ucfirst($learner->rag_rating) }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $learner->start_date->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $learner->end_date->format('d/m/Y') }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{\Carbon\Carbon::parse($learner->end_date)->diffForHumans()}}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $learner->otjh_actual }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $learner->otjh_target }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $learner->ksbs_hit ?? '0' }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $learner->ksb_target ?? '0' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center px-4 py-6 text-gray-500">
                                No learners found for this coach.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>