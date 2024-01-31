
<script>
import axios from 'axios';

export default {
    props: {
        ShowEditGroup: Boolean,
        mainData: Object,
    },
    data() {
        return {
            editedGroup: {
                group_name: "",
                group_description: "",
                group_icon: null,
                existing_icon: "",
                id: ""
            },
            new_group_icon: ""
        };
    },
    methods: {
        handleFileChange(event) {
            this.editedGroup.group_icon = event.target.files[0];
            this.new_group_icon = event.target.files[0];
            this.updateGroupIconPreview();
        },
        updateGroupIconPreview() {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.editedGroup.group_icon = e.target.result;
            };
            reader.readAsDataURL(this.editedGroup.group_icon);
        },
        removeGroupAvatar() {
            this.editedGroup.group_icon = null;
            this.new_group_icon = ""
        },
        saveChanges() {
            if (!this.editedGroup.group_name || !this.editedGroup.group_description) {
                alert('Group name and description cannot be empty.');
                return;
            }

            const formData = new FormData();
            formData.append('group_name', this.editedGroup.group_name);
            formData.append('group_description', this.editedGroup.group_description);
            formData.append('new_group_icon', this.new_group_icon);
            formData.append('group_icon', this.editedGroup.group_icon);
            formData.append('existing_icon', this.editedGroup.existing_icon)
            formData.append('id', this.editedGroup.id)


            axios.post('/group/update', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    console.log('Server response:', response.data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
    },
    mounted() {
        // Initialize the form with existing data
        this.editedGroup.group_name = this.mainData.group_name;
        this.editedGroup.group_description = this.mainData.group_description;
        this.editedGroup.group_icon = "/" + this.mainData.group_icon;
        this.editedGroup.existing_icon = this.mainData.group_icon
        this.editedGroup.id = this.mainData.id
    },
};
</script>

<template>
    <div class="edit-group-container" v-if="ShowEditGroup">
        <div class="">
            <div class="card-header">
                <h5 class="card-title">Edit Group</h5>
            </div>
            <div class="card-body">
                <div class="group_image_display">
                    <div class="group_avatar">
                        <img :src="editedGroup.group_icon" alt="">
                    </div>
                    <i class='bx bx-trash' @click="removeGroupAvatar"></i>
                </div>

                <!-- Edit Group Profile -->
                <div class="form-group">
                    <label for="groupProfile">Group Profile</label>
                    <input type="file" class="form-control" id="groupProfile" @change="handleFileChange" accept="image/*">
                </div>

                <!-- Edit Group Name -->
                <div class="form-group">
                    <label for="groupName">Group Name</label>
                    <input type="text" class="form-control" id="groupName" v-model="editedGroup.group_name">
                </div>

                <!-- Edit Group Description -->
                <div class="form-group">
                    <label for="groupDescription">Group Description</label>
                    <textarea class="form-control" id="groupDescription" v-model="editedGroup.group_description"></textarea>
                </div>

                <div class="text-center">
                    <button class="btn group_btn" @click="saveChanges">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scope>
.edit-group-container {
    width: 600px;
    margin: auto;
    padding: 20px;
    background: var(--light-dark);
}

.group_btn {
    background: var(--dark);
    width: 100%;
    border: 1px solid var(--orange);
    transition: all ease-in-out 0.5s;
}

.group_btn:hover {
    background: var(--orange);
    width: 100%;
    border: 1px solid var(--dark);
}

.group_image_display {
    position: relative;
    display: flex;
}

.group_image_display .bx-trash {
    color: var(--yellow);
    font-size: 2rem;
    position: absolute;
    bottom: 0;
    left: 3.5rem;
}

@media screen and (max-width:600px) {
    .edit-group-container {
        width: 96%;
    }

}
</style>
