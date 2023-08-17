<script>

export default {
    props: ['taskAssigning'],
    // created() {
    //     console.log(this.taskAssigning)
    // }
}
</script>
<template>
    <div class="right-task-display">
        <div class="left-task-continer">
            <div class="left-assigning">
                <div class="header-assigning">
                    <h4>Task assigning</h4>
                </div>
                <div class="task-assigning-body" v-if="taskAssigning.length>0">
                    <div class="task-assigning-items" v-for="(item, index) in taskAssigning" :key="index" >
                        {{ item.name }}
                    </div>
                </div>
                <div class="notask-assign" v-else>
                    <h1>You have not assinged any user a task</h1>
                </div>
            </div>
        </div>
    </div>
</template>