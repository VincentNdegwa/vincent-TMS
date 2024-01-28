<script>
// import { useForm } from '@inertiajs/inertia-vue3';
import { useForm } from "@inertiajs/vue3";
import ValidationErrorsVue from "@/Components/ValidationErrors.vue";
export default {
    setup() {
        const form = useForm({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            terms: false,
        })
        const submit = () => {
            form.post(route("register"), {
                onFinish: () => form.reset('password', 'password_confirmation'),
            });
        };
        return {
            form,
            submit,
        }
    },
    components: {
        ValidationErrorsVue,
    }
}
</script>

<template>
    <section>
        <div class="form-container">
            <div class="logo-diplay">
                <p>Register To TMS</p>
                <img src="../../../images/icon.jpg" alt="logo display">
            </div>
            <ValidationErrorsVue class="mb-4" />
            <form action="" method="post" @submit.prevent="submit">
                <div class="mb-3 input-holder">
                    <label for="exampleFormControlInput1" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" v-model="form.name">
                </div>
                <div class="mb-3 input-holder">
                    <label for="exampleFormControlInput1" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" v-model="form.email">
                </div>
                <div class="mb-3 input-holder">
                    <label for="exampleFormControlInput1" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="exampleFormControlInput1" v-model="form.password">
                </div>
                <div class="mb-3 input-holder">
                    <label for="exampleFormControlInput1" class="form-label">Confirm password:</label>
                    <input type="password" class="form-control" id="exampleFormControlInput1"
                        v-model="form.password_confirmation">
                </div>
                <button type="submit" class="btn login-btn">Register</button>
                <div class="user-links">
                    <a :href="(route('login'))">
                        You have an account?
                    </a>
                </div>
            </form>
        </div>
    </section>
</template>
<style>
@import url("../../Styles/form.css");
</style>
