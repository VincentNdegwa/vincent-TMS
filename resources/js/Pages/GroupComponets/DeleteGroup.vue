<template>
    <div v-if="ShowDeleteGroup" class="delete-group-modal">
        <div class="delete-group-content">
            <p>Are you sure you want to delete the group?</p>
            <p class="subtext">Deleting the group will remove all members and data from the group.</p>
            <div class="button-container">
                <button class="button-cancel" @click="cancelDelete">Cancel</button>
                <button class="button-delete" @click="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        ShowDeleteGroup: Boolean
    },
    methods: {
        cancelDelete() {
            this.$emit('cancel-delete', false);
        },
        confirmDelete() {
            this.$emit('confirm-delete', true);
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

.delete-group-modal {
    background: var(--light-dark);
    width: max-content;
    padding: 1rem;
}

.button-delete,
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
