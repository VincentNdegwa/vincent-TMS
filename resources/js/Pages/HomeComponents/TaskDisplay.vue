<script>
export default {
    props: ["userTasks", "taskCountGiving"],
    Maindata: Array,
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
            this.latestTasks = this.Maindata.filter((item) => {
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
            <p>Total Tasks</p>
            <h1>{{ totalTasks }} Tasks</h1>
        </div>

        <div class="task-item">
            <p>Task Completed</p>
            <h1>{{ completedTasks }} Tasks</h1>
        </div>

        <div class="task-item">
            <p>Task Assinging</p>
            <h1>{{ totalTaskAssinging }} Tasks</h1>
        </div>


        <div class="task-item">
            <p>Latest Tasks</p>
            <h1>{{ latestTasks }} Tasks</h1>
        </div>
    </div>
</template>
