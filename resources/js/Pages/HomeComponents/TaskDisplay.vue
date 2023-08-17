<script>
export default {
    props: ["userTasks","taskCountGiving"],
    Maindata:Array,
    data() {
        return {
            totalTasks: 0,
            completedTasks: 0,
            latestTasks: 0,
            totalTaskAssinging: this.taskCountGiving,
        }
    },
    methods: {
        printData() {
            this.Maindata = JSON.parse(JSON.stringify(this.userTasks))
            // console.log(this.Maindata)
        },
        calculateStatistics() {
            // total tasks
            this.totalTasks = this.Maindata.length
            // completed task
            this.completedTasks = this.Maindata.filter((item) => item.completed === 1).length
            // latest tasks
            // this.Maindata.filter((item)=>(new Date(item.created_at)- new Date())<= 86400)
            this.latestTasks =this.Maindata.filter((item) => {
                const timeDiff = Math.abs(new Date(item.created_at) - new Date());
                const timeDiffInSeconds = Math.floor(timeDiff / 1000);
                return timeDiffInSeconds <= 86400;
            }).length
        }
    },
    created() { 
        this.printData(),
        this.calculateStatistics()
    }

}
</script>

<template>
    <div class="main-task-displays">
        <div class="task-item">
            <p>Total tasks</p>
            <h1>{{ totalTasks }} tasks</h1>
        </div>

        <div class="task-item">
            <p>Task completed</p>
            <h1>{{ completedTasks }} tasks</h1>
        </div>

        <div class="task-item">
            <p>Task Assinging</p>
            <h1>{{ totalTaskAssinging }} tasks</h1>
        </div>


        <div class="task-item">
            <p>latest tasks</p>
            <h1>{{ latestTasks }} tasks</h1>
        </div>
    </div>
</template>
