<template>
    <section class="dashboard">
        <HeaderHome :userName="userName" />
        <main class="group_container">
            <div class="main_screen">

            </div>
        </main>
    </section>
</template>

<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
export default {
    props: ["viewData", "userName"],
    components: {
        HeaderHome,
    }
}
</script>

<style>
.group_container {
    display: grid;
    grid-template-columns: 100%;
    place-items: center;
}

.main_screen {
    background: var(--white);
    width: 100%;
    height: 100%;
    max-width: 1400px;
    box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.4);
    /* background-image: url("../../../public/images/cool-background.png");
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    filter: blur(2px); */
}
</style>