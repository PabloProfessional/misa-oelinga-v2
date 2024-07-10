<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CreateProjectDescriptionForm from "@/Pages/Project/Partials/CreateProjectDescriptionForm.vue";
import CreateProjectBudgetForm from "@/Pages/Project/Partials/CreateProjectBudgetForm.vue";
import CreateProjectDurationForm from "@/Pages/Project/Partials/CreateProjectDurationForm.vue";
import CreateProjectStatusForm from "@/Pages/Project/Partials/CreateProjectStatusForm.vue";
import CreateProjectFinalDetailsForm from "@/Pages/Project/Partials/CreateProjectFinalDetailsForm.vue";

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
    programmes?: object;
    provinces?: object;
    departments?: object;
    sectors?: object;
    project_stage_types?: object;
    status_procurement?: object;
    status_budget?: object;
    status_risk?: object;
    status_schedule?: object;
    users?: object;
}>();
</script>

<template>
    <Head title="Project create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create a project record</h2>
            <p style="margin-top: 10px; color: grey; font-size: small;">

                <a href="/dashboard">
                    Dashboard
                </a> /
                <strong> Add a project </strong>
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <form @submit.prevent="form.post(route('project.create'))">
                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg " >
                        <CreateProjectDescriptionForm
                            class="max-w-xl"
                            :programmes="programmes"
                            :provinces="provinces"
                            :departments="departments"
                            :sectors="sectors"
                        />
                    </div>

                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <CreateProjectBudgetForm
                            class="max-w-xl"
                        />
                    </div>

                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <CreateProjectDurationForm
                            class="max-w-xl"
                            :project_stage_types="project_stage_types"
                        />
                    </div>
                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <CreateProjectStatusForm
                            class="max-w-xl"
                            :status_procurement="status_procurement"
                            :status_budget="status_budget"
                            :status_risk="status_risk"
                            :status_schedule="status_schedule"
                        />
                    </div>
                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <CreateProjectFinalDetailsForm
                            class="max-w-xl"
                            :users="users"
                        />
                    </div>
                </form>



<!--                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">-->
<!--                    <DeleteUserForm class="max-w-xl" />-->
<!--                </div>-->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
