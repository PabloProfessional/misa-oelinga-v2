<script setup lang="ts">
//TODO To calculate allocations we'll have to attach that to activities within project with budgets
import { defineProps } from 'vue';
defineProps({
    budget: {
        type: Number,
        required: true,
    },
    budget_allocation: {
        type: Number,
        required: true
    }
});

// const proper_budget = () => {
//     if (props.budget < 1) {
//         return (props.budget * 1000000).toLocaleString('En-US');
//     }
//     return props.budget?.toPrecision(2)+" million";
// }

</script>
<template>
            <div
               href="#"
                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
            >

                <div class="pt-3 sm:pt-5">
                    <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Budget | <small>Total YTD</small> </h2>
                    <br>
                    <p class="text-3xl font-bold" style="color: dimgrey">R {{budget}} million</p>
                    <p style="color: dimgrey"><strong>{{ budget_allocation }}%</strong> allocated</p>

                </div>

            </div>
</template>
