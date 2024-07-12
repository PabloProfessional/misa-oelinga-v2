<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/vue3';
import Count from "@/Components/Count.vue";
import {computed, onMounted, ref,} from "vue";
import axios from "axios";
import Budget from "@/Components/Budget.vue";
import Spend from "@/Components/Spend.vue";
import AssetHealthPieChart from "@/Pages/Partials/AssetHealthPieChart.vue";
import UserLineAreaChart from "@/Pages/Partials/UserLineAreaChart.vue";

const count = ref<number>(0);
const budget = ref<number>(0);
const spend = ref<number>(0);
const variance = ref<number>(0);
let count_description = "Total number of projects."
const provinces = ref<number>(0);
const budget_allocation = ref<number>(0);

function goToProvince(url: any) {
    window.location.href = `province/${url}`;
}

const budgetCollection = ref();
const months = ref();
const spendCollection = ref();

async function getTrendAnalysis() {
    try {
        const response = await axios.get('/provinces/trend_analysis');
        budgetCollection.value = response.data.budget;
        spendCollection.value = response.data.spend;
        months.value = response.data.months;
    } catch (error) {
        console.error('Failed to fetch project provinces:', error);
    }
}

onMounted(async () => {
    try {
        const response = await axios.get('/projects/count');
        count.value = response.data.count;
    } catch (error) {
        console.error('Failed to fetch project count:', error);
    }
    try {
        const response = await axios.get('/projects/budget');
        budget.value = response.data.budget;
    } catch (error) {
        console.error('Failed to fetch project budget:', error);
    }

    try {
        const response = await axios.get('/projects/budget_allocation');
        budget_allocation.value = response.data.budget_allocation;
    } catch (error) {
        console.error('Failed to fetch project budget allocation:', error);
    }

    try {
        const response = await axios.get('/projects/spend');
        spend.value = response.data.spend;
    } catch (error) {
        console.error('Failed to fetch project spend:', error);
    }
    try {
        const response = await axios.get('/projects/variance');
        variance.value = response.data.variance;
    } catch (error) {
        console.error('Failed to fetch project variance:', error);
    }
    try {
        const response = await axios.get('/provinces/summary');
        provinces.value = response.data.provinces;
    } catch (error) {
        console.error('Failed to fetch project provinces:', error);
    }
    getTrendAnalysis();
});


</script>

<style>
.map-container {
    position: relative;
    width: 100%;
    max-width: 1000px;
    margin: auto;
}
.province-label {
    position: absolute;
    color: #000;
    background: rgba(255, 255, 255, 0.7);
    padding: 5px;
    border-radius: 5px;
    text-align: center;
    cursor: pointer; /* Add pointer cursor */
    transition: background-color 0.3s, transform 0.3s; /* Add transition for smooth effect */
}
.province-label:hover {
    background: rgba(255, 255, 255, 1); /* Change background color on hover */
    transform: scale(1.05); /* Slightly enlarge the div on hover */
}
/* Define positions for each province label */
.northern-cape { top: 55%; left: 25%; }
.free-state { top: 45%; left: 51.5%; }
.north-west { top: 25%; left: 35%; }
.western-cape { top: 80%; left: 20%; }
.eastern-cape { top: 75%; left: 48%; }
.kwaZulu-natal { top: 45%; left: 80%; }
.mpumalanga { top: 25%; left: 76%; }
.limpopo { top: 5%; left: 65%; }
.gauteng { top: 30%; left: 55%; }
</style>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Welcome {{ $page.props.auth.user.name }}</h2>
            <p>This is your <strong>Project Management Platform</strong>. Brought to you by <a href="https://www.oelinga.com/">Ölinga.</a> </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                    <Count :count="count" :count_description="count_description"></Count>
                    <Budget :budget="budget" :budget_allocation="budget_allocation" ></Budget>
                    <Spend :spend="spend" :variance="variance"></Spend>
                </div>
            </div>
            <br>
            <br>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <a
                    href="#"
                    id="docs-card"
                    class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                >
                    <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">
                        <div class="map-container">
                            <img src="../../../public/img/maps/za_map.png" alt="South Africa Map" style="width: 95%;">

                            <div
                                v-for="province in provinces"
                                :key="province.url"
                                :class="['province-label', province.url]"
                                @click="goToProvince(province.url)"
                            >
                                <div><strong>{{ province.name }}</strong></div>
                                <div>
                                    <strong v-if="province.status">
                                        <i :class="province.status.icon" :style="{ color: province.status.color }"></i>
                                        <span :style="{ color: province.status.color }">{{ province.status.name }}</span>
                                    </strong>
                                    <span v-else class="badge bg-warning">
          No projects yet.
        </span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-12 sm:pt-12 lg:pt-0">
                            <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Country Map</h2>

                            <p class="mt-2 text-sm/relaxed">
                                The chart on the left shows a summary analysis of key measurements.
                            </p>

                        </div>
                    </div>

                </a>
            </div>
            <br>
            <br>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <a
                    href="#"
                    id="docs-card"
                    class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                >
                    <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">
                        <UserLineAreaChart class="mt-6" style="width: 100%;" :months="months" :budget="budgetCollection" :spend="spendCollection"></UserLineAreaChart>
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
        </div>





    </AuthenticatedLayout>
</template>
