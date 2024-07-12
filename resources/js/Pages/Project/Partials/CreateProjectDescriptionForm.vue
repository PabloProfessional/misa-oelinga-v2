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
    name: user['name'],
    email: user.email,
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
            <h2 class="text-lg font-medium text-gray-900">Project <small><span class="text-gray-700">| Description</span></small></h2>

            <p class="mt-1 text-sm text-gray-600">
                Add some initial details of your project.
            </p>

        </header>


        <div class="mt-6 space-y-6 max-w-full" >
            <div >
                <InputLabel for="project-name" value="Project name" />

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
               <div class="grid grid-cols-2 gap-4">
                   <div>
                       <InputLabel for="unique-number" value="Project unique number" />

                       <TextInput
                           id="unique-number"
                           type="text"
                           class="mt-1 block w-full"
                           v-model="form.project_number"
                           required
                           @input="emitFormValues"
                       />

                       <InputError class="mt-2" :message="form.errors.project_number" />
                   </div>

                   <div>
                       <InputLabel for="programme" value="Programme" />
                       <select
                           id="programme"
                           class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                           v-model="form.programme"
                           required
                           autofocus
                           @input="emitFormValues"
                       >
                           <option disabled value="">Select a programme</option>
                           <option v-for="programme in programmes" :key="programme['id']" :value="programme['id']">
                               {{ programme['name'] }}
                           </option>
                       </select>
                       <InputError class="mt-2" :message="form.errors.programme" />
                   </div>
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

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <InputLabel for="province" value="Province" />
                    <select
                        id="province"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.province"
                        required
                        autofocus
                        @change="fetchMunicipalities"
                        @input="emitFormValues"
                    >
                        <option disabled value="">Select a province</option>
                        <option v-for="province in provinces" :key="province['id']" :value="province['id']">
                            {{ province['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.province" />
                </div>

                <div>
                    <InputLabel for="municipality" value="Municipality" />
                    <select
                        id="province"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.municipality"
                        required
                        @input="emitFormValues"
                    >
                        <option disabled value="">Select a municipality</option>
                        <option v-for="municipality in municipalities" :key="municipality['id']" :value="municipality['id']">
                            {{ municipality['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.municipality" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <InputLabel for="department" value="Department" />
                    <select
                        id="department"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.department"
                        required
                        @input="emitFormValues"
                    >
                        <option disabled value="">Select a department</option>
                        <option v-for="department in departments" :key="department['id']" :value="department['id']">
                            {{ department['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.department" />
                </div>
                <div>
                    <InputLabel for="sector" value="Sector" />
                    <select
                        id="sector"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.sector"
                        required
                        @input="emitFormValues"
                    >
                        <option disabled value="">Select a sector</option>
                        <option v-for="sector in sectors" :key="sector['id']" :value="sector['id']">
                            {{ sector['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.department" />
                </div>
            </div>

        </div>
    </section>
</template>


