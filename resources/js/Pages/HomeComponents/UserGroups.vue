<script>
import AssigningTaskLIst from './AssigningTaskLIst.vue';

export default {
    props: ['taskAssigningData'],
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
                    <p>groups</p>
                    <p>+</p>
                </div>
                <div class="groups-items">
                    <div class="group-item">
                        group item
                    </div>
                    <div class="group-item">
                        group item
                    </div>
                    <div class="group-item">
                        group item
                    </div>
                    <div class="group-item">
                        group item
                    </div>
                    <div class="group-item">
                        group item
                    </div>
                    <div class="group-item">
                        group item
                    </div>
                    <div class="group-item">
                        group item
                    </div>
                    <div class="group-item">
                        group item
                    </div>
                    <div class="group-item">
                        group item
                    </div>
                    <div class="group-item">
                        group item
                    </div>
                </div>
            </div>
        </div>
        <AssigningTaskLIst :tasksAssigning="tasksAssigning" />
    </div>
</template>
