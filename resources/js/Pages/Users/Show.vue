<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DashboardLineAreaChart from "@/Layouts/DashboardLineAreaChart.vue";
import UserLineAreaChart from "@/Pages/Users/Partials/UserLineAreaChart.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import ReactivateUserAccount from "@/Pages/Profile/Partials/ReactivateUserAccount.vue";

defineProps({
    user: {
        type: Object,
        required: true,
    },
    admin: {
        type: Boolean,
        required: true
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
                <a href="/administrator/users">
                    User Administration
                </a> /
                <strong> {{ user.name }}</strong>


            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                    <div
                        class="overflow-hidden shadow-sm sm:rounded-lg w-full flex flex-col justify-between"
                        :style="{ backgroundColor: user.is_active ? 'rgb(63, 98, 18)'  :  'rgb(248, 113, 113)'}"
                    >
                        <div class="p-6 text-7xl font-bold" style="color: whitesmoke">{{ user.name }}</div>
                        <div class="p-6 text-white" style="color: whitesmoke">
                            <a href="mailto:{{ user.email }}">{{ user.email }}</a>
                            <br> <span v-if="user.is_active">Active </span>
                            <span v-if="!user.is_active">Account Deactivated</span>
                            <span v-if="admin"> | Administrator</span>

                        </div>
                    </div>
                    <a
                        href="#"
                        class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#c45d25] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#c45d25]"
                    >


                        <div class="pt-3 sm:pt-5">
                            <h2 class="text-xl font-semibold text-black dark:text-white" style="color: #343c54">Recent Activities</h2>

                            <ul>
                                <li class="flex items-center mt-4" v-for="activity in user.user_activity" :key="activity">
                                    <span class="inline-block w-2.5 h-2.5 bg-blue-300 rounded-full mr-3"></span>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        <strong class="font-medium">{{ activity.activity_type.name }}</strong> - <strong class="font-semibold">{{ formatDate(activity.activity_type.created_at) }}</strong>
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




                </div>
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                            :admin_user="user"

                        />
                    </div>
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <UpdatePasswordForm class="max-w-xl" :admin_user="user" />
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" v-if="user.is_active">
                        <DeleteUserForm class="max-w-xl" :admin_user="user" />
                    </div>
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" v-if="!user.is_active">
                        <ReactivateUserAccount class="max-w-xl" :admin_user="user" />
                    </div>
                </div>
            </div>

        </div>


    </AuthenticatedLayout>
</template>
