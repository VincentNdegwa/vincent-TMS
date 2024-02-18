<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
import moment from 'moment';
import { useForm, router } from '@inertiajs/vue3';
import axios from 'axios';

export default {
    props: ['allTasks', 'userTask', 'auth'],

    components: {
        HeaderHome,
    },
    data() {
        return {
            id_task: null,
            allTasks: this.allTasks,
        }
    },
    methods: {
        convertTime(timestamp) {
            return moment(timestamp).fromNow()
        },
        popConversation(id) {
            console.log(id);
            router.visit("PlayGround/view/" + id)
        }
    }, mounted() {
        console.log(this.allTasks)
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
                            <p class="task-p"><span>Assigned by:</span> {{ item.assigner_name }}</p>
                            <p class="task-p"><span>Assigned to:</span> {{ item.assignee_name }}</p>
                        </div>
                        <p class="task-date-p">{{ convertTime(item.updated_at) }}</p>
                    </div>
                </article>

            </div>
            <div></div>
        </main>
    </section>
</template>
<style>
@import url("../Styles/playGround.css");
@import url("../Styles/dashboard.css");
@import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
</style>