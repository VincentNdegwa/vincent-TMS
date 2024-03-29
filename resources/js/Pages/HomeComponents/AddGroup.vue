<template>
    <div class="group_overlay" v-if="addGroup">
        <SweetAlerts ref="SweetAlerts"></SweetAlerts>
        <div class="group_form">
            <div class="exit-button"><i @click="closeOverlay" class='bx bx-x-circle'></i></div>
            <div class="card container-fluid">
                <div class="card-body">
                    <h5 class="card-title">Group Information</h5>

                    <form @submit.prevent="submitForm">
                        <div class="form-group">
                            <label for="groupName">Group Name</label>
                            <small class="form-text text-muted">
                                The entered name will be the name of the group and can be edited later. You will be the
                                admin of the group.
                            </small>
                            <input type="text" v-model="form.groupName" class="form-control" id="groupName" required>

                            <label for="groupDescription">Group Description</label>
                            <small class="form-text text-muted">
                                Enter a brief description of the group.
                            </small>
                            <textarea type="text" v-model="form.group_description" class="form-control"
                                id="group_description" required></textarea>

                            <label for="groupIcon">Group Icon (Image File)</label>
                            <small class="form-text text-muted">
                                Please upload an image file (e.g., JPG, PNG) for the group icon.
                            </small>
                            <input type="file" @change="handleFileChange" accept="image/*" class="form-control"
                                id="group_icon" required>

                        </div>

                        <button type="submit" class="btn btn-primary group_btn">Create Group</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import SweetAlerts from '@/modules/SweetAlerts.vue';

export default {
    props: {
        addGroup: Boolean
    },
    data() {
        return {
            form: {
                groupName: "",
                group_description: "",
                group_icon: null
            },
            createdGroup: ""
        }
    },
    components: {
        SweetAlerts
    },
    methods: {
        closeOverlay() {
            this.$emit("closeOverlay")
        },
        async submitForm() {
            try {
                let formData = new FormData();
                formData.append("group_name", this.form.groupName);
                formData.append("group_description", this.form.group_description);
                formData.append("group_icon", this.form.group_icon);

                let results = await axios.post("/group/create", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (results.data.error) {
                    this.$refs.SweetAlerts.showNotificationError(results.data.message)
                } else {
                    this.$refs.SweetAlerts.showNotification(results.data.message)
                    this.createdGroup = results.data.data
                }

                this.$emit("closeOverlay")
            } catch (error) {
                console.log("there is a catch error")
                this.$refs.SweetAlerts.ShowAlert(error)
            }
        },
        handleFileChange(event) {
            this.form.group_icon = event.target.files[0];
        }
    },
    watch: {
        createdGroup: {
            handler: function (newGroup, oldGroup) {
                console.log("newgroup detected")
                this.$emit("latestGroup", newGroup)
            },
            deep: true
        }
    }
}
</script>


<style>
.group_overlay {
    width: 100%;
    height: 100vh;
    background: rgba(0, 0, 0, 0.8);
    position: absolute;
    top: 0;
    left: 0;
    display: grid;
    place-items: center;
    overflow-y: scroll;
}

.group_overlay::-webkit-scrollbar {
    display: none;
}

.group_form {
    max-width: 700px;
    width: 100%;
}

.card {
    background-color: var(--light-dark);
}

.group_btn {
    background: transparent;
    border: 1px solid var(--orange);
}

.group_btn:hover {
    background: var(--orange);
}

.card-title {
    height: 100px;
    color: var(--orange);
    font-size: 1.6rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.exit-button>i {
    font-size: 2rem;
    color: var(--white);
    cursor: pointer;
}

.exit-button>i:hover {
    color: var(--orange);
    transition: all ease-in-out 0.5s;
}
</style>