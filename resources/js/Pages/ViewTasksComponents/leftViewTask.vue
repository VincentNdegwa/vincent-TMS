<script>
import { router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
export default {
    props: ['tasks', 'taskSorted'],
    data() {
        return {
            taskData: this.tasks,
        }
    },
    setup() {
        const form = useForm({
            filter: ""
        })
        return {
            form
        }
    },
    methods: {
        handleChange(id) {
            this.$emit("customChange", id)
        },
        sendFilter() {
            this.$emit('filter', this.form)
        }
    }
}
</script>

<template>
    <div class="left-task-display">
        <div class="tasks-container">
            <div class="task-holder-display">
                <div class="tasks-header">
                    <h3>Tasks assinged</h3>
                    <select v-model="form.filter" @change="sendFilter">
                        <option value="all" selected>all</option>
                        <option value="dueDate">due date</option>
                        <option value="latest">latest</option>
                        <option value="name">name</option>
                        <option value="priority">priority</option>

                        <!-- <option value="">filter</option> -->
                    </select>

                </div>
                <div class="tasks-body" v-if="tasks.length > 0">
                    <div class="task-item-display" v-for="(item, index) in taskData" :key="index"
                        @click="() => handleChange(item.id)">
                        <h2>{{ item.name }}</h2>
                        <h2>{{ item.priority }}</h2>
                        <h2>{{ item.completed ? "completed" : "incomplete" }}</h2>
                        <h2>{{ item.due_date ? new Date(item.due_date).toLocaleDateString() : "no due date" }}</h2>
                    </div>

                </div>
                <div class="tasks-body" v-else>
                    You have no task
                </div>
            </div>

        </div>
    </div>
</template>
