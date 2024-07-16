<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/vue3';
import Count from "@/Components/Count.vue";
import {defineProps, ref} from "vue";
import Budget from "@/Components/Budget.vue";
import Spend from "@/Components/Spend.vue";
import RiskBarometrePieChart from "@/Components/RiskBarometrePieChart.vue";
import ShowProjectActivities from "@/Pages/Project/Partials/ShowProjectActivities.vue";
import ShowProjectAccounts from "@/Pages/Project/Partials/ShowProjectAccounts.vue";


const variance = ref<number>(0);

defineProps({
    project: {
        type: Object,
        required: true
    },
    project_activities:{
        type: Object,
        required: true
    },
    municipality: {
        type: Object,
        required: true
    },
    programme: {
        type: Object,
        required: true
    },
    status: {
        type: Object,
        required: true
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
    },
    top_projects: {
        type: Array
    },
    top_budgets: {
        type: Array
    },
    top_spends: {
        type: Array
    },
    projects: {
        type: Array
    },
    status_procurement: {
        type: Array,
        required: true
    },
    status_risk: {
        type: Array,
        required: true
    },
    status_budget: {
        type: Array,
        required: true
    },
    status_schedule: {
        type: Array,
        required: true
    },
    sector: {
        type: Object,
        required: true
    },
    project_stage: {
        type: Object,
        required: true,
    },
});


</script>



<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ project['name'] }}
            </h2>
            <p style="margin-top: 10px; color: grey;">

                <a href="/dashboard">
                    Dashboard
                </a> /
                <a :href="'/province/'+province['url']">
                    {{ province['name'] }}
                </a> /
                <a :href="'/municipality/' + municipality['url']">
                    {{ municipality['name'] }}
                </a> /

                <a :href="'/programme/' + programme['url']">
                    Programme - {{ programme['name'] }}
                </a> /
                <strong> {{ project['name'] }} </strong>
            </p>
            <p style="margin-top: 10px; color: grey;">
                <strong>Sector:</strong> <i :class="sector['icon']"></i> {{ sector['name'] }}
                <br>
                <strong>Project Stage:</strong> <i :class="project_stage['icon']"></i> {{ project_stage['name'] }} - {{ project_stage['description'] }}
                <br>
                <strong>Description: </strong>
                {{ project['description'] }}
                <br>
            </p>

        </template>



        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                    <Count :count="status['name']" :count_description="status['description']" :status_icon="status['icon']"></Count>
                    <Budget :budget="project['budget'] / 100000000 " :budget_allocation="0" ></Budget>
                    <Spend :spend="project['spend'] / 100000000 " :variance="variance"></Spend>
                </div>
            </div>
        </div>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            <div
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

<!--                                            <p class="mt-4 text-sm/relaxed">-->
<!--                                                The health barometer helps show the distribution of conditions or statuses for bearings across all water pumps.-->
<!--                                                It shows the proportion of items that fall into different health statuses, such as being in good condition (healthy) or requiring specific types of maintenance (e.g., lubrication, handling overloads, or managing excessive vibration).-->
<!--                                                This distribution provides a snapshot of the overall health and maintenance needs of various water pumps, allowing for better planning and resource allocation to ensure optimal performance and longevity of the items in question.-->

<!--                                            </p>-->

                                        </div>
                                    </div>
                                </div>
                            </div>
                <div
                    class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                >


                    <div class="pt-3 sm:pt-5">
                        <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">
                            Project Status <small> | Break down</small>
                        </h2>

                        <ul>
                            <li class="flex items-center mt-4">

                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong class="font-medium">
                                        <i :class="status_procurement[1] + ' inline-block w-2.5 h-2.5'" style="margin-right: 0.5em;" :style="{ color: status_procurement[2] }"></i>
                                        Procurement</strong> -
                                    <strong class="font-semibold">
                                        {{ status_procurement[0] }}
                                    </strong>
                                </p>
                            </li>
                            <li class="flex items-center mt-4">

                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong class="font-medium">
                                        <i :class="status_risk[1] + ' inline-block w-2.5 h-2.5'" style="margin-right: 0.5em;" :style="{ color: status_procurement[2] }"></i>
                                        Risk</strong> -
                                    <strong class="font-semibold">
                                        {{ status_risk[0] }}
                                    </strong>
                                </p>
                            </li>
                            <li class="flex items-center mt-4">

                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong class="font-medium">
                                        <i :class="status_budget[1] + ' inline-block w-2.5 h-2.5'" style="margin-right: 0.5em;" :style="{ color: status_procurement[2] }"></i>
                                        Budget</strong> -
                                    <strong class="font-semibold">
                                        {{ status_budget[0] }}
                                    </strong>
                                </p>
                            </li>
                            <li class="flex items-center mt-4">

                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    <strong class="font-medium">
                                        <i :class="status_schedule[1] + ' inline-block w-2.5 h-2.5'" style="margin-right: 0.5em;" :style="{ color: status_procurement[2] }"></i>
                                        Schedule</strong> -
                                    <strong class="font-semibold">
                                        {{ status_schedule[0] }}
                                    </strong>
                                </p>
                            </li>
                        </ul>



                    </div>


                </div>


                        </div>
            <ShowProjectActivities :project="project" :project_activities="project_activities"></ShowProjectActivities>
            <ShowProjectAccounts></ShowProjectAccounts>

                </div>




<br>
        <br>



    </AuthenticatedLayout>
</template>


