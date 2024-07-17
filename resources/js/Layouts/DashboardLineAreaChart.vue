<script>
import {defineComponent} from 'vue';
import VueApexCharts from 'vue3-apexcharts';

export default defineComponent({
    components: {
        apexchart: VueApexCharts
    }
});
</script>

<script setup>
import {ref} from 'vue';

// Define reactive data
const series = ref([
    {
        name: 'Water Pump Motors',
        data: [31, 40, 76, 51, 42, 89]
    },
    {
        name: 'Lift Motors',
        data: [11, 32, 45, 32, 34, 52]
    }
]);

const chartOptions = ref({
    chart: {
        height: 500,
        type: 'area'
    },
    dataLabels: {
        enabled: false
    },
    title: {
        text: 'Trend Analysis'
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        type: 'month',
        categories: [
            "Jan",
            'Feb',
            "Mar",
            "Apr",
            "May",
            "Jun"
        ]
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        }
    }
});
</script>

<template>
    <div class="mt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <apexchart type="area" height="350" :options="chartOptions" :series="series"></apexchart>
            </div>
        </div>
    </div>
</template>

