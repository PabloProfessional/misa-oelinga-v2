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
    // colors: props.status_count_keys.map(status => {
    //     if (status === 'Low Risk') {
    //         return '#00008B'; // Dark blue for low risk
    //     } else if (status === 'Medium Risk') {
    //         return '#FFA500'; // Orange for medium risk
    //     } else if (status === 'High Risk') {
    //         return '#FF0000'; // Red for high risk
    //     } else {
    //         return '#808080'; // Gray for unknown or other statuses
    //     }
    // })
});
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <apexchart type="donut" height="250" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>
