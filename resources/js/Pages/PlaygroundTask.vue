<script>
import PDFViewer from "pdf-viewer-vue"
import { useForm, router } from '@inertiajs/vue3';

export default {
    props: ["allTasks", "auth"],
    setup() {
        const form = useForm({
            task_id: null,
            receiver: null,
            sender: null,
            text: '',
        });
        return {
            form,
        };
    }, data() {
        return {
            TaskData: {},
        }
    },
    components: {
        PDFViewer,
    }, methods: {
        sendText(event) {
            if (this.form.text === '' || this.form.task_id === null || this.form.sender === null) {
                alert('Please fill in all required fields');
            } else {
                axios.post('/tasks/comment', {
                    text: this.form.text,
                    task_id: this.form.task_id,
                    sender: this.form.sender,
                    receiver: this.form.receiver,
                })
                    .then(response => {
                        this.form.text = '';
                        let newText = []
                        newText.push(response.data.data)
                        let newArray = this.selectedMessages.concat(newText)
                        this.selectedMessages = newArray;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                event.preventDefault();
            }
        }
    }, mounted() {
        this.TaskData = this.allTasks[0]
        console.log(this.TaskData)
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
                        <PDFViewer :source="TaskData.response_file" style="height: 30vh; width: 200px " />
                    </div>
                    Response File
                    <div class="pdf_viewer">
                        <PDFViewer :source="TaskData.taskFile" style="height: 30vh; width: 200px " />
                    </div>

                    <!-- <div class="like-diplay">
                                <p> {{ selectedData.likes }} </p>
                                <i class='bx bxs-like'></i>
                            </div> -->
                </div>


            </div>
        </div>

        <div class="article_section_message">
            <div class="header">
                <p>{{ TaskData.name }} </p>
                <span>{{ TaskData.email }}</span>
            </div>
            <div class="message-conversation-display">

                <!-- <div class="message-box" v-for="(item, index) in   selectedMessages  " :key="index"
                    :class="{ 'message-box-owner ': item.sender_id === auth }">
                    <p>{{ item.text }} </p>
                </div> -->

            </div>
            <form action="" class="reply-box" @keydown.enter="sendText">

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