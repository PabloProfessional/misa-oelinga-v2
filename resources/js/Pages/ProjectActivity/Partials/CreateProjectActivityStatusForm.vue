
<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import {watch, defineEmits} from "vue";

defineProps<{
    status_procurement?: object;
    status_budget?: object;
    status_risk?: object;
    status_schedule?: object;
}>();

const form = useForm({
    procurement_status: '',
    budget_status: '',
    risk_status: '',
    schedule_status: '',
});

// Define emits
const emit = defineEmits(['update:form', 'submit']);

// Emit form values to parent
const emitFormValues = () => {
    emit('update:form', form);
};

// Watch for changes in form and emit updates
watch(form, (newForm) => {
    emit('update:form', newForm);
}, { deep: true });

// Handle form submission
const submitForm = () => {
    emit('submit', form);
};

</script>


<template>
    <section >
        <header>
            <h2 class="text-lg font-medium text-gray-900">Current Status<small><span class="text-gray-700"> | YTD status of various elements of the project</span></small></h2>

            <p class="mt-1 text-sm text-gray-600">
                This form seeks to gather information on risk, budget, procurement and schedule of the project
            </p>

        </header>


        <div class="mt-6 space-y-6 max-w-full" >
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <InputLabel for="project_status_procurement" value="Procurement status" />
                    <select
                        id="project_status_procurement"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.procurement_status"
                        required
                        @input="emitFormValues"
                    >
                        <option disabled value="">Has procurement been done?</option>
                        <option v-for="project_status_procurement in status_procurement" :key="project_status_procurement['id']" :value="project_status_procurement['id']">
                            {{ project_status_procurement['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.procurement_status" />
                </div>

                <div>
                    <InputLabel for="project_status_budget" value="Budget status" />
                    <select
                        id="project_status_budget"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.budget_status"
                        required
                        @input="emitFormValues"
                    >
                        <option disabled value="">Select the current budget status</option>
                        <option v-for="project_status_budget in status_budget" :key="project_status_budget['id']" :value="project_status_budget['id']">
                            {{ project_status_budget['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.budget_status" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <InputLabel for="project_status_risk" value="Project Risk Status" />
                    <select
                        id="project_status_risk"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.risk_status"
                        required
                        @input="emitFormValues"
                    >
                        <option disabled value="">Select the appropriate level of risk.</option>
                        <option v-for="project_status_risk in status_risk" :key="project_status_risk['id']" :value="project_status_risk['id']">
                            {{ project_status_risk['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.risk_status" />
                </div>

                <div>
                    <InputLabel for="project_status_budget" value="Scheduling" />
                    <select
                        id="project_status_schedule"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.schedule_status"
                        required
                        @input="emitFormValues"
                    >
                        <option disabled value="">Has scheduling been done?</option>
                        <option v-for="project_status_schedule in status_schedule" :key="project_status_schedule['id']" :value="project_status_schedule['id']">
                            {{ project_status_schedule['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.schedule_status" />
                </div>
            </div>
        </div>
    </section>
</template>





