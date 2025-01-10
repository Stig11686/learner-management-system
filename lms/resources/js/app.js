import './bootstrap';
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Chart.register(ChartDataLabels);
window.Chart = Chart

Alpine.start();
