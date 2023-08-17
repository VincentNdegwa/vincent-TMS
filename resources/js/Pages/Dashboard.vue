<script>
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import HeaderHome from "./HomeComponents/HeaderHome.vue";
import TaskDisplay from "./HomeComponents/TaskDisplay.vue"
import UserGroups from "./HomeComponents/UserGroups.vue";
import TaskList from "./HomeComponents/TaskLIst.vue"


export default {
    props: ['tasks', 'auth','assigner','assigningTasks'],
    data() {
        return {
            limitData: [],
            allData: [],
            taskCountGiving: this.assigner,
            taskAssigningData: this.assigningTasks
        }
    },
    computed: {
        userName() {
            return this.auth?.user?.name || '---';
        }
    },
    components: {
        BreezeDropdownLink,
        HeaderHome,
        UserGroups,
        TaskDisplay,
        TaskList,
    },
    created() {
        this.limitData = this.tasks?.filter((item, index) => index < 5);
        this.allData = this.tasks
    }
}

</script>

<template>
    <!-- <Head title="Dashboard" /> -->
    <section class="dashboard">
        <HeaderHome :userName="userName" />
        <main class="main-container">
            <UserGroups :taskAssigningData="taskAssigningData"/>
            <div class="user-task-display">
                <div class="task-display">
                    <TaskDisplay :userTasks="allData" :taskCountGiving="taskCountGiving"/>
                    <TaskList :userTasks="limitData" />
                </div>
            </div>
        </main>
    </section>
</template>
<style>
@import url("../Styles/dashboard.css");
</style>