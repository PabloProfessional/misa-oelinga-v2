<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import CreateProjectActivityDescriptionForm
    from "@/Pages/ProjectActivity/Partials/CreateProjectActivityDescriptionForm.vue";
import CreateProjectActivityBudgetForm from "@/Pages/ProjectActivity/Partials/CreateProjectActivityBudgetForm.vue";
import CreateProjectActivityDurationForm from "@/Pages/ProjectActivity/Partials/CreateProjectActivityDurationForm.vue";
import CreateProjectActivityFinalDetailsForm
    from "@/Pages/ProjectActivity/Partials/CreateProjectActivityFinalDetailsForm.vue";
import CreateProjectActivityStatusForm from "@/Pages/ProjectActivity/Partials/CreateProjectActivityStatusForm.vue";
import SubmitProjectActivityCreateForm from "@/Pages/ProjectActivity/Partials/SubmitProjectActivityCreateForm.vue";
import {defineProps} from "vue";

const props = defineProps({
    project: {
        type: Object,
        required: true
    },
    project_activity_types: {
        type: Object,
        required: true
    },
    project_stage_types:{
        type: Object,
        required: true
    },
    status_procurement: {
        type: Object,
        required: true
    },
    status_budget: {
        type: Object,
        required: true
    },
    status_risk: {
        type: Object,
        required: true
    },
    status_schedule: {
        type: Object,
        required: true
    },
    users: {
        type: Object,
        required: true
    }
});


const form = useForm({
    project_url: '',
    name:'',
    project_activity_type: '',
    description:'',
    budget: '',
    spend: '',
    start_date: '',
    end_date: '',
    project_stage: '',
    procurement_status: '',
    budget_status: '',
    risk_status: '',
    schedule_status: '',
    manager: '',
    team_members: '',
    logo: '',
    attachment: '',
    notes: ''
});

const updateFormValues1 = (updatedForm: any) => {
    form.name = updatedForm.name;
    form.description = updatedForm.description;
    form.project_activity_type = updatedForm.project_activity_type;
    form.project_url = props.project['url'];
};
const updateFormValues2 = (updatedForm: any) => {
    form.budget = updatedForm.budget;
    form.spend = updatedForm.spend;
};

const updateFormValues3 = (updatedForm: any) => {
    form.start_date = updatedForm.start_date;
    form.end_date = updatedForm.end_date;
    form.project_stage = updatedForm.project_stage;
};

const updateFormValues4 = (updatedForm: any) => {
    form.procurement_status = updatedForm.procurement_status;
    form.budget_status = updatedForm.budget_status;
    form.risk_status = updatedForm.risk_status;
    form.schedule_status = updatedForm.schedule_status;
};

const updateFormValues5 = (updatedForm: any) => {
    form.manager = updatedForm.manager;
    form.team_members = updatedForm.team_members;
    form.logo = updatedForm.logo;
    form.attachment = updatedForm.attachment;
    form.notes = updatedForm.notes;
};

// Function to handle form submission
const handleSubmit = () => {
    form.post(route('project_activity.store'));
};

</script>

<template>
    <Head title="Project create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add a new project activity to: {{ project['name'] }} </h2>
            <p style="margin-top: 10px; color: grey; font-size: small;">

                <a href="/dashboard">
                    Dashboard
                </a> /
                <a :href="'/project/'+project['url']">
                    {{ project['name'] }}
                </a> /
                <strong> Add a project activity </strong>
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <form @submit.prevent="handleSubmit">
                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg " >
                        <CreateProjectActivityDescriptionForm
                            class="max-w-xl"
                            :form="form"
                            :project_activity_types="project_activity_types"
                            :project_url="project['url']"
                            @update:form="updateFormValues1"
                        />
                    </div>

                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <CreateProjectActivityBudgetForm
                            class="max-w-xl"
                            :form="form"
                            @update:form="updateFormValues2"
                        />
                    </div>

                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <CreateProjectActivityDurationForm
                            class="max-w-xl"
                            :project_stage_types="project_stage_types"
                            :form="form"
                            @update:form="updateFormValues3"
                        />
                    </div>
                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <CreateProjectActivityStatusForm
                            class="max-w-xl"
                            :status_procurement="status_procurement"
                            :status_budget="status_budget"
                            :status_risk="status_risk"
                            :status_schedule="status_schedule"
                            :form="form"
                            @update:form="updateFormValues4"
                        />
                    </div>
                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <CreateProjectActivityFinalDetailsForm
                            class="max-w-xl"
                            :users="users"
                            :form="form"
                            @update:form="updateFormValues5"
                        />
                    </div>
                    <div class="p-4 sm:p-12 bg-white shadow sm:rounded-lg mt-12" >
                        <SubmitProjectActivityCreateForm></SubmitProjectActivityCreateForm>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
