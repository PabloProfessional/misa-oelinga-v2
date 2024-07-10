<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import CreateProjectDescriptionForm from "@/Pages/Project/Partials/CreateProjectDescriptionForm.vue";
import CreateProjectBudgetForm from "@/Pages/Project/Partials/CreateProjectBudgetForm.vue";
import CreateProjectDurationForm from "@/Pages/Project/Partials/CreateProjectDurationForm.vue";
import CreateProjectStatusForm from "@/Pages/Project/Partials/CreateProjectStatusForm.vue";
import CreateProjectFinalDetailsForm from "@/Pages/Project/Partials/CreateProjectFinalDetailsForm.vue";
import SubmitProjectCreateForm from "@/Pages/Project/Partials/SubmitProjectCreateForm.vue";


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

const form = useForm({
    projectName:'',
    uniqueNumber:'',
    programme:'',
    description:'',
    province: '',
    municipality: '',
    department: '',
    sector: '',
    projectBudget: '',
    projectSpend: '',
    projectStart: '',
    projectEnd: '',
    projectStage: '',
    projectStatusProcurement: '',
    projectStatusBudget: '',
    projectStatusRisk: '',
    projectStatusSchedule: '',
    project_manager: '',
    project_team: '',
    logo: '',
    attachment: '',
    notes: ''
});

const updateFormValues = (updatedForm: any) => {
    form.projectName = updatedForm.projectName;
    form.uniqueNumber = updatedForm.uniqueNumber;
    form.programme = updatedForm.programme;
    form.description = updatedForm.description;
    form.province = updatedForm.province;
    form.municipality = updatedForm.municipality;
    form.department = updatedForm.department;
    form.sector = updatedForm.sector;
    // form.projectBudget = updatedForm.projectBudget;
    // form.projectSpend = updatedForm.projectSpend;
    // form.projectStart = updatedForm.projectStart;
    // form.projectEnd = updatedForm.projectEnd;
    // form.projectStage = updatedForm.projectStage;
    // form.projectStatusProcurement = updatedForm.projectStatusProcurement;
    // form.projectStatusBudget = updatedForm.projectStatusBudget;
    // form.projectStatusRisk = updatedForm.projectStatusRisk;
    // form.projectStatusSchedule = updatedForm.projectStatusSchedule;
    // form.project_manager = updatedForm.project_manager;
    // form.project_team = updatedForm.project_team;
    // form.logo = updatedForm.logo;
    // form.attachment = updatedForm.attachment;
    // form.notes = updatedForm.notes;
};

// Function to handle form submission
const handleSubmit = () => {
    form.post(route('project.store'));
};

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
<!--                <form @submit.prevent="form.post(route('project.store'))">-->
                    <form @submit.prevent="handleSubmit">
                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg " >
                        <CreateProjectDescriptionForm
                            class="max-w-xl"
                            :form="form"
                            @update:form="updateFormValues"
                            :programmes="programmes"
                            :provinces="provinces"
                            :departments="departments"
                            :sectors="sectors"
                        />
                    </div>

<!--                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >-->
<!--                        <CreateProjectBudgetForm-->
<!--                            class="max-w-xl"-->
<!--                        />-->
<!--                    </div>-->

<!--                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >-->
<!--                        <CreateProjectDurationForm-->
<!--                            class="max-w-xl"-->
<!--                            :project_stage_types="project_stage_types"-->
<!--                        />-->
<!--                    </div>-->
<!--                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >-->
<!--                        <CreateProjectStatusForm-->
<!--                            class="max-w-xl"-->
<!--                            :status_procurement="status_procurement"-->
<!--                            :status_budget="status_budget"-->
<!--                            :status_risk="status_risk"-->
<!--                            :status_schedule="status_schedule"-->
<!--                        />-->
<!--                    </div>-->
<!--                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >-->
<!--                        <CreateProjectFinalDetailsForm-->
<!--                            class="max-w-xl"-->
<!--                            :users="users"-->
<!--                        />-->
<!--                    </div>-->
                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <SubmitProjectCreateForm></SubmitProjectCreateForm>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
