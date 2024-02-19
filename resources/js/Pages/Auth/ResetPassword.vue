<script setup>

import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <section>

        <Head title="Reset Password" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <label for="email" value="Email" />
                <input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />
            </div>

            <div class="mt-4">
                <label for="password" value="Password" />
                <input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <label for="password_confirmation" value="Confirm Password" />
                <input id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset Password
                </button>
            </div>
        </form>
    </section>
</template>
