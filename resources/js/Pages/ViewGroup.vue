<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
import AddMember from "./GroupComponets/AddMemberGroup.vue"
import DeleteGroup from "./GroupComponets/DeleteGroup.vue";
import EditGroup from "./GroupComponets/EditGroup.vue";
import ExitGroup from "./GroupComponets/ExitGroup.vue"
export default {
    props: ["viewData", "userName"],
    data() {
        return {
            mainData: Object,
            group_icon: "",
            user_id: Number,
            admin: false,

            overLays: {
                ShowAddMember: false,
                ShowDeleteGroup: false,
                ShowEditGroup: false,
                ShowExitGroup: false,
            },
            openOverlay: false

        }
    },
    components: {
        HeaderHome,
        AddMember,
        DeleteGroup,
        EditGroup,
        ExitGroup,
    }, methods: {
        scrollToBottom() {
            this.$refs.conversationContainer.scrollTop = this.$refs.conversationContainer.scrollHeight;
        },
        groupFunctions() {
            let current_user = this.mainData.user_group.find((item) => item.users.id == this.user_id)
            if (current_user.admin) {
                this.admin = true
            } else {
                this.admin = false
            }
        },
        checkIfAdmin(id) {
            let list_user = this.mainData.user_group.find((item) => item.users.id == id)
            if (list_user.admin) {
                return true
            } else {
                return false
            }
        }, handleOptionClick(option) {
            this.ShowEditGroup = option === 'edit';
            this.ShowExitGroup = option === 'exit';
            this.ShowDeleteGroup = option === 'delete';
            this.ShowAddMember = option === 'addMember';
            this.openOverlay = true;
        }, closeDialog(data) {
            this.openOverlay = false;
            console.log(data, "in main")
            this.mainData.group_icon = data.group_icon
            this.mainData.group_name = data.group_name
            this.mainData.group_description = data.group_description
        }
    }, mounted() {
        this.scrollToBottom()
        if (!this.viewData.error) {
            this.mainData = this.viewData.group_data
            this.group_icon = "/" + this.mainData.group_icon
            this.user_id = this.viewData.user_id
            this.groupFunctions()
        } else {
            console.log("There is an issue")
        }
    }
}

</script>
<template>
    <section class="dashboard">
        <HeaderHome :userName="userName" />
        <main class="group_container">
            <div class="main_screen">
                <div class="conversation_section">
                    <div class="conversation_header">
                        <div class="group_avatar">
                            <img :src="group_icon" alt="">
                        </div>
                        <div class="group_name">
                            <p>{{ mainData.group_name }}</p>
                            <small>{{ mainData.created_at }}</small>
                        </div>
                        <div class="group_functions">
                            <button>Create Task</button>
                        </div>
                    </div>
                    <div class="converstaion_container" ref="conversationContainer">
                        <div class="message-container">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet. Lorem ipsum dolor
                                    sit, amet consectetur adipisicing elit. Officiis maxime maiores doloribus, nulla
                                    voluptatibus ipsam nisi praesentium voluptatum incidunt magnam adipisci fugiat
                                    doloremque optio quos, nobis, ducimus deserunt nemo deleniti!</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>
                        <div class="message-container current_user_message">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet.</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>
                        <div class="message-container">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet. Lorem ipsum dolor
                                    sit, amet consectetur adipisicing elit. Officiis maxime maiores doloribus, nulla
                                    voluptatibus ipsam nisi praesentium voluptatum incidunt magnam adipisci fugiat
                                    doloremque optio quos, nobis, ducimus deserunt nemo deleniti!</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>
                        <div class="message-container current_user_message">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet.</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>
                        <div class="message-container">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet. Lorem ipsum dolor
                                    sit, amet consectetur adipisicing elit. Officiis maxime maiores doloribus, nulla
                                    voluptatibus ipsam nisi praesentium voluptatum incidunt magnam adipisci fugiat
                                    doloremque optio quos, nobis, ducimus deserunt nemo deleniti!</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>
                        <div class="message-container current_user_message">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet.</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>
                        <div class="message-container">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet. Lorem ipsum dolor
                                    sit, amet consectetur adipisicing elit. Officiis maxime maiores doloribus, nulla
                                    voluptatibus ipsam nisi praesentium voluptatum incidunt magnam adipisci fugiat
                                    doloremque optio quos, nobis, ducimus deserunt nemo deleniti!</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>
                        <div class="message-container current_user_message">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet.</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>
                        <div class="message-container">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet. Lorem ipsum dolor
                                    sit, amet consectetur adipisicing elit. Officiis maxime maiores doloribus, nulla
                                    voluptatibus ipsam nisi praesentium voluptatum incidunt magnam adipisci fugiat
                                    doloremque optio quos, nobis, ducimus deserunt nemo deleniti!</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>
                        <div class="message-container current_user_message">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet.</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div>

                    </div>
                    <div class="text_box">
                        <div class="input-container">
                            <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Type your message...">
                            <i class='bx bx-send' @click="sendMessage"></i>
                        </div>
                    </div>

                </div>
                <div class="member_section">
                    <div class="group_details">
                        <img :src="group_icon" alt="Profile Image" />
                        <h3>{{ mainData.group_name }}</h3>
                        <p>{{ mainData.group_description }}</p>
                    </div>

                    <div class="member_details">
                        <div class="settings_group">
                            <small>Options</small>
                            <div class="settlings_list">
                                <div @click="handleOptionClick('edit')" class="settings_item" v-if="admin">
                                    <i class='bx bx-edit'></i>
                                    Edit Group
                                </div>
                                <div @click="handleOptionClick('exit')" class="settings_item">
                                    <i class='bx bx-exit'></i>
                                    Exit Group
                                </div>
                                <div @click="handleOptionClick('delete')" class="settings_item" v-if="admin">
                                    <i class='bx bx-trash'></i>
                                    Delete Group
                                </div>
                            </div>
                        </div>
                        <div class="members_list">
                            <small>Members</small>
                            <div @click="handleOptionClick('addMember')" class="settings_item" v-if="admin">
                                <i class='bx bx-plus-circle'></i>
                                Add Member
                            </div>
                            <div class="member_scroll_list">
                                <div class="member-item" v-for="(item, index) in mainData.user_group" :key="index">
                                    <img class="avatar" src="../../../public/images/cool-background.png"
                                        alt="Member Avatar">
                                    <div class="member-details">
                                        <h3>{{ item.users.name }}</h3>
                                        <p>{{ item.users.email }}</p>
                                    </div>
                                    <i v-if="checkIfAdmin(item.id)" class='bx bxs-badge-check'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="group_overlay" v-if="openOverlay">
            <span @click="() => openOverlay = false"><i class='bx bx-x-circle'></i></span>
            <AddMember :ShowAddMember="ShowAddMember" />
            <DeleteGroup :ShowDeleteGroup="ShowDeleteGroup" />
            <EditGroup :ShowEditGroup="ShowEditGroup" :mainData="mainData" @closeDialog="closeDialog" />
            <ExitGroup :ShowExitGroup="ShowExitGroup" />
        </div>
    </section>
</template>



<style>
@import url("../Styles/viewgroup.css");
</style>