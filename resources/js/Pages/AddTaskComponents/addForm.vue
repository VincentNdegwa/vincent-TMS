<script>
import { router } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'

export default {
    props: [],
    setup(props) {
        const form = useForm({
            name: "",
            description: "",
            user_id: 3,
            dueDate: "",
            priority: 0,
            unique_id:Date.now(),
        });
        return {form}
    },
    data() {
        return {
            dueDate: "",
            taskFileUrl: "",
            priority: 0,
        }
    },
    methods: {
        sendForm() {
            this.$emit('sendingForm', this.form)
            this.form.name = ""
            this.form.description = ""
            this.form.user_id = ""
            this.form.dueDate = ""
            // this.form.post("/tasks/add", {
            //     preserveScroll: true,
            //     onFinish: () => {
            //         this.form.name=""
            //         this.form.description= ""
            //         this.form.user_id=""
            //         this.form.dueDate= ""
            //     }
            // });
        },
    }
}
</script>


<template>
    <form  @submit.prevent="sendForm">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Task name</label>
            <input type="text" v-model="form.name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="form-floating">
            <label for="exampleInputEmail1" class="form-label">Task description</label>
            <textarea class="form-control" v-model="form.description" placeholder="Leave a description here"
                id="floatingTextarea2" style="height: 100%"></textarea>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Due date</label>
            <input type="date" class="form-control" v-model="form.dueDate">
        </div>
        <div class="mb-3">
            <label for="">Task Priority</label>
            <select class="form-select" v-model="form.priority">
                <option class="option sected" value="0">0</option>
                <option class="option" value="1">1</option>
                <option class="option" value="2">2</option>
                <option class="option" value="3">3</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Task file</label>
            <input class="form-control form-control-sm" id="formFileSm" type="file">
        </div>
        <button type="submit" class="btn btn-primary submit-btn">Create</button>
    </form>
</template>
