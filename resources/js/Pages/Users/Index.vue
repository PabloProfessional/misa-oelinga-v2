<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import UserLineAreaChart from "@/Pages/Users/Partials/UserLineAreaChart.vue";


const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    user_count: {
        type: Number,
        required: true,
    },
    months: {
        type: Array,
        required: true
    },
    month_data: {
        type: Array,
        required: true
    }
});

function formatDate (dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Administration</h2>
            <p style="margin-top: 10px; color: grey; font-size: small;">

                <a href="/dashboard">
                    Dashboard
                </a> /
                <strong> User Administration </strong>
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg w-full flex flex-col justify-between"
                         style="background-color: rgb(63, 98, 18);">
                        <div class="p-6 text-7xl font-bold" style="color: whitesmoke">{{ user_count }}</div>
                        <div class="p-6 text-white" style="color: whitesmoke">Total number of users</div>
                    </div>
                    <a
                        href="#"
                        class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                    >


                        <div class="pt-3 sm:pt-5">
                            <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Recent Activities</h2>

                            <ul>
                                <li class="flex items-center mt-4">
                                    <span class="inline-block w-2.5 h-2.5 bg-blue-300 rounded-full mr-3"></span>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        <strong class="font-medium">Info</strong> - Pablo's - <strong class="font-semibold">user details</strong> captured
                                    </p>
                                </li>
                                <li class="flex items-center mt-4">
                                    <span class="inline-block w-2.5 h-2.5 bg-blue-300 rounded-full mr-3"></span>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        <strong class="font-medium">Info</strong> - Pablo - <strong class="font-semibold">Added to administrator </strong> group
                                    </p>
                                </li>
                                <li class="flex items-center mt-4">
                                    <span class="inline-block w-2.5 h-2.5 bg-red-500 rounded-full mr-3"></span>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        <strong class="font-medium">Critical</strong> - 2 days <strong class="font-semibold">no user activity</strong> 100% offline
                                    </p>
                                </li>
                                <li class="flex items-center mt-4">
                                    <span class="inline-block w-2.5 h-2.5 bg-gray-500 rounded-full mr-3"></span>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        <strong class="font-medium">Service</strong> - System Reboot<strong class="font-semibold"> Needed</strong> in 2 days
                                    </p>
                                </li>
                            </ul>



                        </div>


                    </a>

                </div>

                <a
                    href="#"
                    id="docs-card"
                    class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                >
                    <div id="screenshot-container" class="relative flex w-full flex-1 items-stretch" style="width: 100%;">
                        <UserLineAreaChart class="mt-6" style="width: 100%;" :months="months" :month_data="month_data"></UserLineAreaChart>
                    </div>


                    <div class="relative flex items-center gap-6 lg:items-end">
                        <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                            <div class="pt-3 sm:pt-5 lg:pt-0">
                                <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Measurement trend analysis</h2>

                                <p class="mt-4 text-sm/relaxed">
                                    The above chart shows a trend analysis of key measurements.
                                </p>

                            </div>
                        </div>
                    </div>
                </a>

                <br>
                <hr>
                <br>
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">

                    <span

                        class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                    >


                        <div class="pt-3 sm:pt-5">
                            <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Administrative Tasks</h2>

                            <p class="mt-2 text-sm/relaxed">
                                The administrator can perform tasks like changing passwords, changing roles, etc by clicking on individual user profiles below.
                            </p>

                        </div>

                    </span>


                    <a
                        v-for="user in users" :key="user.id"
                        :href="`/administrator/users/${user.id}`"
                        class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                    >
                        <div
                            class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#c45d25]/10 sm:size-16"
                        >
                            <svg
                                class="size-5 sm:size-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <g fill="#c45d25">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"
                                    />
                                    <path
                                        d="M13 7h-2v6l5.25 3.15.75-1.23-4.5-2.67z"
                                    />
                                </g>
                            </svg>
                        </div>

                        <div class="pt-3 sm:pt-5">
                            <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">{{ user.name }}</h2>

                            <p class="mt-4 text-sm/relaxed">
                                <span style="font-size: 20px"><strong>{{ user.email }}</strong></span>
<!--                                <span style="font-size: 20px"><br>{{ formatDate(user.created_at) }}</span> date registered.-->
                                <br>
                                <span v-if="user.is_active" >
                                    <span class="inline-block w-2.5 h-2.5 bg-blue-300 rounded-full mr-3"></span>
                                <strong>Latest activity</strong>  <span v-if="user.latest_activity" >{{ user.latest_activity.activity_type.name }} - {{ formatDate(user.latest_activity.created_at)  }}.</span>
                                </span>

                                <span v-if="!user.is_active">
                                    <span class="inline-block w-2.5 h-2.5 bg-red-400 rounded-full mr-3"></span>
                                <strong>Account deactivated</strong>
                                </span>
                            </p>


                        </div>
                        <svg
                            class="size-6 shrink-0 self-center stroke-[#c45d25]"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                            />
                        </svg>
                    </a>

                </div>

            </div>

        </div>


    </AuthenticatedLayout>
</template>
