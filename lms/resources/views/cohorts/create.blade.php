<x-app-layout>
    <div class="container mx-auto px-4 py-12">

    <x-form-component title="Add a Cohort" action="{{ route('cohorts.store') }}" method="POST" class="mx-auto mt-6 max-w-xl">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
            <x-input-label for="course" :value="__('Select Course')" />
            <x-select-input :options="$courses" name="course" id="course" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />

            <x-slot name="submit">
                <button 
                    type="submit" 
                    class="block w-full rounded-md bg-blue-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                >
                    Save
            </button>
    </x-slot>
    </x-form-component>
</x-app-layout>