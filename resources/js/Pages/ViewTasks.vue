<script>
import { useForm } from '@inertiajs/inertia-vue3';
import HeaderHome from './HomeComponents/HeaderHome.vue';
import LeftViewTask from './ViewTasksComponents/leftViewTask.vue'
import RightViewTask from "./ViewTasksComponents/rightViewTask.vue"
import { router } from '@inertiajs/vue3';
import { watch, ref, reactive,computed } from 'vue';

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
            form: "",
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
            })
        },
        exitView() {
            this.display = false
        },
        submiTask() {
            router.put("/tasks/update", this.form, {
                onFinish: () => {
                    this.display = false
                }
            })
        },
        updateFilter(data) {
            router.get(`/tasks/?sort=${data.filter}`)
        }
    },
    setup(props) {
        const reactiveProps = reactive(props);
        const taskData = ref(null);
        const form = useForm({
            task_reply: "",
            id: "",
            date_submit: Date.now(),
            // fileUrl:'/storage/' + this.taskData.taskFile 
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
                            <h1>{{ taskData.name }} </h1>
                            <h3>{{ taskData.description }}</h3>
                        </div>
                        <div class="files-display">
                              <a :href="taskData.taskFile" target="_blank">View File</a>         
                        </div>
                        <div class="task-reply">
                            <textarea class="form-control reply-textarea" v-model="form.task_reply"></textarea>
                            <input type="file" name="" id="">
                            <button @click="submiTask">Submit</button>
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