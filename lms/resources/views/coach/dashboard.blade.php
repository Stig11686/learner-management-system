<x-app-layout>
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Welcome {{$user->name}}</h1>
    <div class="flex flex-wrap gap-4">
        <div class="bg-white shadow-md rounded-lg p-6 w-full xl:w-6/12">
            <h2 class="text-xl font-semibold mb-4">Learner Ratings</h2>
            <div class="relative w-full max-w-md mx-auto">
                <!-- Canvas for the Chart -->
                <canvas id="ragRatingChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get the chart context
            const ctx = document.getElementById('ragRatingChart').getContext('2d');
            
            // Create the pie chart
            const ragRatingChart = new Chart(ctx, {
                type: 'pie', // Pie chart type
                data: {
                    labels: ['Red', 'Amber', 'Green'], // RAG Rating labels
                    datasets: [{
                        data: [
                            @json($chartData['rag_rating']['red']), 
                            @json($chartData['rag_rating']['amber']), 
                            @json($chartData['rag_rating']['green'])
                        ], // Dynamic data
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)', // Red
                            'rgba(255, 206, 86, 0.6)', // Amber
                            'rgba(75, 192, 192, 0.6)'  // Green
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)', // Red
                            'rgba(255, 206, 86, 1)', // Amber
                            'rgba(75, 192, 192, 1)'  // Green
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true, // Make the chart responsive
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom', // Position legend at the bottom
                        },
                        datalabels: {
                    color: '#000',
                    font: {
                        size: 14,
                        weight: 'bold',
                    },
                    formatter: (value, ctx) => {
                        // Append the count to the label
                        return `${value}`;
                    }
                },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    </x-app-layout>
