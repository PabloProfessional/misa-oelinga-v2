
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
import { ref, defineProps } from 'vue';


const props = defineProps({
    budget: {
        type: Array,
        required: true
    },
    spend: {
        type: Array,
        required: true
    },
});


const series = ref([
    {
        name: 'Budget',
        data: props.budget
    },
    {
        name: 'Spend',
        data: props.spend
    }
]);

const chartOptions = ref({
    chart: {
        height: 350,
        type: 'area'
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        type: 'month',
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
    yaxis: {
        labels: {
            formatter: function (val) {
                return "R " + val.toLocaleString();
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "R " + val.toLocaleString();
            }
        },
        labels: {
            formatter: function (val) {
                return "R " + val.toLocaleString();
            }
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

