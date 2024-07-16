<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/vue3';
import Count from "@/Components/Count.vue";
import {defineProps, ref,} from "vue";
import Budget from "@/Components/Budget.vue";
import Spend from "@/Components/Spend.vue";
import UserLineAreaChart from "@/Pages/Partials/UserLineAreaChart.vue";
import RiskBarometrePieChart from "@/Components/RiskBarometrePieChart.vue";
import TopProjectsSpiderChart from "@/Components/TopProjectsSpiderChart.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

// const budget = ref<number>(0);
// const spend = ref<number>(0);
// const variance = ref<number>(0);
let count_description = "Total number of projects."
const budget_allocation = ref<number>(0);

function goToProject(url: any) {
    window.location.href = `/project/${url}`;
}

defineProps({
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
    municipalities: {
        type: Object
    },
    projects: {
        type: Object
    }
});


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

                            <TopProjectsSpiderChart
                                class="mt-6"
                                style="width: 100%;"
                                :top_projects="top_projects"
                                :top_budgets="top_budgets"
                                :top_spends="top_spends"
                            ></TopProjectsSpiderChart>
                        </div>


                        <div class="relative flex items-center gap-6 lg:items-end">
                            <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">


                                <div class="pt-3 sm:pt-5 lg:pt-0">
                                    <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Budget Report |
                                        <small>Top Projects</small>
                                    </h2>



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


            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                    <div

                        id="docs-card"
                        class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                    >

                        <div class="relative flex items-center gap-6 lg:items-end">
                            <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">


                                <div class="pt-3 sm:pt-5 lg:pt-0">
                                    <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Municipalities</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Below are all municipalities under this province for the current financial year.
                                    </p>

                                    <table class="mt-4 text-sm/relaxed table table-striped w-full table-auto"  style="width: 900px">
                                        <thead class="table-header-group">
                                        <tr style="text-align: left;">
                                            <th></th>
                                            <th style="text-align: right;"><strong><u>Budget</u></strong></th>
                                            <th style="text-align: right;"><strong><u>Spend</u></strong></th>
                                            <th style="text-align: right;"><strong><u>Average Status</u></strong></th>
                                        </tr>

                                        </thead>

                                        <tbody class="table-row-group" v-for="municipality in municipalities" :key="municipality['id']">
                                            <tr class="w-full table-row">
                                                <th scope="row" >
                                                    <PrimaryButton style="float: left; width: 80%; margin: 0.3em;">{{ municipality['name'] }}</PrimaryButton>
                                                </th>
                                                <td style="text-align: right;">R {{ municipality['budget'] }}</td>
                                                <td style="text-align: right;">R {{ municipality['spend'] }}</td>
                                                <td style="text-align: right;">
                                                    <span class="badge badge-primary" :style="{ color: municipality.average_status_color }">
                                                        <i :class="municipality['average_status_icon']"></i> {{ municipality['average_status_name'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
                    <div
                        id="docs-card"
                        class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                    >

                        <div class="relative flex items-center gap-6 lg:items-end">
                            <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">


                                <div class="pt-3 sm:pt-5 lg:pt-0">
                                    <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Projects</h2>

                                    <p class="mt-4 text-sm/relaxed w-full" >
                                        Below are all projects under this province for the current financial year.
                                    </p>

                                    <table class="mt-4 text-sm/relaxed table table-striped w-full table-auto" style="width: 900px;">
                                        <thead class="table-header-group">
                                        <tr style="text-align: left;">
                                            <th></th>
                                            <th style="text-align: right;"><strong><u>Budget</u></strong></th>
                                            <th style="text-align: right;"><strong><u>Spend</u></strong></th>
                                            <th style="text-align: right;"><strong><u>Average Status</u></strong></th>
                                        </tr>

                                        </thead>

                                        <tbody class="table-row-group" v-for="project in projects" :key="project['id']">
                                        <tr class="w-full table-row">
                                            <th scope="row" >
                                                <SecondaryButton
                                                    @click="goToProject(project['url'])"
                                                    style="float: left; width: 80%; margin: 0.3em;"
                                                >
                                                    {{ project['name'] }}
                                                </SecondaryButton>
                                            </th>
                                            <td style="text-align: right;">R {{ project['budget'] }}</td>
                                            <td style="text-align: right;">R {{ project['spend'] }}</td>
                                            <td style="text-align: right;">
                                                    <span class="badge badge-primary" :style="{ color: project.average_status_color }">
                                                       <i :class="project['average_status_icon']"></i> {{ project['average_status_name'] }}
                                                    </span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
      <br>
        <br>

    </AuthenticatedLayout>
</template>


