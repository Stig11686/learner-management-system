<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <!-- Header Section -->

        <header>
            <h2 class="text-2xl text-gray-900 dark:text-gray-100 font-bold text-center">
                {{ $title }}
            </h2>
        </header>

        <form action="{{ $action }}" method="{{ in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST' }}" {{ $attributes->merge(['class' => 'mx-auto mt-6 max-w-xl flex flex-col space-y-6']) }}>
            @csrf
            @if ($method === 'PUT' || $method === 'PATCH' || $method === 'DELETE')
                @method($method)
            @endif

            <!-- Form Content Slot -->
            {{ $slot }}

            <!-- Submit Button Slot -->
            <div class="mt-10">
                {{ $submit ?? '' }}
            </div>
        </form>
    
</div>