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
import TopProjectsSpiderChart from "@/Components/TopProjectsSpiderChart.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";




const props = defineProps({
    project: {
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
    }
});


</script>



<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ project.name }}
            </h2>
            <p style="margin-top: 10px; color: grey;">
                <strong>Description: </strong>
                {{ project['description'] }}
            </p>

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





    </AuthenticatedLayout>
</template>


