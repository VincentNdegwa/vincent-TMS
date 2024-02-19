<script>
import PDFViewer from "pdf-viewer-vue"
import { useForm, router } from '@inertiajs/vue3';

export default {
    props: ["allTasks", "auth", "user"],
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
                let newMessageId = Date.now()
                this.newMessage = {
                    id: newMessageId,
                    task_id: this.TaskData.id,
                    text: this.form.text,
                    sender_id: this.userSender.id,
                    created_at: Date.now(),
                    sender: this.userSender
                };
                this.TaskMessages.push(this.newMessage)
                console.log(this.TaskMessages)
                axios.post('/tasks/comment', {
                    text: this.form.text,
                    task_id: this.form.task_id,
                    sender: this.form.sender,
                })
                    .then(response => {
                        this.form.text = '';
                        console.log(response.data)
                        let { text, task_id, sender_id, updated_at, created_at, id } = response.data.data;
                        let latestMessage = {
                            id: id,
                            task_id: task_id,
                            text: text,
                            sender_id: sender_id,
                            created_at: created_at,
                            updated_at: updated_at,
                            sender: this.userSender
                        };

                        let index = this.TaskMessages.findIndex(message => message.id === this.newMessage.id);
                        if (index != -1) {
                            console.log("found index: " + index)
                            this.TaskMessages.splice(index, 1, latestMessage);
                        }
                        console.log(this.TaskMessages)

                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                event.preventDefault();
            }
        }, changeFilePath(file) {
            let path = window.Laravel.appUrl + "storage/" + encodeURIComponent(file);
            console.log(path);
            return path;
        }, generateGoogleDocsViewerUrl(filePath) {
            return `https://docs.google.com/gview?url=${encodeURIComponent(filePath)}&embedded=true`;
        },

    }, created() {
        this.TaskData = this.allTasks[0]
        this.form.task_id = this.TaskData.id
        this.form.sender = this.auth
        this.TaskMessages = this.TaskData.task_comments
        this.userSender = this.user


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

                        <!-- <PDFViewer :source="changeFilePath(TaskData.response_file)" style="height: 45vh; width: 200px " /> -->
                        <iframe :src="changeFilePath(TaskData.response_file)" type="application/pdf" width="500px"
                            height="400px"></iframe>
                        <!-- <iframe :src="generateGoogleDocsViewerUrl(TaskData.response_file)" width="500px"
                            height="400px"></iframe> -->

                    </div>
                    Response File
                    <div class="pdf_viewer">
                        <iframe :src="changeFilePath(TaskData.taskFile)" type="application/pdf" width="500px"
                            height="400px"></iframe>
                    </div>

                </div>


            </div>
        </div>

        <div class="article_section_message">
            <div class="task_description_section">
                <span>Description: </span>
                <p>{{ TaskData.description }}</p>
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