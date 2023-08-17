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
                <nav>
                    <a :href="route('getUserTasks')">Home</a>
                    <a :href="route('createTask')">Task Create</a>
                    <a :href="route('viewTasks')">View Tasks</a>
                    <a :href="route('getPlayGround')">PlayGround</a>
                    <a href="">Home</a>
                </nav>
                <a :href="route('logout')">logout</a>
            </header>
</template>
<style>
@import url("../../Styles/dashboard.css");
</style>