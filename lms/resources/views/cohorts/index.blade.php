<x-app-layout>
    @foreach ($cohorts as $cohort)
        <p>{{ $cohort->name }}</p>
        @foreach ($cohort->learners as $learner)
        <p>{{ $learner->user->name }}</p>
        @endforeach
    @endforeach
</x-app-layout>