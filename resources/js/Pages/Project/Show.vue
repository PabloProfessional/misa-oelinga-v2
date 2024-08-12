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
import ShowProjectAttatchments from "@/Pages/Project/Partials/ShowProjectAttatchments.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import UserLineAreaChart from "@/Pages/Partials/UserLineAreaChart.vue";
import ProjectActivitySpendPieChart from "@/Project/Partials/ProjectActivitySpendPieChart.vue";
import ProjectActivitySpendBarChart from "@/Project/Partials/ProjectActivitySpendBarChart.vue";


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
    bar_chart_data: {
        type: Object,
    },
    accounts: {
        type: Object,
    },
    activity_risk_status: {
        type: Object
    }
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
                    <Count :count="status['name']" :count_description="'Schedule, '+status_schedule[0]+'. Procurement, '+status_procurement[0]+'. Budget, '+status_budget[0]" :status_icon="status['icon']"></Count>
                    <Budget :budget="project['budget'] / 100000000 " :budget_allocation="budget_allocation?.toPrecision(2)" ></Budget>
                    <Spend :spend="project['spend'] / 100000000 " :variance="variance"></Spend>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div
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
            </div>
        </div>
        <br>
        <br>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                <div
                                id="docs-card"
                                class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                            >
                                <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">

                                    <ProjectActivitySpendPieChart
                                        :project_activities="project_activities"
                                        class="mt-6"
                                        style="width: 100%;" >
                                    </ProjectActivitySpendPieChart>
                                </div>


                                <div class="relative flex items-center gap-6 lg:items-end">
                                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">


                                        <div class="pt-3 sm:pt-5 lg:pt-0">
                                            <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Activity Pie Chart</h2>

                                            <p class="mt-4 text-sm/relaxed">
                                                This pie chart provides a visual breakdown of the spending on various project activities.
                                                Each slice represents a specific activity, showing the percentage of the total spend that belongs to that activity.
                                                The size of each slice corresponds to the proportion of the overall budget spent on that particular activity, making it easy to see which activities are consuming the most resources.
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                <div
                    id="docs-card"
                    class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                >
                    <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">

                        <ProjectActivitySpendBarChart
                            :bar_chart_data="bar_chart_data"
                            class="mt-6"
                            style="width: 100%;" >
                        </ProjectActivitySpendBarChart>
                    </div>


                    <div class="relative flex items-center gap-6 lg:items-end">
                        <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">


                            <div class="pt-3 sm:pt-5 lg:pt-0">
                                <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Activity Bar Chart</h2>

                                <p class="mt-4 text-sm/relaxed">
                                    This bar chart illustrates the absolute total monthly spending across various activities throughout the year.
                                    Each bar represents the total spend for a month, with segments showing the amount allocated to each activity.
                                    The legend identifies the activities, and hovering over a segment reveals the exact spend for that activity during the month.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ShowProjectActivities :project="project" :project_activities="project_activities" :activity_risk_status="activity_risk_status"></ShowProjectActivities>
            <ShowProjectAccounts :accounts="accounts"></ShowProjectAccounts>

            <ShowProjectAttatchments :project="project"></ShowProjectAttatchments>

                </div>




<br>
        <br>



    </AuthenticatedLayout>
</template>


