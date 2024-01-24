<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
import AddForm from "./AddTaskComponents/addForm.vue"
import SideDisplay from "./AddTaskComponents/sideDisplay.vue"
import { useForm } from '@inertiajs/vue3';
// import FormComponents from "./AddTaskComonents/Form.vue";
export default {
    props: ["auth", "assigningTasks", "users"],
    data() {
        return {
            showSelect: true,
            form: {
                name: "",
                description: "",
                user_id: "",
                dueDate: "",
                priority: 0,
                unique_id: Date.now(),
                taskFile: "",
            }
        }
    },
    methods: {
        handleSending(data) {
            this.showSelect = true
            let { name, description, dueDate, priority, unique_id, taskFile } = data
            this.form.name = name
            this.form.description = description
            this.form.dueDate = dueDate
            this.form.priority = priority
            this.form.unique_id = unique_id
            this.form.taskFile = taskFile
            console.log(this.form)
        },
        getId(id) {
            if (Number.isInteger(+id)) {
                this.form.user_id = id
            }

        },
        sendForm() {
            let formSend = useForm(
                this.form
            )
            formSend.post(route('addTask'), {
                onFinish: () => {
                    this.showSelect = false
                }
            })
        },
        exitOverlay() {
            this.showSelect = false
        }
    },
    components: {
        HeaderHome,
        AddForm,
        SideDisplay
    },
    created() {
        console.log(this.assigningTasks)
    }

}
</script>


<template>
    <section class="dashboard">
        <HeaderHome :userName="auth.user.name" />
        <main>
            <div class="create-form-conatiner">
                <AddForm @sendingForm="handleSending" />
            </div>
            <div class="created-task-container">
                <SideDisplay :assigningTasks="assigningTasks" />
            </div>
            <div class="select-assingnee" v-if="showSelect">
                <button class="exit_button" @click="exitOverlay">Exit</button>
                <div class="select-holder">
                    <select name="" id="" @change="getId($event.target.value)">
                        <option>select user to assign task</option>
                        <option v-for="(item, index) in users" :key="index" :value="item.id">
                            <p class="option-name">{{ item.name }}</p>, &nbsp;&nbsp; <p>{{ item.email }}</p>
                        </option>
                    </select>

                    <button @click="sendForm">Send Task</button>
                </div>

            </div>
        </main>
    </section>
</template>


<style>
@import url("../Styles/addTask.css");
</style>