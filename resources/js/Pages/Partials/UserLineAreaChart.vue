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



const props = defineProps({
    months: {
        type: Array,
        required: true
    },
    budget: {
        type: Array,
        required: true
    },
    spend: {
        type: Array,
        required: true
    }

});

const budgetData = Object.values(props.budget);
const spendData = Object.values(props.spend);

// Define reactive data
const series = ref([
    {
        name: 'Budget',
        data: budgetData
    },
    {
        name: 'Spend',
        data: spendData
    },
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
        text: 'Budget and spend trend analysis'
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        type: 'month',
        categories: props.months
    },

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

