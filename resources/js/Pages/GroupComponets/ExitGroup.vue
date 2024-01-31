<template>
    <div v-if="ShowExitGroup" class="exit-group-modal">
        <div class="exit-group-content">
            <p>Are you sure you want to exit the group?</p>
            <p class="subtext">Exiting the group will remove you as a member, but data will remain for others.</p>
            <div class="button-container">
                <button class="button-cancel" @click="cancelExit">Cancel</button>
                <button class="button-exit" @click="confirmExit">Exit</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        ShowExitGroup: Boolean
    },
    methods: {
        cancelDelete() {
            this.$emit('cancel-delete');
        },
        confirmDelete() {
            this.$emit('confirm-delete');
        }
    }
}
</script>

<style>
.button-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

button {
    padding: 10px 20px;
    cursor: pointer;
}

.exit-group-modal {
    background: var(--light-dark);
    width: max-content;
    padding: 1rem;
}

.button-exit,
.button-cancel {
    background: var(--orange);
    border-radius: 0.5rem;
    border: 1px solid var(--dark);
    transition: all ease-in-out 0.5s;

}

.button-container>button:hover {
    background: var(--yellow);
    color: var(--light-dark);
    transition: all ease-in-out 0.5s;
}
</style>

<!-- ShowExitGroup -->