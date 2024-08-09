<script setup lang="ts">

import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
function goToCreateProjectActivity(url: string) {
    window.location.href = `/project_activity_create/${url}`;
}

const props = defineProps({
    project: {
        type: Object,
        required: true
    },
});

function formatTimestamp(filename: any) {
    const timestamp = filename.split('_').pop().split('.').shift();
    const date = new Date(parseInt(timestamp) * 1000);

    return date.toLocaleDateString('en-GB', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    });
}

function getFilenameWithoutExtension(filename: any) {
    const fullFilename = filename.split('/').pop();
    return fullFilename.split('.').slice(0, -1).join('.');
}



</script>

<template>
    <section class="space-y-6">

        <div
            id="docs-card"
            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
        >


            <div class="relative flex items-center gap-6 lg:items-end">
                <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                    <div class="pt-3 sm:pt-5 lg:pt-0">
                        <h2 class="text-xl font-semibold text-black dark:text-white"
                            style="color: #343c54; margin-bottom: 2em;">
                            Attatchments <small>| Supporting documentation</small>

                        </h2>
                        <table class="mt-4 text-sm/relaxed table table-striped w-full table-auto" style="width: 1100px;">
                            <thead class="table-header-group">
                            <tr style="text-align: left;">
                                <th>Document<hr></th>
                                <th style="text-align: right;"><strong>Type</strong><hr></th>
                                <th style="text-align: right;"><strong>Date Uploaded</strong><hr></th>
                                <th style="text-align: right;"><strong>Notes</strong><hr></th>
                            </tr>

                            </thead>

                            <tbody class="table-row-group" v-for="(value, key) in (JSON.parse(project['attachments']))" :key="key">
                            <br>
                            <tr class="w-full table-row">
                                <th scope="row" >
                                    <SecondaryButton
                                        style="float: left; width: 80%; margin: 0.3em;"
                                    >
                                        {{ getFilenameWithoutExtension(value)}}
                                    </SecondaryButton><br>
                                </th>
                                <td style="text-align: right;">
                                    {{ value.split('.').pop() }}
                                </td>
                                <td style="text-align: right;">
                                    {{ formatTimestamp(value)}}
                                </td>
                                <td style="text-align: right;"></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </section>
</template>
