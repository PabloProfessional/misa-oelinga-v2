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
import {defineProps, ref} from 'vue';

const props = defineProps({
    top_projects: {
        type: Array,
    },
    top_budgets: {
        type: Array
    },
    top_spends: {
        type: Array
    }
});


const series = ref([
    {
        name: 'Budget',
        data: [9,98]
    },
    {
        name: 'Spend',
        data: [7,98]
    }
]);

// Define reactive data
const chartOptions = ref({
    chart: {
        height: 350,
        type: 'radar',
        dropShadow: {
            enabled: true,
            blur: 1,
            left: 1,
            top: 1
        }
    },
    stroke: {
        width: 2
    },
    fill: {
        opacity: 0.1
    },
    markers: {
        size: 0
    },
    yaxis: {
        stepSize: 20
    },
    xaxis: {
        categories: props.top_projects.map(item => item.project_number)
    },
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
        <apexchart type="radar" height="350" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>


