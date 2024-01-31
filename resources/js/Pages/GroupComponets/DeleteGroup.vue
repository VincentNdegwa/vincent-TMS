<script>
export default {
    props: {
        ShowDeleteGroup: Boolean
    }
}
</script>
<template>
    <div v-if="ShowDeleteGroup">
        Delete
    </div>
</template>
