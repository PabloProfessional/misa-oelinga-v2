<script setup lang="ts">
import {computed, defineProps} from 'vue';
const props = defineProps({
    spend: {
        type: Number,
        required: true,
    },
    variance: {
        type: Number,
        required: true,
    },
});
const varianceDescription = computed(() => {
    return props.variance >= 0 ? 'underspend' : 'overspend';
});

// const proper_spend = () => {
//     if (props.spend < 1) {
//         return (props.spend * 1000000).toLocaleString('En-US');
//     }
//     return props.spend?.toPrecision(2)+" million";
// }

</script>
<template>
            <div
                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
            >

                <div class="pt-3 sm:pt-5">
                    <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Spend | <small>Total YTD</small> </h2>
                    <br>
                    <p class="text-3xl font-bold" style="color: dimgrey">R {{spend}} million</p>
                    <p style="color: dimgrey"><strong>{{variance}}%</strong> {{ varianceDescription }}</p>
                </div>

            </div>
</template>
