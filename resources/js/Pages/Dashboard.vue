<script>
import HeaderHome from "./HomeComponents/HeaderHome.vue";
import TaskDisplay from "./HomeComponents/TaskDisplay.vue"
import UserGroups from "./HomeComponents/UserGroups.vue";
import TaskList from "./HomeComponents/TaskLIst.vue"
import AddGroup from './HomeComponents/AddGroup.vue';

import Pusher from "pusher-js"
export default {
    mounted() {
        // Pusher.logToConsole = true;

        // var pusher = new Pusher('5d03bc74ebd65c06a7d0', {
        //     cluster: 'mt1'
        // });

        // var channel = pusher.subscribe('my-channel');
        // channel.bind('my-event', function (data) {
        //     alert(JSON.stringify(data));
        // });
    },
    props: ['tasks', 'auth', 'assigner', 'assigningTasks', 'groups'],
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
        }, latestGroup(group) {
            this.groups.push(group)
        }
    }
}

</script>

<template>
    <!-- <Head title="Dashboard" /> -->
    <section class="dashboard">
        <HeaderHome :userName="userName" />
        <main class="main-container">
            <UserGroups :taskAssigningData="taskAssigningData" :groups="groups" @openOverlay="openOverlay" />
            <div class="user-task-display">
                <div class="task-display">
                    <TaskDisplay :userTasks="allData" :taskCountGiving="taskCountGiving" />
                    <TaskList :userTasks="limitData" />
                </div>
            </div>
        </main>
        <AddGroup @closeOverlay="closeOverlay" @latestGroup="latestGroup" :addGroup="addGroup" />
    </section>
</template>
<style>
@import url("../Styles/dashboard.css");
</style>