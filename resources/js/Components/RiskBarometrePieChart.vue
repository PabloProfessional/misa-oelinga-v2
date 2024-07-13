<script>
import { defineComponent } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

export default defineComponent({
    components: {
        apexchart: VueApexCharts
    }
});
</script>

<script setup>
import { ref } from 'vue';

// Define reactive data
const series = ref([3,1,0,0,0,0]);

const chartOptions = ref({
    chart: {
        type: 'donut',
    },
    labels: ['Healthy', 'Lubrication needed', 'High temperatures','Axial Overload','Radial Overload','Excessive Vibration'],
    responsive: [{
        breakpoint: 480,
        options: {
            chart: {
                width: 500
            },
            legend: {
                position: 'bottom'
            }
        }
    }]
});
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <apexchart type="donut" height="250" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>
