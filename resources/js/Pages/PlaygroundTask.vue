<script>
import PDFViewer from "pdf-viewer-vue"
import { useForm, router } from '@inertiajs/vue3';

export default {
    props: ["allTasks", "auth"],
    setup() {
        const form = useForm({
            task_id: null,
            sender: null,
            text: '',
        });
        return {
            form,
        };
    }, data() {
        return {
            TaskData: {},
            TaskMessages: [],
            userSender: {},
            newMessage: {
                "id": "",
                "task_id": "",
                "text": "",
                "sender_id": "",
                "created_at": "",
                "updated_at": "",
                "sender": ""
            }
        }
    },
    components: {
        PDFViewer,
    }, methods: {
        sendText(event) {
            if (this.form.text === '' || this.form.task_id === null || this.form.sender === null) {
                alert('Please fill in all required fields');
            } else {
                this.newMessage = {
                    id: this.TaskData.id,
                    task_id: this.TaskData.task_id,
                    text: this.form.text,
                    sender_id: this.userSender.id,
                    created_at: Date.now(),
                    sender: this.userSender
                };
                this.TaskMessages.push(this.newMessage)
                console.log(this.TaskMessages)
                // axios.post('/tasks/comment', {
                //     text: this.form.text,
                //     task_id: this.form.task_id,
                //     sender: this.form.sender,
                // })
                //     .then(response => {
                //         this.form.text = '';

                //     })
                //     .catch(error => {
                //         console.error('Error:', error);
                //     });
                event.preventDefault();
            }
        }, changeFilePath(file) {
            let path = "../../../storage/" + file
            console.log(path)
            return path
        }
    }, mounted() {
        this.TaskData = this.allTasks[0]
        this.form.task_id = this.TaskData.id
        this.form.sender = this.auth
        this.TaskMessages = this.TaskData.task_comments
        this.userSender = this.TaskMessages?.find(item => item.sender.id === this.auth)?.sender

        console.log(this.TaskMessages)
    }
}
</script>
<template>
    <article class="article-messages">
        <div class="article_section_pdf">
            <div class="header-conv">
                <div class="files-display">
                    Task File
                    <div class="pdf_viewer">
                        <PDFViewer :source="changeFilePath(TaskData.response_file)" style="height: 45vh; width: 200px " />
                    </div>
                    Response File
                    <div class="pdf_viewer">
                        <PDFViewer :source="changeFilePath(TaskData.taskFile)" style="height: 45vh; width: 200px " />
                    </div>

                </div>


            </div>
        </div>

        <div class="article_section_message">
            <div class="task_description_section">
                <span>Description: </span>
                <p>{{ TaskData.description }} Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestias labore
                    accusantium rerum deserunt ab veniam totam numquam tempore corrupti, dignissimos, aliquid culpa dicta,
                    fugiat quia fuga! Esse consequuntur fugiat laboriosam.</p>
            </div>
            <div class="header">
                <p>{{ TaskData.name }} </p>
                <span>{{ TaskData.email }}</span>
            </div>

            <div class="message-conversation-display">

                <div class="message-box" v-for="(item, index) in  TaskMessages " :key="index"
                    :class="{ 'message-box-owner ': item.sender_id === auth }">
                    <p>{{ item.text }} </p>
                </div>

            </div>
            <form action="" class="reply-box" @keydown.enter="sendText">
                <span>
                    <small>{{ TaskData.likes }}</small>
                    <i class='bx bx-like'></i>
                </span>
                <div class="text-input-holder">
                    <input type="text" id="text-reply" v-model="form.text" placeholder="Enter message">
                    <label for="text-reply" @click="sendText">
                        <i class='bx bx-paper-plane'></i>
                    </label>
                </div>
            </form>

        </div>
    </article>
</template>

<style>
@import url("../Styles/playGround.css");
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
</style>