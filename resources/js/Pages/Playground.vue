<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
import moment from 'moment'
import { useForm } from '@inertiajs/vue3';
export default {
    props: ['allTasks', 'userTask', 'conversation'],
    setup() {
        const formData = JSON.parse(localStorage.getItem('selected'));
        const form = useForm({
            task_id: formData.id,
            receiver: formData.assigner,
            sender: formData.assignee,
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
            allTasks: this.allTasks,
            selectedData: JSON.parse(localStorage.getItem('selected'))
        }
    },
    methods: {
        convertTime(timestamp) {
            return moment(timestamp).fromNow()
        }
        , popConversation(id) {
            localStorage.setItem('selected', JSON.stringify(this.allTasks.find((item) => item.id === id)))
            this.selectedData = JSON.parse(localStorage.getItem('selected'));
            this.form.task_id = this.selectedData.id;
            this.form.receiver = this.selectedData.assigner;
            this.form.sender = this.selectedData.assignee;
            console.log(this.selectedData)
        },
        sendText() {
            if (this.form.text == '' && this.form.task_id == null && this.form.sender == null) {
                alert('Please click the Task')
            } else {

                this.form.post('/tasks/comment', {
                    onFinish: () => {
                        this.form.text = ''
                    }
                })
            }
        }

    },
    created() {
        // console.log(this.allTasks)
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
                        <!-- <span>
                            <p>Task receiver</p>
                            <p>Date submited</p>
                        </span> -->
                    </div>
                </article>


            </div>
            <article class="article-messages" v-if="selectedData">
                <div class="header">
                    <p>{{ selectedData.name }} </p>
                    <span>{{ selectedData.email }}</span>
                </div>
                <div class="files-display">
                    <a href="">
                        <button>Assignement File</button>
                    </a>
                    <a href="">
                        <button>Response File</button>
                    </a>
                </div>
                <div class="message-conversation-display">
                    <div class="message-box">
                        <p>{{ conversation }} </p>
                    </div>
                    <div class="message-box">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto officia cum delectus tenetur, sit
                            magni sapiente saepe ea nesciunt molestias accusamus ratione facilis laborum, incidunt vero
                            consectetur autem. Molestiae, nemo? </p>
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