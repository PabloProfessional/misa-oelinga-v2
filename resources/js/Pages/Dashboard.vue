<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/vue3';
import Count from "@/Components/Count.vue";
import {computed, onMounted, ref,} from "vue";
import axios from "axios";
import Budget from "@/Components/Budget.vue";
import Spend from "@/Components/Spend.vue";
import AssetHealthPieChart from "@/Pages/Partials/AssetHealthPieChart.vue";
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
            <br>
            <br>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-6 space-y-6">

                <div
                    class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                >
                    <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 80%;">
                        <div class="map-container ">


                            <img src="../../../public/img/maps/za_map.png" alt="South Africa Map" style="width: 100%;">

<!--                            @foreach ($provinces as $province)-->

<!--                            <div class="province-label {{ $province->url }}" onclick="location.href='province/{{ $province->url }}';">-->
<!--                                <div><strong>{{ $province->name }}</strong></div>-->
<!--                                <div>@if ($province->status() !== null)-->
<!--                                    <strong>-->
<!--                                        <i class=" {{ $province->status()->icon }}" style="color: {{ $province->status()->color }}"></i>-->
<!--                                        <span style="color: {{ $province->status()->color }}">{{ $province->status()->name }}</span>-->
<!--                                    </strong>-->
<!--                                    @else-->
<!--                                    <span class="badge bg-warning">-->
<!--                                            No projects yet.-->
<!--                                             </span>-->
<!--                                    @endif</div>-->
<!--                            </div>-->

<!--                            @endforeach-->
                        </div>
                        <div class="pt-12 sm:pt-12 lg:pt-0">
                            <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Country Map</h2>

                            <p class="mt-4 text-sm/relaxed">
                                The chart on the left shows a summary analysis of key measurements.
                            </p>

                        </div>


                    </div>

                </div>
            </div>
        </div>



    </AuthenticatedLayout>
</template>
