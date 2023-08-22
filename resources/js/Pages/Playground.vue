<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
import moment from 'moment'
export default {
    props: ['allTasks', 'userTask'],
    components: {
        HeaderHome
    },
    data() {
        return {
            allTasks: this.allTasks
        }
    },
    methods: {
        convertTime(timestamp) {
            return moment(timestamp).fromNow()
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
                    <div class="article-task-item" v-for="(item, index) in allTasks" :key="index">
                        <div>
                            <h1 class="task-h1">{{ item.name }}</h1>
                            <p class="task-p">{{ item.assigner_name }}</p>
                        </div>
                        <p class="task-date-p">{{ convertTime(item.created_at) }}</p>
                        <!-- <span>
                            <p>Task receiver</p>
                            <p>Date submited</p>
                        </span> -->
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
</style>