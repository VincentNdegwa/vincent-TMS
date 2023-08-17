<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
export default {
    components: {
    HeaderHome
   } 
}
</script>

<template>
        <section class="dashboard">
            <HeaderHome :userName="userName" />
            <main class="main-container playGround-container">
                <div></div>
                <div></div>
            </main>
        </section>
</template>
<style>
@import url("../Styles/playGround.css");
@import url("../Styles/dashboard.css");
</style>