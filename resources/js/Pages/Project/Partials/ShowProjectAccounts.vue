<script setup lang="ts">

import SecondaryButton from "@/Components/SecondaryButton.vue";
import {defineProps} from "vue";

defineProps({
    accounts: {
        type: Object
    }
});

</script>

<template>
    <section class="space-y-6">

        <a
            href="#"
            id="docs-card"
            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
        >
            <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">

                <DashboardBarChart class="mt-6" style="width: 100%;"></DashboardBarChart>
            </div>


            <div class="relative flex items-center gap-6 lg:items-end">
                <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">


                    <div class="pt-3 sm:pt-5 lg:pt-0">
                        <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54; margin-bottom: 2em;">
                            Project Accounts
                            <small> | Summary YTD</small>
                        </h2>

                        <table class="mt-4 text-sm/relaxed table table-striped w-full table-auto" style="width: 1100px;">
                            <thead class="table-header-group">
                            <tr style="text-align: left;">
                                <th style="text-align: left;"><strong>Date</strong><hr></th>
                                <th style="text-align: left;"><strong>Description</strong><hr></th>
                                <th style="text-align: right;"><strong>Debit</strong><hr></th>
                                <th style="text-align: right;"><strong>Credit</strong><hr></th>
                                <th style="text-align: right;"><strong>Balance</strong><hr></th>
                            </tr>

                            </thead>

                            <tbody class="table-row-group" v-for="account in accounts">
                            <br>
                            <tr class="w-full table-row">
                                <th scope="row" style="text-align: left;">
                                    {{new Date(account['created_at']).toDateString()}}
                                </th>
                                <th scope="row" style="text-align: left;">
                                    {{account['description']}}
                                </th>
                                <td style="text-align: right;">R {{ (account['debit']/100).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })}}
                                </td>
                                <td style="text-align: right;">R {{ (account['credit']/100).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })}}
                                </td>

                                <td style="text-align: right;">R {{ (account['balance']/100).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })}}
                                </td>
                            </tr>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </a>

    </section>
</template>
