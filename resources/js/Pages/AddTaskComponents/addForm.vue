<script>
import { router } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import SweetAlerts from '@/modules/SweetAlerts.vue';

export default {
    props: [],
    setup(props) {
        const form = useForm({
            name: "",
            description: "",
            user_id: 3,
            dueDate: "",
            priority: 0,
            unique_id: Date.now(),
            taskFile: "",
        });
        return { form }
    },
    components: {
        SweetAlerts
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
        },
        filechange(event) {

            const fileInput = event.target;
            const fileName = fileInput.value.split('\\').pop();
            const fileExtension = fileName.split('.').pop().toLowerCase();

            if (fileExtension === 'docx' || fileExtension === 'pptx' || fileExtension === 'xlsx') {
                this.$refs.SweetAlerts.ShowAlert('Sorry, .docx, .pptx, .xlsx files are not allowed at the moments. Please choose a different file.');
                fileInput.value = '';
            }
            else {

                this.form.taskFile = event.target.files[0];
            }
        }
    }
}
</script>


<template>
    <form @submit.prevent="sendForm" class="form">
        <SweetAlerts ref="SweetAlerts"></SweetAlerts>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Task name</label>
            <input type="text" v-model="form.name" class="form-control task_name_input" id="exampleInputEmail1"
                aria-describedby="emailHelp" required>
        </div>
        <div class="form-floating">
            <label for="exampleInputEmail1" class="form-label">Task description</label>
            <textarea class="form-control" v-model="form.description" placeholder="Leave a description here"
                id="floatingTextarea2" style="height: 100%" required></textarea>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Due date</label>
            <input type="date" class="form-control" v-model="form.dueDate" required>
        </div>
        <div class="mb-3">
            <label for="">Task Priority</label>
            <select class="form-select" v-model="form.priority" required>
                <option class="option sected" value="0">0</option>
                <option class="option" value="1">1</option>
                <option class="option" value="2">2</option>
                <option class="option" value="3">3</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Task file</label>
            <input required class="form-control form-control-sm" id="formFileSm" type="file" @change="filechange">
        </div>
        <button type="submit" class="btn btn-primary submit-btn">Create</button>
    </form>
</template>
