<script>
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/inertia-vue3'

export default {
    data() {
        return {
            openMenu: false,
            width: window.innerWidth,
            menuClicked: false
        }
    },
    components: {
        BreezeDropdownLink
    },
    props: ['userName'],
    methods: {
        handleMenu() {
            if (this.openMenu) {
                // this.menuClicked = false
                this.openMenu = false
            } else {
                // this.menuClicked = true
                this.openMenu = true
            }
        }
    }
}

</script>

<template>
    <header>
        <div class="avatar">{{ userName }} </div>
        <div :class="openMenu ? 'left_header openMenu' : 'left_header'">
            <i v-if="openMenu" class='bx bx-x' @click="handleMenu"></i>
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
        <i class="bx bx-menu" @click="handleMenu"></i>
    </header>
</template>
<style>
@import url("../../Styles/dashboard.css");
</style>