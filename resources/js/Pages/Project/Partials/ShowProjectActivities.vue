<script setup lang="ts">

import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import axios from "axios";
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
    },
    activity_risk_status: {
        type: Array,
        required: true
    }
});


let duration = null;
function calculateDuration(startDate: any, endDate: any) {
    const start_date: any = new Date(startDate);
    const end_date: any = new Date(endDate);
    const diffInMilliseconds = end_date - start_date;
    duration = diffInMilliseconds / (1000 * 60 * 60 * 24);

    if (duration >= 365) {
        return (duration / 365).toFixed(2) + ' years';
    } else if (duration < 365 && duration > 31) {
        const startYear = start_date.getFullYear();
        const startMonth = start_date.getMonth();
        const endYear = end_date.getFullYear();
        const endMonth = end_date.getMonth();

        const months = (endYear - startYear) * 12 + (endMonth - startMonth);
        return months + ' months';
    } else {
        return duration + ' days';
    }
}

let fundsAvailable = 0;

function determineFundsAvailable(budget: any, spend: any) {
    fundsAvailable = ((budget - spend) / 100);
    return fundsAvailable;

}

function goToProjectActivity(url: any) {
    window.location.href = `/project_activity/${url}`;
}

// const activities = props.activity_risk_status;
//
// const activity_risk = activities.filter((word: any) => word.id === 9);


</script>

<template>
    <section class="space-y-6">

        <div
            id="docs-card"
            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
        >


            <div class="relative flex items-center gap-6 lg:items-end">
                <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                    <div class="pt-3 sm:pt-5 lg:pt-0">
                        <h2 class="text-xl font-semibold text-black dark:text-white"
                            style="color: #343c54; margin-bottom: 2em;">
                            Activity List <small>| of tasks to expedite project delivery</small>
                            <small style="float: right;">
                                <PrimaryButton @click="goToCreateProjectActivity(project['url'])" >Add a project activity</PrimaryButton>
                            </small>
                        </h2>

                        <table class="mt-4 text-sm/relaxed table table-striped w-full table-auto" style="width: 1100px;">
                            <thead class="table-header-group">
                            <tr style="text-align: left;">
                                <th>Activity<hr></th>
                                <th style="text-align: right;"><strong>Budget Status</strong><hr></th>
                                <th style="text-align: right;"><strong>Funds Available</strong><hr></th>
                                <th style="text-align: right;"><strong>Duration</strong><hr></th>
                                <th style="text-align: right;"><strong>Risk Status</strong><hr></th>
                            </tr>

                            </thead>

                            <tbody class="table-row-group" v-for="activity in project_activities" :key="activity['id']">
                            <br>
                            <tr class="w-full table-row">
                                <th scope="row" >
                                    <SecondaryButton
                                        @click="goToProjectActivity(activity['id'])"
                                        style="float: left; width: 80%; margin: 0.3em;"
                                    >
                                        {{ activity['activity_type']['name'] }}: {{ activity['name'] }}
                                    </SecondaryButton>

                                    <!--                                    {{ activity }}-->
                                </th>
                                <td style="text-align: right;">
                                    <p :style="{ color: determineFundsAvailable(activity['budget'], activity['spend']) >= 0 ? 'green' : 'red' }">
                                        <i :class="determineFundsAvailable(activity['budget'], activity['spend']) >= 0 ? 'bi bi-check-circle-fill' : 'bi bi-exclamation-triangle-fill'"></i>
                                        {{ determineFundsAvailable(activity['budget'], activity['spend']) >= 0 ? 'On budget' : 'Overspend' }}
                                    </p>
                                </td>

                                <td style="text-align: right;">R {{ (determineFundsAvailable(activity['budget'], activity['spend'])).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })}}
                                </td>

                                <td style="text-align: right;">
                                    {{ calculateDuration(activity['start_date'],activity['end_date']) }}
                                </td>
                                <td style="text-align: right;">
                                    <span class="badge badge-primary" :style="{ color: activity.average_status_color }">
                                       <i :class="activity['average_status_icon']"></i> {{ activity['average_status_name'] }}
                                    </span>
                                    <span class="badge badge-primary" id="risk-status-{{ activity['id'] }}" data-activity-id="{{ activity['id'] }}">
                                       {{ activity_risk_status.filter((word: any) => word.id === activity['id'])[0] }}

                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </section>
</template>
