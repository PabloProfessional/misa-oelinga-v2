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

const series = ref([
    {
        name: 'PRODUCT A',
        data: [44, 55, 41, 67, 22, 43, 60, 52, 33, 41, 65, 57]
    },
    {
        name: 'PRODUCT B',
        data: [13, 23, 20, 8, 13, 27, 14, 17, 22, 19, 21, 28]
    },
    {
        name: 'PRODUCT C',
        data: [11, 17, 15, 15, 21, 14, 19, 25, 18, 22, 24, 29]
    },
    {
        name: 'PRODUCT D',
        data: [21, 7, 25, 13, 22, 8, 12, 9, 23, 14, 19, 13]
    }
]);

const chartOptions = ref({
    chart: {
        type: 'bar',
        stacked: true,
        height: 350,
    },
    plotOptions: {
        bar: {
            horizontal: false,
            borderRadius: 10,
        },
    },
    xaxis: {
        categories: ['January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'],
    },
    yaxis: {
        title: {
            text: 'Total Spend',
        },
    },
    fill: {
        opacity: 1,
    },
    legend: {
        position: 'right',
        offsetY: 40
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$" + val + "K";
            }
        }
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
    }],
});
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <apexchart type="bar" height="350" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>
