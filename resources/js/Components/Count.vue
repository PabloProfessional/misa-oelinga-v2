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
    }
});
</script>
<template>

            <div v-if="status_icon" class="overflow-hidden shadow-sm sm:rounded-lg w-full flex flex-col justify-between"
                 style="background-color: rgb(63, 98, 18);">
                <div class="p-6 text-7xl font-bold" style="color: whitesmoke">
                    <i :class="status_icon"></i>

                </div>
                <div class="p-6 text-white" style="color: whitesmoke">
                    <strong>{{ count }}</strong> - {{ count_description }}
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
