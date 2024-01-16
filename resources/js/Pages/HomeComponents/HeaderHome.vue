<script>
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/inertia-vue3'

export default {
    setup() {

    },
    components: {
        BreezeDropdownLink
    },
    props: ['userName']
}

</script>

<template>
    <header>
        <div class="avatar">{{ userName }} </div>
        <div class="left_header">
            <nav>
                <a :href="route('getUserTasks')">Home</a>
                <a :href="route('createTask')">Task Create</a>
                <a :href="route('viewTasks')">View Tasks</a>
                <a :href="route('getPlayGround')">PlayGround</a>
                <a href="">Home</a>
            </nav>
            <div class="left-nav">
                <h2><i class='bx bxs-user'></i></h2>
                <a :href="route('logout')">logout</a>
            </div>
        </div>
    </header>
</template>
<style>
@import url("../../Styles/dashboard.css");
</style>