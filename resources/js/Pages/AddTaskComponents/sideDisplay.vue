<script>
export default {
    props: ['assigningTasks'],
    data() {
        return {
            userCreatedTask: ""
        }
    },
    created() {
        console.log(this.assigningTasks)
    },
}
</script>

<template>
    <div class="created-tasks-holder">
        <div class="side-display">
            <h2>Latest Tasks Created</h2>
            <div class="display-container">
                <div v-for="(item, index) in assigningTasks" :key="index" class="display-item">
                    <p>{{ item.name }} </p>
                </div>

            </div>
        </div>
        <div class="side-display">
            <h2>Latest User Submit</h2>
            <div class="display-container">
                <div class="display-item">
                    <p>name</p>
                </div>
                <div class="display-item">
                    <p>name</p>
                </div>
                <div class="display-item">
                    <p>name</p>
                </div>
                <div class="display-item">
                    <p>name</p>
                </div>
                <div class="display-item">
                    <p>name</p>
                </div>
                <div class="display-item">
                    <p>name</p>
                </div>
                <div class="display-item">
                    <p>name</p>
                </div>
                <div class="display-item">
                    <p>name</p>
                </div>
                <div class="display-item">
                    <p>name</p>
                </div>
            </div>
        </div>
    </div>
</template>