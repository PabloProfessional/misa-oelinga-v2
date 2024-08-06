<script setup lang="ts">
import { defineProps } from 'vue';

defineProps({
    count: {
        type: Number,
        required: true
    },
    count_description: {
        type: String,
        required: true
    },
    status_icon: {
        type: String
    },
    progress: {
        type: Object,
        required: true
    }
});
</script>
<template>

            <div v-if="status_icon" class="overflow-hidden shadow-sm sm:rounded-lg w-full flex flex-col justify-between"
                 style="background-color: rgb(63, 98, 18);">
                <div class="p-6 text-7xl font-bold" style="color: whitesmoke">
                    {{ progress['percentage_completion'] }}%
                </div>
                <div class="p-6 text-white" style="color: whitesmoke">
                    <strong>Percentage Completion</strong> - of activity, updated {{ progress['created_at'] }}
                </div>
            </div>

    <div v-if="!status_icon" class="overflow-hidden shadow-sm sm:rounded-lg w-full flex flex-col justify-between"
         style="background-color: rgb(63, 98, 18);">
        <div class="p-6 text-7xl font-bold" style="color: whitesmoke">
            {{ count }}
        </div>
        <div class="p-6 text-white" style="color: whitesmoke">
            {{ count_description }}
        </div>
    </div>

</template>
