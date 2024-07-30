
<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/vue3';
import {watch, defineEmits} from "vue";

defineProps<{
    users?: object;
}>();

const form = useForm({
    manager: '',
    team_members: '',
    logo: '',
    attachment: '',
    notes: ''
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

const handleFileChangeLogo = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.logo = target.files[0] as any; // Cast to `any` to avoid type error
        emitFormValues();
    }
};

const handleFileChangeAttachment = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.attachment = target.files[0] as any; // Cast to `any` to avoid type error
        emitFormValues();
    }
};

// Handle form submission


</script>


<template>
    <section >
        <header>
            <h2 class="text-lg font-medium text-gray-900">Final Details<small><span class="text-gray-700"> |  additional details regarding the project.</span></small></h2>

            <p class="mt-1 text-sm text-gray-600">
                Team members, notes and any additional documentation.
            </p>

        </header>


        <div class="mt-6 space-y-6 max-w-full" >

                <div>
                    <InputLabel for="project_manager" value="Project Manager" />
                    <select
                        id="project_manager"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.manager"
                        required
                        @input="emitFormValues"

                    >
                        <option v-for="user in users" :key="user['id']" :value="user['id']">
                            {{ user['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.manager" />
                </div>

                <div>
                    <InputLabel for="project_team" value="Project Team" />
                    <select
                        id="project_team"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.team_members"
                        required
                        multiple
                        @input="emitFormValues"
                    >
                        <option v-for="user in users" :key="user['id']" :value="user['id']">
                            {{ user['name'] }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.team_members" />
                </div>
            </div>
        <br>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <InputLabel for="logo" value="Project Logo" />
                <input
                    type="file"
                    id="logo"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    @input="emitFormValues"
                    @change="handleFileChangeLogo($event)"
                />
                <InputError class="mt-2" :message="form.errors.logo" />
            </div>
            <div>
                <InputLabel for="project_team" value="File attachment" />
                <input
                    type="file"
                    id="attachment"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    @input="emitFormValues"
                    @change="handleFileChangeAttachment($event)"
                />
                <InputError class="mt-2" :message="form.errors.attachment" />
            </div>
        </div>

        <br>


        <div>
            <InputLabel for="notes" value="Additional notes" />
            <textarea
                id="notes"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                v-model="form.notes"
                @input="emitFormValues"
            ></textarea>
            <InputError class="mt-2" :message="form.errors.notes" />
        </div>

    </section>
</template>





