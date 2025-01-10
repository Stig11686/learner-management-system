<x-app-layout>
    <div class="relative bg-blue-200 md:pt-32 pb-32 pt-12">
        <div class="container mx-auto py-8">
            <h1 class="text-2xl font-bold mb-4 text-white">Welcome, {{ $learner->user->name }}</h1>
            <p class="text-white text-xl">{{$learner->cohort->name}} / {{$learner->cohort->course->name}}</p>
            

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 py-4 gap-2">
                <div class="relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full bg-white items-center justify-center">
                    <div class="p-6">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <p class="text-black uppercase font-bold text-lg">
                                    Contact Safeguarding
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="mailto:safeguarding@thecodersguild.org.uk" target="_blank" class="text-sm text-blue-200 underline mt-4 cursor-pointer absolute inset-0"></a>
                </div>
                <div class="relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full bg-white items-center justify-center">
                    <div class="py-6">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <p class="text-black uppercase font-bold text-lg">
                                    Contact Coach
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="mailto:{{$learner->trainer->user->email}}" target="_blank" class="text-sm text-blue-200 underline mt-4 cursor-pointer absolute inset-0"></a>
                </div>
                <div class="relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full bg-white items-center justify-center">
                    <div class="py-6">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <p class="text-black uppercase font-bold text-lg">
                                    Report Absence
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="mailto:absences@thecodersguild.org.uk" target="_blank" class="text-sm text-blue-200 underline mt-4 cursor-pointer absolute inset-0"></a>
                </div>
                <div class="relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full bg-white items-center justify-center">
                    <div class="py-6">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <p class="text-black uppercase font-bold text-lg">
                                    Contact TCG
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="#" target="_blank" class="text-sm text-blue-200 underline mt-4 cursor-pointer absolute inset-0"></a>
                </div>
                <!-- RAG Rating -->
                <div class="relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full
                    @if ($learner->rag_rating == 'red')
                        bg-red-500
                    @elseif ($learner->rag_rating == 'amber')
                        bg-orange-500
                    @elseif ($learner->rag_rating == 'green')
                        bg-green-500
                    @endif
                ">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-black uppercase font-bold text-xs">
                                    Rag Rating
                                </h5>
                                <span class="font-semibold text-xl text-black">
                                    {{ucwords($learner->rag_rating)}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start Date -->
                <div class="bg-white relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-black uppercase font-bold text-xs">
                                    Start Date
                                </h5>
                                <span class="font-semibold text-xl text-black">
                                    {{ \Carbon\Carbon::parse($learner->start_date)->format('d/m/Y')}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Practical End Date -->
                <div class="bg-white relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-black uppercase font-bold text-xs">
                                    Practical End Date
                                </h5>
                                <span class="font-semibold text-xl text-black">
                                    {{ \Carbon\Carbon::parse($learner->end_date)->format('d/m/Y')}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Time to EPA -->
                <div class="bg-white relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-black uppercase font-bold text-xs">
                                    Time to EPA
                                </h5>
                                <span class="font-semibold text-xl text-black">
                                {{\Carbon\Carbon::parse($learner->end_date)->diffForHumans()}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- KSB Progress -->
                <div class="bg-white relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-black uppercase font-bold text-xs">
                                    KSB Progress
                                </h5>
                                <span class="font-semibold text-xl text-black">
                                    10% 
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- OTJH Logged -->
                <div class="bg-white relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-black uppercase font-bold text-xs">
                                    OTJH Logged
                                </h5>
                                <span class="font-semibold text-xl text-black">
                                    {{ $learner->otjh_actual }} / {{ $learner->otjh_target }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Drive Link -->
                <div class="bg-white relative flex flex-col min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-black uppercase font-bold text-xs">
                                    Portfolio/Activity Log
                                </h5>
                                <span class="font-semibold text-xl text-black">
                                    10%
                                </span>
                            </div>
                            <a href="{{$learner->drive_link}}" class="text-blue-500 hover:text-blue-700">Click here to view your drive link</a>
                        </div>
                    </div>
                </div>
                <!-- Submit OTJ Button -->
                <div class="bg-white relative flex flex-col items-center min-w-0 break-words rounded mb-6 xl:mb-0 shadow-lg h-full">
                <a href="mailto:safeguarding@thecodersguild.org.uk" target="_blank" class="text-sm text-blue-200 underline mt-4 cursor-pointer absolute inset-0"></a>
                    <div class="flex items-center flex-auto p-4">
                        <div class="flex items-center flex-wrap">
                            <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                <h5 class="text-black uppercase font-bold text-lg text-center">
                                    Submit OTJ Logs
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="flex flex-wrap mt-4">
    <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
        <x-training-plan :learner="$learner"></x-training-plan>
    </div>
</div>

</x-app-layout>
