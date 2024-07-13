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
import {defineProps, ref} from 'vue';

const props = defineProps({
    status_count_values: {
        type: Array,
    },
    status_count_keys: {
        type: Array,
    }

});

// Define reactive data
const series = ref(props.status_count_values);

const chartOptions = ref({
    chart: {
        type: 'donut',
    },
    labels: [props.status_count_keys],
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
    }],
});
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <apexchart type="donut" height="250" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>
