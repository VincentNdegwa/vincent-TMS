<script>
export default {
    props: ["userTasks"],
    myData: Array,
    created() {
        // console.log(JSON.parse(JSON.stringify(this.userTasks)))
        this.myData = JSON.parse(JSON.stringify(this.userTasks))
    }

}
</script>

<template>
    <div class="task-list">
        <div class="task-holder">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Task name</th>
                        <th scope="col">Member</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date issued</th>
                        <th scope="col">Date done</th>
                    </tr>
                </thead>
                <tbody v-if="myData.length > 0">
                    <tr v-for="(item, index) in myData" :key="index">
                        <th scope="row" class="ellipsis">{{ item.name }}</th>
                        <td class="ellipsis">{{ item.assigner }} </td>
                        <td class="ellipsis">{{ item.completed ? "completed" : "incomplete" }} </td>
                        <td class="ellipsis">{{ new Date(item.created_at).toLocaleDateString() }} </td>
                        <td class="ellipsis">{{ item.due_date ? new Date(item.due_date).toLocaleDateString() : "No due" }}
                        </td>
                    </tr>
                </tbody>
                <div v-else class="no-task-row">
                    You have no tasks
                </div>
            </table>
        </div>
    </div>
</template>
