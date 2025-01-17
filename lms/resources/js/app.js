import './bootstrap';

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Chart.register(ChartDataLabels);
window.Chart = Chart

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.querySelector("#learner_otjh_input_date");


    if(dateInput){
        flatpickr(dateInput, {
            disable: [
                function(date) {
                    // Disable weekends (Saturday = 6, Sunday = 0)
                    return date.getDay() === 0 || date.getDay() === 6;
                }
            ],
            maxDate: "today", // Disable future dates
            dateFormat: "Y-m-d", // Set the date format to YYYY-MM-DD
        });
    }
});

