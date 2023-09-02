<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
import moment from 'moment';
import { useForm, router } from '@inertiajs/vue3';
import axios from 'axios';

export default {
    props: ['allTasks', 'userTask', 'conversation', 'auth'],
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
    },
    components: {
        HeaderHome
    },
    data() {
        return {
            id_task: null,
            allTasks: this.allTasks,
            selectedData: null,
            messages: this.conversation,
            selectedMessages: [],
        }
    },
    methods: {
        convertTime(timestamp) {
            return moment(timestamp).fromNow()
        },
        popConversation(id) {
            this.id_task = id
            location.reload
            this.selectedData = this.allTasks.find((item) => item.id === id)
            this.selectedMessages = this.conversation.filter((item) => item.task_id === id)
            this.form.task_id = this.selectedData.id;
            this.form.receiver = this.selectedData.assigner;
            this.form.sender = this.auth;

            // console.log(this.selectedMessages);

            localStorage.setItem('selectedData', JSON.stringify(this.selectedData));
            localStorage.setItem('selectedMessages', JSON.stringify(this.selectedMessages));
        },
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
        },
    },
    created() {
        const selectedData = localStorage.getItem('selectedData');
        const selectedMessages = localStorage.getItem('selectedMessages');
        // const selectedId = localStorage.getItem('stored_id')

        if (selectedData) {
            this.selectedData = JSON.parse(selectedData);
        }

        if (selectedMessages) {
            this.selectedMessages = JSON.parse(selectedMessages);
        }
    },
    watch: {
        selectedMessages(newMessage, oldMessage) {
            this.selectedMessages = newMessage
        }
    }

}
</script>




<template>
    <section class="dashboard">
        <HeaderHome :userName="userName" />
        <main class="main-container playGround-container">
            <div class="task-to-comment">
                <nav class="task-nav">
                    <p>
                        Task Display
                    </p>
                    <form action="">
                        <select name="" id="">
                            <option value=""></option>
                        </select>
                    </form>
                </nav>

                <article class="article-tasks">
                    <div class="article-task-item" v-for="(item, index) in allTasks" :key="index"
                        @click="popConversation(item.id)">
                        <div>
                            <h1 class="task-h1">{{ item.name }}</h1>
                            <p class="task-p">{{ item.email }}</p>
                        </div>
                        <p class="task-date-p">{{ convertTime(item.created_at) }}</p>
                    </div>
                </article>


            </div>
            <article class="article-messages" v-if="id_task">
                <div class=" header">
                    <p>{{ selectedData.name }} </p>
                    <span>{{ selectedData.email }}</span>
                </div>
                <div class="header-conv">
                    <div class="files-display">
                        <a href="">
                            <button>Assignement File</button>
                        </a>
                        <a href="">
                            <button>Response File</button>
                        </a>

                    </div>

                    <div class="like-diplay">
                        <p> {{ selectedData.likes }} </p>
                        <i class='bx bxs-like'></i>
                    </div>

                </div>
                <div class="message-conversation-display">

                    <div class="message-box" v-for="(item, index) in   selectedMessages  " :key="index"
                        :class="{ 'message-box-owner ': item.sender_id === auth }">
                        <p>{{ item.text }} </p>
                    </div>

                </div>
                <form action="" class="reply-box" @keydown.enter="sendText">

                    <div class="text-input-holder">
                        <input type="text" id="text-reply" v-model="form.text" placeholder="Enter message">
                        <label for="text-reply" @click="sendText">
                            <i class='bx bx-paper-plane'></i>
                        </label>
                    </div>
                </form>
            </article>
            <div></div>
        </main>
    </section>
</template>
<style>
@import url("../Styles/playGround.css");
@import url("../Styles/dashboard.css");
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
</style>