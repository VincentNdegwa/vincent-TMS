<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
import AddForm from "./AddTaskComponents/addForm.vue"
import SideDisplay from "./AddTaskComponents/sideDisplay.vue"
import SweetAlerts from "../modules/SweetAlerts.vue"
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { handleError } from 'vue';
// import FormComponents from "./AddTaskComonents/Form.vue";
export default {
    props: {
        assigningTasks: Array,
        users: Array,
        auth: Object
    },
    data() {
        return {
            showSelect: false,
            form: {
                name: "",
                description: "",
                user_id: "",
                dueDate: "",
                priority: 0,
                unique_id: Date.now(),
                taskFile: "",
            },
            assigningTasksArray: [],
            addedTask: {}
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

        },
        getId(id) {
            if (Number.isInteger(+id)) {
                this.form.user_id = id
            }

        },
        async sendForm() {
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('unique_id', this.form.unique_id);
                formData.append('user_id', this.form.user_id);
                formData.append('priority', this.form.priority);
                formData.append('dueDate', this.form.dueDate);
                formData.append('description', this.form.description);
                formData.append('taskFile', this.form.taskFile);

                const response = await axios.post('/tasks/add', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });

                this.addedTask = response.data.task;

                this.showSelect = false;
                this.$refs.SweetAlerts.showNotification("Task created");
                console.log(this.addedTask)
                if (this.addedTask) {
                    this.assigningTasksArray.pop()
                    this.assigningTasksArray.unshift(this.addedTask);
                    console.log("added")
                }
            } catch (error) {
                this.$refs.SweetAlerts.showError();
                console.error(error)
            }
        },
        exitOverlay() {
            this.showSelect = false
        }
    },
    components: {
        HeaderHome,
        AddForm,
        SideDisplay,
        SweetAlerts
    }, mounted() {
        this.assigningTasks.forEach(element => {
            this.assigningTasksArray.push(element)
            console.log("mounted")
        });
    }

}
</script>


<template>
    <section class="dashboard">
        <SweetAlerts ref="SweetAlerts"></SweetAlerts>
        <HeaderHome :userName="auth.user.name" />
        <main>
            <div class="create-form-conatiner">
                <AddForm @sendingForm="handleSending" />
            </div>
            <div class="created-task-container">
                <SideDisplay :assigningTasks="assigningTasksArray" />
            </div>
            <div class="select-assingnee" v-if="showSelect">
                <button class="exit_button" @click="exitOverlay">Exit</button>
                <div class="select-holder">
                    <select name="" id="" @change="getId($event.target.value)" required>
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