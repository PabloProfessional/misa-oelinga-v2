<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const props = defineProps({
    admin_user: {
        type: Object
    }
});

const form = useForm({
    password: '',
    id: '',
});

if (props.admin_user) {
    form.id = props.admin_user.id;
}

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    if(!props.admin_user) {
        form.delete(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.value.focus(),
            onFinish: () => form.reset(),
        });
    }
    form.post(route('admin_user_reactive'));
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Reactivate {{ props.admin_user.name }}'s Account</h2>

            <p class="mt-1 text-sm text-gray-600">
                Once the account is reactivated, the user's access will be restored to the platform. You may deactivate the account within the
                user admin page.
            </p>
        </header>

        <PrimaryButton @click="confirmUserDeletion">Reactivate {{ props.admin_user.name }}'s Account</PrimaryButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to Reactivate {{ props.admin_user.name }}'s account?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once the account is reactivated, the user's access will be restored to the platform. You may deactivate the account within the
                    user admin page.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Reactivate {{ props.admin_user.name }}'s Account
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
