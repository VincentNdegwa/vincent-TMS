<script>
import AssigningTaskLIst from './AssigningTaskLIst.vue';

export default {
    props: ['taskAssigningData', 'groups'],
    tasksAssigning: Array,
    data() {
        return {
        }
    },
    components: {
        AssigningTaskLIst,
    },
    methods: {
        displayData() {
            this.tasksAssigning = JSON.parse(JSON.stringify(this.taskAssigningData))
        },
        openOverlay() {
            this.$emit("openOverlay")
        }
    },
    created() {
        this.displayData()
    }
}
</script>


<template>
    <div class="left-main">
        <div class="user-groups">
            <div class="groups-holder">
                <div class="group-header">
                    <p>Groups</p>
                    <div @click="openOverlay"><i class='bx bx-plus'></i></div>
                </div>
                <div class="groups-items">
                    <div class="group-item" v-for="(item, index) in groups" :key="index" v-if="groups.length > 0">
                        {{ item.group_name }}
                    </div>
                    <div v-else class="no_groups">
                        You are not in any group yet! Click on the "+" button to add yourself into a new one.
                    </div>
                </div>
            </div>
        </div>
        <AssigningTaskLIst :tasksAssigning="tasksAssigning" />
    </div>
</template>
<style>
.groups-items {
    position: relative;
}

.no_groups {
    position: absolute;
    left: 50%;
    right: 50%;
    transform: translate(-50%, -50%);
    color: var(--white);
    width: 100%;
    text-align: center;
    font-size: 1.3rem;
    margin-top: 4rem;

}
</style>
