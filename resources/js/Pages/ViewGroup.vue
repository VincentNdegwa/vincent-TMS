<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
import AddMember from "./GroupComponets/AddMemberGroup.vue"
import DeleteGroup from "./GroupComponets/DeleteGroup.vue";
import EditGroup from "./GroupComponets/EditGroup.vue";
import ExitGroup from "./GroupComponets/ExitGroup.vue"
import SweetAlerts from '@/modules/SweetAlerts.vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';
import Pusher from "pusher-js";
import { format, render, cancel, register } from 'timeago.js';
export default {
    props: ["viewData", "userName"],
    data() {
        return {
            mainData: Object,
            group_icon: "",
            user_id: Number,
            admin: false,
            groupId: Number,
            newMessage: "",

            overLays: {
                ShowAddMember: false,
                ShowDeleteGroup: false,
                ShowEditGroup: false,
                ShowExitGroup: false,
            },
            openOverlay: false,
            selectedUserOptions: null,
            dialogStyle: {
                top: 0,
                left: 0,
            },
            currentGroupMessages: [],
            liveMessage: ""

        }
    },
    components: {
        HeaderHome,
        AddMember,
        DeleteGroup,
        EditGroup,
        ExitGroup,
        SweetAlerts
    }, methods: {
        showOptions(user, event) {
            this.selectedUserOptions = user;
            this.dialogStyle = {
                top: event.clientY + 'px',
                left: event.clientX + 'px',
            };

        },
        convertTime(time) {
            return format(time, 'en');
        },
        sendMessage() {
            if (this.newMessage.trim() !== "") {
                axios.post('/messages/add', {
                    "user_id": this.user_id,
                    "group_id": this.groupId,
                    'message': this.newMessage,
                }).then(response => {
                    this.newMessage = "";
                    if (!response.data.error) {
                        console.log(response.data.message);
                        this.$nextTick(() => {
                            const container = this.$refs.conversationContainer;
                            container.scrollTop = container.scrollHeight;
                        });
                    } else {
                        console.log(response.data.message);
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            }
        },


        removeUser(user) {
            console.log(`Removing user ${user.users.name}`);
            this.selectedUserOptions = null;
        },
        scrollToBottom() {
            document.addEventListener("DOMContentLoaded", function () {
                let container = document.querySelector(".converstaion_container");
                container.scrollTop = container.scrollHeight;
            });
        },

        groupFunctions() {
            let current_user = this.mainData.user_group.find((item) => item.users.id == this.user_id)
            if (current_user.admin) {
                this.admin = true
            } else {
                this.admin = false
            }
        }, handleOptionClick(option) {
            this.ShowEditGroup = option === 'edit';
            this.ShowExitGroup = option === 'exit';
            this.ShowDeleteGroup = option === 'delete';
            this.ShowAddMember = option === 'addMember';
            this.openOverlay = true;
        }, closeDialog(data) {
            this.openOverlay = false;
            this.mainData.group_icon = data.group_icon
            this.mainData.group_name = data.group_name
            this.mainData.group_description = data.group_description
        },
        async exitGroup(status) {
            if (status) {
                await axios.post("/group/exit", {
                    "user_id": this.user_id,
                    "group_id": this.mainData.id
                }).then(response => {
                    if (!response.data.error) {
                        this.$refs.SweetAlerts.showNotification(response.data.message)
                        setTimeout(() => {
                            router.visit("/")
                        }, 3000);
                    } else {
                        this.$refs.SweetAlerts.showNotificationError(response.data.message)
                    }
                }).catch(err => {
                    this.$refs.SweetAlerts.showNotificationError(err)
                })
            } else {
                this.openOverlay = false
            }
        },
        async deleteGroup(status) {
            if (status) {
                await axios.post("/group/delete", {
                    "user_id": this.user_id,
                    "group_id": this.mainData.id
                }).then(response => {
                    if (!response.data.error) {
                        this.$refs.SweetAlerts.showNotification(response.data.message)
                        setTimeout(() => {
                            router.visit("/")
                        }, 3000);
                    } else {
                        this.$refs.SweetAlerts.showNotificationError(response.data.message)
                    }
                }).catch(err => {
                    this.$refs.SweetAlerts.showNotificationError(err)
                })
            } else {
                this.openOverlay = false
            }
        }
    }, mounted() {
        this.scrollToBottom()
        // Pusher.logToConsole = true;

        var pusher = new Pusher('5d03bc74ebd65c06a7d0', {
            cluster: 'mt1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', (data) => {
            var jsonData = data.data;
            this.liveMessage = JSON.parse(jsonData);;
        });


        if (!this.viewData.error) {
            this.mainData = this.viewData.group_data
            this.group_icon = "/" + this.mainData.group_icon
            this.user_id = this.viewData.user_id
            this.groupId = this.mainData.id
            this.currentGroupMessages = this.viewData.group_messages
            console.log(this.viewData);

            this.groupFunctions()
            let currectUser = this.viewData.group_data.user_group.find((item) => item.user_id == this.user_id)
            if (currectUser.admin == "true") {
                this.admin = true
            } else {
                this.admin = false
            }
        } else {
            console.log("There is an issue")
        }
    }, watch: {
        liveMessage: function (newVal, oldVal) {
            // console.log('liveMessage updated:', newVal);
            this.currentGroupMessages.push(newVal)
            this.$nextTick(() => {
                const container = this.$refs.conversationContainer;
                container.scrollTop = container.scrollHeight;
            });
        }
    },

}

</script>
<template>
    <section class="dashboard">
        <SweetAlerts ref="SweetAlerts"></SweetAlerts>
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
                        <div :class="{ 'message-container': true, 'current_user_message': item.user_id === user_id }"
                            v-for="(item, index) in currentGroupMessages" :key="index">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>{{ item.users.name }}</h3>
                                <p class="message">{{ item.message }}</p>
                                <p class="date">{{ convertTime(item.created_at) }}</p>
                            </div>
                        </div>
                        <!-- <div class="message-container current_user_message">
                            <img class="avatar" src="../../../public/images/cool-background.png" alt="User Avatar">
                            <div class="user-details">
                                <h3>User Name</h3>
                                <p class="message">This is a sample message. Lorem ipsum dolor sit amet.</p>
                                <p class="date">January 28, 2024</p>
                            </div>
                        </div> -->
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
                                <div class="member-item" v-for="(   item, index   ) in    mainData.user_group   "
                                    :key="index" @click="showOptions(item, $event)">
                                    <img class="avatar" src="../../../public/images/cool-background.png"
                                        alt="Member Avatar">
                                    <div class="member-details">
                                        <h3>{{ item.users.name }}</h3>
                                        <p>{{ item.users.email }}</p>
                                    </div>
                                    <i v-if="item.admin == 'true'" class='bx bxs-badge-check'></i>
                                </div>
                                <div v-if="selectedUserOptions" class="options-dialog" :style="dialogStyle"
                                    ref="optionsDialog">
                                    <button @click="removeUser(selectedUserOptions)">Remove User</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="group_overlay" v-if="openOverlay">
            <span @click="() => openOverlay = false"><i class='bx bx-x-circle'></i></span>
            <AddMember :ShowAddMember="ShowAddMember" :groupId="groupId" @cancel-overlay="() => openOverlay = false" />
            <ExitGroup :ShowExitGroup="ShowExitGroup" @cancel-exit="exitGroup" @confirm-exit="exitGroup" />
            <DeleteGroup :ShowDeleteGroup="ShowDeleteGroup" @cancel-delete="deleteGroup" @confirm-delete="deleteGroup" />
            <EditGroup :ShowEditGroup="ShowEditGroup" :mainData="mainData" @closeDialog="closeDialog" />
        </div>
    </section>
</template>




<style>
@import url("../Styles/viewgroup.css");
</style>