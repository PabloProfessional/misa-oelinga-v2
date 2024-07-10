
<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import {defineEmits, watch} from "vue";

const form = useForm({
    projectBudget: '',
    projectSpend: '',
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
            <h2 class="text-lg font-medium text-gray-900">Project financials <small><span class="text-gray-700">| Budget and spend</span></small></h2>

            <p class="mt-1 text-sm text-gray-600">
                Total budget and spend for the project in the current Financial Year
            </p>

        </header>


        <div class="mt-6 space-y-6 max-w-full" >
            <div >
                <InputLabel for="project-name" value="Budget" />
                <TextInput
                    id="project-budget"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.projectBudget"
                    required
                    @input="emitFormValues"
                />

                <InputError class="mt-2" :message="form.errors.projectBudget" />
            </div>
            <div >
                <InputLabel for="project-spend" value="Spend i.e. monies spent at the time of filling this form" />

                <TextInput
                    id="project-spend"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.projectSpend"
                    required
                    @input="emitFormValues"
                />

                <InputError class="mt-2" :message="form.errors.projectSpend" />
            </div>
        </div>
    </section>
</template>





