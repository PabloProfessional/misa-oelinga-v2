<script setup lang="ts">

import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
function goToCreateProjectActivity(url: string) {
    window.location.href = `/project_activity_create/${url}`;
}

const props = defineProps({
    project: {
        type: Object,
        required: true
    },
    project_activities: {
        type: Object,
        required: true
    }
});

function formatNumber(n: any) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

</script>

<template>
    <section class="space-y-6">

        <div
            id="docs-card"
            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
        >
            <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">
                <DashboardBarChart class="mt-6" style="width: 100%;"></DashboardBarChart>
            </div>


            <div class="relative flex items-center gap-6 lg:items-end">
                <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                    <div class="pt-3 sm:pt-5 lg:pt-0">
                        <h2 class="text-xl font-semibold text-black dark:text-white"
                            style="color: #343c54">
                            Project Activity List |
                            <small>
                                <PrimaryButton @click="goToCreateProjectActivity(project['url'])" >Add a project activity</PrimaryButton>
                            </small>
                        </h2>

                        <p class="mt-4 text-sm/relaxed">

                        </p>
                        <table class="mt-4 text-sm/relaxed table table-striped w-full table-auto" style="width: 900px;">
                            <thead class="table-header-group">
                            <tr style="text-align: left;">
                                <th>Activity Name<hr></th>
                                <th style="text-align: right;"><strong>Budget</strong><hr></th>
                                <th style="text-align: right;"><strong>Spend</strong><hr></th>
                                <th style="text-align: right;"><strong>Average Status</strong><hr></th>
                                <th style="text-align: right;"><strong>Notes</strong><hr></th>
                            </tr>

                            </thead>

                            <tbody class="table-row-group" v-for="activity in project_activities" :key="activity['id']">
                            <br>
                            <tr class="w-full table-row">
                                <th scope="row" >
                                    <SecondaryButton
                                        style="float: left; width: 80%; margin: 0.3em;"
                                    >
                                        {{ activity['name'] }}
                                    </SecondaryButton>
                                </th>
                                <td style="text-align: right;">R {{ (activity['budget'] / 100 ).toLocaleString('en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })}}
                                </td>
                                <td style="text-align: right;">R {{ (activity['spend'] / 100 ).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })}}
                                </td>
                                <td style="text-align: right;">
                                                    <span class="badge badge-primary" :style="{ color: project.average_status_color }">
                                                       <i :class="project['average_status_icon']"></i> {{ project['average_status_name'] }}
                                                    </span>
                                </td>
                                <td style="text-align: right;"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
</template>
