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
import UserLineAreaChart from "@/Pages/Partials/UserLineAreaChart.vue";
import ShowProjectActivityAttatchments from "@/Pages/ProjectActivity/Partials/ShowProjectActivityAttatchments.vue";


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
    },
    users: {
        type: Object,
        required: true,
    },
    activity_progress_records: {
        type: Object,
        required: true
    },
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
            <br>
            <hr>
            <br>
            <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                <div class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                >
                    <div class="pt-3 sm:pt-5">
                        <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Activity Team Members</h2>

                        <p class="mt-2 text-sm/relaxed">
                            The below are the users involved in this activity and their various roles.
                        </p>
                    </div>
                </div>
                <a
                    v-for="user in users" :key="user.id"
                    :href="`/administrator/users/${user.id}`"
                    class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                >
                    <div
                        class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#c45d25]/10 sm:size-16"
                    >
                        <i class="bi bi-person-circle"></i>
                    </div>

                    <div class="pt-3 sm:pt-5">

                        <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">
                            {{ user.name }}
                        </h2>

                        <p class="mt-4 text-sm/relaxed">
                            <span style="font-size: 20px"><strong>{{ user['email'] }}</strong></span>
                            <!--                                <span style="font-size: 20px"><br>{{ formatDate(user.created_at) }}</span> date registered.-->
                            <br>
                            <span v-if="user.is_active" >
                                    <span class="inline-block w-2.5 h-2.5 bg-blue-300 rounded-full mr-3"></span>
                                <strong>Role: </strong>
                                <strong v-if="user['id'] === activity['user_id']">Activity Manager </strong>
                                <span v-if="user['id'] !== activity['user_id']">Team member</span>
                                </span>


                            <span v-if="!user.is_active">
                                    <span class="inline-block w-2.5 h-2.5 bg-red-400 rounded-full mr-3"></span>
                                <strong>Account deactivated</strong>
                                </span>
                        </p>

                    </div>
                    <svg
                        class="size-6 shrink-0 self-center stroke-[#c45d25]"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                        />
                    </svg>
                </a>
            </div>
            <br>
            <ShowProjectActivityAttatchments :activity_progress_records="activity_progress_records"></ShowProjectActivityAttatchments>
            <br>
            <br>

        </div>


    </AuthenticatedLayout>
</template>


