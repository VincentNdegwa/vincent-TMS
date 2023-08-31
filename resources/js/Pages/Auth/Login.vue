<template>
    <section>
        <div class="form-container">
            <div class="logo-diplay">
                <p>Login To TMS</p>
                <img src="../../../images/icon.jpg" alt="logo display">
            </div>
            <ValidationErrorsVue class="mb-4" />
            <form action="" method="post" @submit.prevent="submit">

                <div class="mb-3 input-holder">
                    <label for="exampleFormControlInput1" class="form-label">Email:</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com"
                        v-model="form.email">
                </div>

                <div class="mb-3 input-holder">
                    <label for="exampleFormControlInput2" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="exampleFormControlInput2" v-model="form.password">
                </div>

                <button type="submit" class="btn btn-primary login-btn">Login</button>
            </form>
            <div class="user-links">
                <a :href="(route('password.request'))">
                    Forgot password?
                </a> &nbsp; <br>
                <a :href="(route('register'))">
                    You don't have an account?
                </a>
            </div>
        </div>
    </section>
</template>

<script>
// import { useForm, Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/vue3"
import ValidationErrorsVue from "@/Components/ValidationErrors.vue";

export default {
    setup() {

        const form = useForm({
            email: "",
            password: "",
            remember: false,
        });

        const submit = () => {
            form.post(route("login"), {
                onFinish: () => form.reset("password"),
            });
        };

        return {
            form,
            submit,
        };
    },
    components: {
        ValidationErrorsVue
    }
};
</script>


<style>
@import url("../../Styles/form.css");
</style>