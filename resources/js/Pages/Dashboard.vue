<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/vue3';
import Count from "@/Components/Count.vue";
import {computed, onMounted, ref,} from "vue";
import axios from "axios";
import Budget from "@/Components/Budget.vue";
import Spend from "@/Components/Spend.vue";
const count = ref<number>(0);
const budget = ref<number>(0);
const spend = ref<number>(0);
const variance = ref<number>(0);
let count_description = "Total number of projects."

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
});
</script>

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
                    <Budget :budget="budget" ></Budget>
                    <Spend :spend="spend" :variance="variance"></Spend>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
