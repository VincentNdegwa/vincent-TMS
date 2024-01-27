<script>
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import HeaderHome from "./HomeComponents/HeaderHome.vue";
import TaskDisplay from "./HomeComponents/TaskDisplay.vue"
import UserGroups from "./HomeComponents/UserGroups.vue";
import TaskList from "./HomeComponents/TaskLIst.vue"
import AddGroup from './HomeComponents/AddGroup.vue';


export default {
    props: ['tasks', 'auth', 'assigner', 'assigningTasks'],
    data() {
        return {
            limitData: [],
            allData: [],
            taskCountGiving: this.assigner,
            taskAssigningData: this.assigningTasks,
            addGroup: false
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
        AddGroup,
    },
    created() {
        this.limitData = this.tasks?.filter((item, index) => index < 5);
        this.allData = this.tasks
    }, methods: {
        openOverlay() {
            this.addGroup = true
        },
        closeOverlay() {
            this.addGroup = false;
        }
    }
}

</script>

<template>
    <!-- <Head title="Dashboard" /> -->
    <section class="dashboard">
        <HeaderHome :userName="userName" />
        <main class="main-container">
            <UserGroups :taskAssigningData="taskAssigningData" @openOverlay="openOverlay" />
            <div class="user-task-display">
                <div class="task-display">
                    <TaskDisplay :userTasks="allData" :taskCountGiving="taskCountGiving" />
                    <TaskList :userTasks="limitData" />
                </div>
            </div>
        </main>
        <AddGroup @closeOverlay="closeOverlay" :addGroup="addGroup" />
    </section>
</template>
<style>
@import url("../Styles/dashboard.css");
</style>