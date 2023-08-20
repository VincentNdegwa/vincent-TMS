<script>
import { useForm } from '@inertiajs/inertia-vue3';
import HeaderHome from './HomeComponents/HeaderHome.vue';
import LeftViewTask from './ViewTasksComponents/leftViewTask.vue'
import RightViewTask from "./ViewTasksComponents/rightViewTask.vue"
import { router } from '@inertiajs/vue3';
import { watch, ref, reactive, computed } from 'vue';

export default {
    props: ["auth", "tasks", "taskAssigning", "taskSorted"],

    components: {
        HeaderHome,
        LeftViewTask,
        RightViewTask
    },
    data() {
        return {
            display: false,
            taskData: this.tasks,
            taskid: "",
        }
    },
    methods: {
        displayTask(id) {
            this.display = true
            this.taskid = id
            this.taskData = this.tasks.find((task) => task.id === id)
            this.form = useForm({
                task_reply: "",
                id: id,
                date_submit: Date.now(),
                response_file: "",
            })
        },
        exitView() {
            this.display = false
        },
        submiTask() {
            this.$inertia.post("/tasks/update", this.form, {
                onFinish: () => {
                }
            });
            this.exitView()

        },
        updateFilter(data) {
            router.get(`/tasks/?sort=${data.filter}`)
        },
        handleFileResponse(ev) {
            this.form.response_file = ev.target.files[0];
        }
    },
    setup(props) {
        const reactiveProps = reactive(props);
        const taskData = ref(null);
        const form = useForm({
            task_reply: "",
            id: "",
            date_submit: Date.now(),
            response_file: "",
        });
        watch(() => reactiveProps.tasks, (newTasks) => {
            if (newTasks) {
                taskData.value = newTasks
            }
        });
        return {
            taskData,
            form,
        };
    },

}
</script>

<template>
    <section class="dashboard">
        <HeaderHome :userName="auth.user.name" />
        <main class="view-task-display">
            <LeftViewTask :tasks="tasks" @customChange="displayTask" @filter="updateFilter" />
            <RightViewTask :taskAssigning="taskAssigning" />
            <div class="display-task" v-if="display">
                <div class="see-tasks">
                    <div class="header-with-cancel">
                        <p @click="exitView"><i class='bx bx-exit'>exit</i></p>
                    </div>
                    <div class="see-task-main">
                        <div class="task-read">
                            <h3>{{ taskData.name }} </h3>
                            <h2>{{ taskData.description }}</h2>
                            <form @submit.prevent="submiTask" class="task-reply">
                                <textarea class="form-control reply-textarea" v-model="form.task_reply"></textarea>
                                <input type="file" name="response_file" id="" @input="handleFileResponse">
                                <button type="submit">Submit</button>
                            </form>
                        </div>
                        <div class="files-display">
                            <p>Task File</p>
                            <object :data="`storage/${taskData.taskFile}`"></object>
                            <a :href="`storage/${taskData.taskFile}`" target="_blank" class="file-preview-btn">Preview
                                File</a>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </section>
</template>
<style>
@import url("../Styles/viewTask.css");
@import url("https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css");
</style>