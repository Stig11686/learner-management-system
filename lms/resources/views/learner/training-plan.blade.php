<x-app-layout>

@if ($training_plan)
<div class="container mx-auto px-4 py-12">
<div
    class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded"
  >
    <div class="rounded-t mb-0 px-4 py-3 border-0">
      <div class="flex flex-wrap items-center">
        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
          <h3 class="font-semibold text-base text-blueGray-700">
            {{$learner->user->name}} Training Plan - {{$learner->cohort->name}} Cohort - {{$learner->cohort->course->name}} - Coach: {{ $learner->trainer->user->name }}
          </h3>
        </div>
      </div>
    </div>
    <div class="block w-full overflow-x-auto">
      <!-- Projects table -->
      <table class="items-center w-full bg-transparent border-collapse">
        <thead>
          <tr>
            <th
              class="px-6 py-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
            >
              Session name
            </th>
            <th
              class="px-6 py-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
            >
              Duration (hrs)
            </th>
            <th
              class="px-6 py-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
            >
              Date
            </th>
            <th
              class="px-6 py-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
            >
              Type
            </th>
            <th
              class="px-6 py-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
            >
              Trainer
            </th>
          </tr>
        </thead>
        <tbody>
            @foreach ($training_plan as $session)
          <tr class="odd:bg-white even:bg-gray-100">
            <td class="border-t-0 px-6 py-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
              {{ $session['name'] }}
            </td>
            <td class="border-t-0 px-6 py-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
              {{ $session['duration'] ?? 'N/a' }}
            </td>
            <td class="border-t-0 px-6 py-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
              {{ \Carbon\Carbon::parse($session['date'])->format('d/m/Y') }}
            </td>
            <td class="border-t-0 px-6 py-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
              {{ ucfirst(str_replace('_', ' ', $session['type']))  }}
            </td>
            <td class="border-t-0 px-6 py-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
              {{ $session['trainer'] ?? 'N/A'  }}
            </td>
          </tr>  
          @endforeach      
        </tbody>
      </table>
    </div>
  </div>
  @else
  <div class="bg-white h-full font-bold font-md">
    <p>No training plan available - please speak to your Coach</p>
  </div>
  </div>
  @endif


</x-app-layout>