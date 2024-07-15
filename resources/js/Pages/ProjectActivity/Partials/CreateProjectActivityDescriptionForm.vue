<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import {ref, defineEmits, watch} from "vue";
import axios from "axios";
// TODO the form will save only after all data is collected.
defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
    programmes?: object;
    provinces?: object;
    departments?: object;
    sectors?: object;
}>();

const user = usePage().props.auth.user;



const form = useForm({
    name:'',
    project_number:'',
    programme:'',
    description:'',
    province: '',
    municipality: '',
    department: '',
    sector: '',
});

// Municipalities data
const municipalities = ref();

// Function to fetch municipalities by province ID
const fetchMunicipalities = async () => {
    if (form.province) {
        try {
            const response = await axios.get(`/municipalities/by_province/${form.province}`);
            municipalities.value = response.data.municipalities;
        } catch (error) {
            console.error('Failed to fetch municipalities:', error);
        }
    }
};


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
            <h2 class="text-lg font-medium text-gray-900">Project Activity
                <small><span class="text-gray-700">|  Creation Form</span></small></h2>
        </header>

        <div class="mt-6 space-y-6 max-w-full" >
            <div >
                <InputLabel for="project-name" value="Activity name" />

                <TextInput
                    id="project-name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="project-name"
                    @input="emitFormValues"

                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div>
                <InputLabel for="description" value="Description" />
                <textarea
                    id="description"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    v-model="form.description"
                    required
                    autofocus
                    autocomplete="description"
                    @input="emitFormValues"
                ></textarea>
                <InputError class="mt-2" :message="form.errors.description" />
            </div>
        </div>
    </section>
</template>


