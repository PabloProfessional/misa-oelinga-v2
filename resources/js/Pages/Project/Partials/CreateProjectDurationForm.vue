
<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import {watch, defineEmits} from "vue";

defineProps<{
    project_stage_types?: object;
}>();

const form = useForm({
    start_date: '',
    end_date: '',
    project_stage: '',
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
            <h2 class="text-lg font-medium text-gray-900">Planned  Duration<small><span class="text-gray-700"> | or project timeline</span></small></h2>

            <p class="mt-1 text-sm text-gray-600">
                Start and end dates of the project with stage the project is currently in.
            </p>

        </header>


        <div class="mt-6 space-y-6 max-w-full" >
            <div class="grid grid-cols-2 gap-4">
                <div >
                    <InputLabel for="project-start" value="Start" />
                    <TextInput
                        id="project-start"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.start_date"
                        required
                        @input="emitFormValues"
                    />

                    <InputError class="mt-2" :message="form.errors.start_date" />
                </div>
                <div >
                    <InputLabel for="project-end" value="End" />

                    <TextInput
                        id="project-end"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.end_date"
                        required
                        @input="emitFormValues"
                    />

                    <InputError class="mt-2" :message="form.errors.end_date" />
                </div>
            </div>
            <div>
                <InputLabel for="project_stage_types" value="Project Stage" />
                <select
                    id="project_stage_types"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    v-model="form.project_stage"
                    required
                    @input="emitFormValues"
                >
                    <option disabled value="">Select the stage of the project</option>
                    <option v-for="project_stage_type in project_stage_types" :key="project_stage_type['id']" :value="project_stage_type['id']">
                        {{ project_stage_type['name'] }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.project_stage" />
            </div>
        </div>
    </section>
</template>





