<script setup lang="ts">
import { defineProps } from 'vue';
const props = defineProps<{ count: number, count_description: string }>();
</script>
<template>

            <div class="overflow-hidden shadow-sm sm:rounded-lg w-full flex flex-col justify-between"
                 style="background-color: rgb(63, 98, 18);">
                <div class="p-6 text-7xl font-bold" style="color: whitesmoke">{{ count }}</div>
                <div class="p-6 text-white" style="color: whitesmoke">{{ count_description }}</div>
            </div>

</template>
