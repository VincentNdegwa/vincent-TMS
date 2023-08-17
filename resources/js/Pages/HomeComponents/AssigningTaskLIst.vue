<script>
export default {
    props: ['tasksAssigning'],
    data() {
        return {
            tasksAssigning: this.tasksAssigning.slice(0,5)
        }
    },
    created() {
        console.log(this.tasksAssigning)
    }
}
</script>

<template>
    <div class="task-list task-assigning">
        <div class="assigning-table-holder">
            <span>Tasks Assigning</span>
            <table class="assigning-table">
                <thead>
                    <tr>
                        <th scope="col">name</th>
                        <th scope="col">member</th>
                        <th scope="col">status</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr v-for="(item, index) in tasksAssigning" :key="index">
                        <th scope="row"> {{item.name}}</th>
                        <td>{{ item.user_id }} </td>
                        <td>{{item.status? "completed": "pending"}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>