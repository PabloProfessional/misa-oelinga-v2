<script setup lang="ts">

import PrimaryButton from "@/Components/PrimaryButton.vue";

</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Save Project Details</h2>

            <p class="mt-1 text-sm text-gray-600">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
                your account, please download any data or information that you wish to retain.
            </p>
        </header>

        <PrimaryButton type="submit">Save Project Details</PrimaryButton>

    </section>
</template>
