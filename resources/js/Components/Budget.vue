<script setup lang="ts">
//TODO To calculate allocations we'll have to attach that to activities within project with budgets
import { defineProps } from 'vue';
const props = defineProps({
    budget: {
        type: Number,
        required: true,
    },
    budget_allocation: {
        type: Number
    }
});

const proper_budget = () => {
    if (props.budget < 1) {
        return (props.budget * 1000000).toLocaleString('En-US');
    }
    return props.budget+" million";
}

</script>
<template>
            <a
               href="#"
                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
            >
<!--                <div-->
<!--                    class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#c45d25]/10 sm:size-16"-->
<!--                >-->
<!--                    <svg-->
<!--                        class="size-5 sm:size-6"-->
<!--                        xmlns="http://www.w3.org/2000/svg"-->
<!--                        fill="none"-->
<!--                        viewBox="0 0 24 24"-->
<!--                    >-->
<!--                        <g fill="#c45d25">-->
<!--                            <path-->
<!--                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"-->
<!--                            />-->
<!--                            <path-->
<!--                                d="M13 7h-2v6l5.25 3.15.75-1.23-4.5-2.67z"-->
<!--                            />-->
<!--                        </g>-->
<!--                    </svg>-->
<!--                </div>-->

                <div class="pt-3 sm:pt-5">
                    <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Budget | <small>Total YTD</small> </h2>
                    <br>
                    <p class="text-3xl font-bold" style="color: dimgrey">R {{proper_budget()}}</p>
                    <p style="color: dimgrey"><strong>{{ budget_allocation }}%</strong> allocated</p>

                </div>

            </a>
</template>
