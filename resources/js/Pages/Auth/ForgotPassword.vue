<script setup>

import { Head, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <section>
        <div class="form-container">
            <div class="logo-diplay">
                <p>Password Reset</p>
                <img src="../../../images/icon.jpg" alt="logo display">
            </div>
            <form action="" method="post" @submit.prevent="submit">

                <div class="mb-4 description-text">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password
                    reset
                    link that will allow you to choose a new one.

                </div>

                <div class="mb-3 input-holder">
                    <label for="exampleFormControlInput1" class="form-label">Email:</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com"
                        v-model="form.email">
                </div>

                <button type="submit" class="btn login-btn">Send Reset Link</button>
            </form>
            <div class="user-links">
                <a href="/login">Login instead?</a>
            </div>
        </div>
    </section>
</template>
<style>
@import url("../../Styles/form.css");

.description-text {
    text-align: center;
}
</style>
