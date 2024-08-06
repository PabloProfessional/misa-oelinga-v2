<script setup lang="ts">
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import {nextTick, ref, watch} from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    spend: '',
    percentage_completion: '',
    password: '',
    attatchment: '',
    notes:''
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};

function formatNumber(n: string) {
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatCurrency(event: any) {
    let input_val = event.target.value;

    if (input_val === "") return;

    let original_len = input_val.length;
    let caret_pos = event.target.selectionStart;

    if (input_val.indexOf(".") >= 0) {
        let decimal_pos = input_val.indexOf(".");
        let left_side = input_val.substring(0, decimal_pos);
        let right_side = input_val.substring(decimal_pos);

        left_side = formatNumber(left_side);
        right_side = formatNumber(right_side);

        right_side = right_side.substring(0, 2);
        input_val = "R " + left_side + "." + right_side;
    } else {
        input_val = formatNumber(input_val);
        input_val = "R " + input_val;
    }

    event.target.value = input_val;
    form.spend = input_val;

    let updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    event.target.setSelectionRange(caret_pos, caret_pos);
}

function formatPercentageCompletion(value: string) {
    value = value.replace(/\D/g, '');
    value = Math.min(Math.max(parseInt(value, 10), 0), 100).toString();
    return value + '%';
}

function handleInput(event: any) {
    if (event.target.id === 'project-spend') {
        formatCurrency(event);
    } else if (event.target.id === 'percentage_completion') {
        form.percentage_completion = formatPercentageCompletion(event.target.value);
    }
}

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

const handleFileChangeAttachment = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        form.attatchment = target.files[0] as any; // Cast to `any` to avoid type error
        emitFormValues();
    }
};

</script>



<template>
    <section class="space-y-6">
        <PrimaryButton @click="confirmUserDeletion">Update activity progress</PrimaryButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Update the progress of this activity
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once the activity is updated, all of project progress and data will be permanently updated as well. Please
                    ensure that all relevant documentation is attached.
                </p>

                <div class="mt-6">
                    <div>
                        <InputLabel for="project-spend" value="Spend i.e. additional monies spent at the time of filling this form" />

                        <TextInput
                            id="project-spend"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.spend"
                            required
                            autocomplete="spend"
                            @input="handleInput"
                        />

                        <InputError class="mt-2" :message="form.errors.spend" />
                    </div>
                    <br>
                    <div>
                        <InputLabel for="percentage_completion" value="Percentage completion | 0 to 100" />

                        <TextInput
                            id="percentage_completion"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.percentage_completion"
                            required
                            autocomplete="percentage_completion"
                            @input="handleInput"
                            min="0"
                            max="100"
                        />

                        <InputError class="mt-2" :message="form.errors.percentage_completion" />
                    </div>
                    <br>
                    <div>
                        <InputLabel for="project_team" value="File attachment" />
                        <input
                            type="file"
                            id="attachment"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            @input="emitFormValues"
                            @change="handleFileChangeAttachment($event)"
                        />
                        <InputError class="mt-2" :message="form.errors.attatchment" />
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
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Save progress
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

