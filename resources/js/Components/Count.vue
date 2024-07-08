<script setup lang="ts">
import { defineProps } from 'vue';
const props = defineProps<{ count: number }>();
</script>
<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg w-full flex flex-col justify-between"
                 style="background-color: rgb(63, 98, 18);">
                <div class="p-6 text-7xl font-bold" style="color: whitesmoke">{{ count }}</div>
                <div class="p-6 text-white" style="color: whitesmoke">Total number of projects.</div>
            </div>
        </div>
    </div>
</template>
