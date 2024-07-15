<script setup lang="ts">

import PrimaryButton from "@/Components/PrimaryButton.vue";

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
                        <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">
                            Project Accounts
                            <small> | Summary YTD</small>
                        </h2>


                    </div>
                </div>
            </div>
        </a>

    </section>
</template>
