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
    bar_chart_data: {
        type: Object, // Since it's an associative array, the type should be Object
        required: true,
    }
});

const series = ref(
    Object.keys(props.bar_chart_data).map(activityName => {
        return {
            name: activityName, // Use the activity name as the series name
            data: props.bar_chart_data[activityName] // Assign the spend data
        };
    })
);

// Calculate total spend for each month across all activities
const totalSpendsPerMonth = series.value[0].data.map((_, index) => {
    return series.value.reduce((total, activity) => {
        return total + activity.data[index];
    }, 0);
});

const chartOptions = ref({
    chart: {
        type: 'bar',
        stacked: true,
        height: 350,
    },
    colors: ['#1f2937', '#c45c13','#3f6212','#cc4e4e','#c45c13','#1f2937'],
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
        labels: {
            formatter: function (val) {
                return "R " + val.toLocaleString();
            }
        }
    },
    fill: {
        opacity: 1,
    },
    dataLabels: {
        enabled: false, // Disable data labels on the bars themselves
    },
    legend: {
        position: 'right',
        offsetY: 40
    },
    tooltip: {
        y: {
            formatter: function (val, opts) {
                const totalSpendForMonth = totalSpendsPerMonth[opts.dataPointIndex];
                const percentage = ((val / totalSpendForMonth) * 100).toFixed(2);
                return `R ${val.toLocaleString()} (${percentage}%)`;
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
