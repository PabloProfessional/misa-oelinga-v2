<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/vue3';
import Count from "@/Components/Count.vue";
import {onMounted, ref,} from "vue";
import axios from "axios";
const count = ref<number>(0);

onMounted(async () => {
    try {
        const response = await axios.get('/projects/count');
        count.value = response.data.count;
    } catch (error) {
        console.error('Failed to fetch project count:', error);
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
            <Count :count="count"></Count>
        </div>
    </AuthenticatedLayout>
</template>
