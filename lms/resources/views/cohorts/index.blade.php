<x-app-layout>
    @foreach ($cohorts as $cohort)
        <p>{{ $cohort->name }}</p>
    @endforeach
</x-app-layout>