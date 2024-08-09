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
import { defineProps, ref, computed } from 'vue';

const props = defineProps({
    project_activities: {
        type: Object,
        required: true
    }
});

// Map the project_activities to series and labels
const series = computed(() => props.project_activities.map(activity => (activity.spend.toLocaleString() / 100)));
const labels = computed(() => props.project_activities.map(activity => activity.name));

const chartOptions = ref({
    chart: {
        type: 'donut',
    },
    labels: labels.value,
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
    tooltip: {
        y: {
            formatter: function (val) {
                return "R" + val.toLocaleString();
            }
        }
    },
});
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <apexchart type="donut" height="250" :options="chartOptions" :series="series"></apexchart>
    </div>
</template>

