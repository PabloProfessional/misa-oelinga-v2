<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/vue3';
import Count from "@/Components/Count.vue";
import {computed, defineProps, onMounted, ref,} from "vue";
import axios from "axios";
import Budget from "@/Components/Budget.vue";
import Spend from "@/Components/Spend.vue";
import AssetHealthPieChart from "@/Pages/Partials/AssetHealthPieChart.vue";
import UserLineAreaChart from "@/Pages/Partials/UserLineAreaChart.vue";
import RiskBarometrePieChart from "@/Components/RiskBarometrePieChart.vue";

// const budget = ref<number>(0);
// const spend = ref<number>(0);
// const variance = ref<number>(0);
let count_description = "Total number of projects."
const provinces = ref<number>(0);
const budget_allocation = ref<number>(0);

function goToProvince(url: any) {
    window.location.href = `province/${url}`;
}

const props = defineProps({
    count: {
        type: Number
    },
    budget: {
        type: Array,
        required: true
    },
    spend: {
        type: Array,
        required: true
    },
    budget_allocation:{
        type: Number
    },
    variance:{
        type: Number
    },
    province: {
        type: Object,
        required: true
    },
    budget_trend: {
        type: Array,
        required: true
    },
    spend_trend: {
        type: Array,
        required: true
    },
    status_count_values: {
        type: Array,
    },
    status_count_keys: {
        type: Array,
    }

});



// onMounted(async () => {
//     try {
//         const response = await axios.get('/projects/count');
//         count.value = response.data.count;
//     } catch (error) {
//         console.error('Failed to fetch project count:', error);
//     }
//     try {
//         const response = await axios.get('/projects/budget');
//         budget.value = response.data.budget;
//     } catch (error) {
//         console.error('Failed to fetch project budget:', error);
//     }
//
//     try {
//         const response = await axios.get('/projects/budget_allocation');
//         budget_allocation.value = response.data.budget_allocation;
//     } catch (error) {
//         console.error('Failed to fetch project budget allocation:', error);
//     }
//
//     try {
//         const response = await axios.get('/projects/spend');
//         spend.value = response.data.spend;
//     } catch (error) {
//         console.error('Failed to fetch project spend:', error);
//     }
//     try {
//         const response = await axios.get('/projects/variance');
//         variance.value = response.data.variance;
//     } catch (error) {
//         console.error('Failed to fetch project variance:', error);
//     }
//     try {
//         const response = await axios.get('/provinces/summary');
//         provinces.value = response.data.provinces;
//
//     } catch (error) {
//         console.error('Failed to fetch project provinces:', error);
//     }
// });

</script>



<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                <img :src="`/img/provinces/${province.logo}`" :alt="province.url" style="width: 10%;">
            </h2>
            <p style="margin-top: 10px; color: grey; font-size: large;">

                <a href="/dashboard">
                    Dashboard
                </a> /
                <strong> {{ province['name'] }} </strong>
            </p>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                    <Count :count="count" :count_description="count_description"></Count>
                    <Budget :budget="budget" :budget_allocation="budget_allocation" ></Budget>
                    <Spend :spend="spend" :variance="variance"></Spend>
                </div>
            </div>
        </div>
        <br>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <a
                href="#"
                id="docs-card"
                class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
            >
                <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">
                    <UserLineAreaChart class="mt-6" style="width: 100%;" :budget="budget_trend" :spend="spend_trend"></UserLineAreaChart>
                </div>

                <div class="relative flex items-center gap-6 lg:items-end">
                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                        <div class="pt-3 sm:pt-5 lg:pt-0">
                            <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Budget | <small>YTD trend analysis</small></h2>
                            <p class="mt-4 text-sm/relaxed">
                                The above chart shows a trend analysis of budget v/s spend.
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <br>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                    <a
                        href="#"
                        id="docs-card"
                        class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                    >
                        <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">

                            <RiskBarometrePieChart
                                class="mt-6"
                                style="width: 100%;"
                                :status_count_values="status_count_values"
                                :status_count_keys="status_count_keys"
                            ></RiskBarometrePieChart>
                        </div>


                        <div class="relative flex items-center gap-6 lg:items-end">
                            <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">


                                <div class="pt-3 sm:pt-5 lg:pt-0">
                                    <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Risk Barometer</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        The risk barometer helps show the distribution of conditions or statuses for various risk elements across the entire province.
                                        This visual tool allows stakeholders to understand the overall risk landscape by categorizing projects into different risk levels, such as low, medium, and high.

                                    </p>

                                    <p class="mt-4 text-sm/relaxed">
                                        By using the Risk Barometer, decision-makers can quickly grasp the risk profile of projects within the province, enabling them to allocate resources efficiently, prioritize interventions, and implement strategies to maintain or improve the risk status.
                                        This ensures that projects are managed effectively, mitigating potential risks before they escalate.
                                    </p>

                                </div>
                            </div>
                        </div>
                    </a>
                    <a
                        href="#"
                        id="docs-card"
                        class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                    >
                        <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">

                            <RiskBarometrePieChart class="mt-6" style="width: 100%;"></RiskBarometrePieChart>
                        </div>


                        <div class="relative flex items-center gap-6 lg:items-end">
                            <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">


                                <div class="pt-3 sm:pt-5 lg:pt-0">
                                    <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Health Barometer</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        The health barometer helps show the distribution of conditions or statuses for bearings across all water pumps.
                                        It shows the proportion of items that fall into different health statuses, such as being in good condition (healthy) or requiring specific types of maintenance (e.g., lubrication, handling overloads, or managing excessive vibration).
                                        This distribution provides a snapshot of the overall health and maintenance needs of various water pumps, allowing for better planning and resource allocation to ensure optimal performance and longevity of the items in question.

                                    </p>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>






    </AuthenticatedLayout>
</template>


