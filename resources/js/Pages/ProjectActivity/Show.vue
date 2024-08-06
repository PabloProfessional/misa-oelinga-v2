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
import UpdateActivityProgressForm from "@/Pages/ProjectActivity/Partials/UpdateActivityProgressForm.vue";
import Progress from "@/Components/Progress.vue";


const variance = ref<number>(0);

defineProps({
    activity:{
        type: Object,
        required: true
    },
    activity_type:{
        type: Object,
        required: true
    },
    project: {
        type: Object,
        //required: true
    },
    project_activities:{
        type: Object,
        //required: true
    },
    municipality: {
        type: Object,
        //required: true
    },
    programme: {
        type: Object,
        //required: true
    },
    status: {
        type: Object,
        //required: true
    },
    budget: {
        type: Array,
        //required: true
    },
    spend: {
        type: Array,
        //required: true
    },
    budget_allocation:{
        type: Number
    },
    variance:{
        type: Number
    },
    province: {
        type: Object,
        //required: true
    },
    budget_trend: {
        type: Array,
    },
    spend_trend: {
        type: Array,
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
    project_stage: {
        type: Object,
        required: true,
    },
    progress: {
        type: Object
    }
});




</script>



<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ activity['name'] }}
            </h2>
            <small style="margin-top: 10px; color: grey;">

                <a href="/dashboard">
                    Dashboard
                </a> /
                <a :href="'/province/'+province?.['url']">
                    {{ province?.['name'] }}
                </a> /
                <a :href="'/municipality/' + municipality?.['url']">
                    {{ municipality?.['name'] }}
                </a> /

                <a :href="'/programme/' + programme?.['url']">
                    Programme - {{ programme?.['name'] }}
                </a> /
                <a :href="'/project/' + project?.['url']">
                    Project - {{ project?.['name'] }}
                </a> /
                <strong> {{ activity['name'] }} </strong>
            </small>

            <p style="margin-top: 10px; color: grey;">
                <strong>Activity Type:</strong> <i :class="activity_type['icon']"></i> {{ activity_type['name'] }} for project stage
                <br>
                <strong>Description: </strong>
                {{ activity['description'] }}
                <br><br>
                <UpdateActivityProgressForm :project_activity_id="activity['id']"></UpdateActivityProgressForm>
            </p>

        </template>



        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                    <Progress :progress="progress" :count="progress" :count_description="'Percentage completion of activity'" :status_icon="status?.['icon']" v-if="progress"></Progress>
                    <Budget :budget="activity['budget'] / 100000000 " :budget_allocation="((activity['spend'] / activity['budget']) *100).toPrecision(2)" ></Budget>
                    <Spend :spend="activity['spend'] / 100000000 " :variance="(100 - (activity['spend'] / activity['budget']) *100).toPrecision(2)"></Spend>
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
            </div>
            <ShowProjectAccounts></ShowProjectAccounts>

            <ShowProjectAttatchments :project="project"></ShowProjectAttatchments>
                </div>




<br>
        <br>



    </AuthenticatedLayout>
</template>


