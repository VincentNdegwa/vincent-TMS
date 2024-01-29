<template>
    <section class="dashboard">
        <HeaderHome :userName="userName" />
        <main class="group_container">
            <div class="main_screen">
                <div class="conversation_section">
                    <div class="conversation_header">
                        <div class="group_avatar">
                            <img src="../../../public/images/cool-background.png" alt="">
                        </div>
                        <div class="group_name">
                            <p>Malaka group</p>
                            <small>Created at:</small>
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
                        <img src="../../../public/images/cool-background.png" alt="Profile Image" />
                        <h3>Group Name</h3>
                        <p>Group description goes here...</p>
                    </div>

                    <div class="member_details">
                        <div class="settings_group">
                            <small>Options</small>
                            <div class="settlings_list">
                                <div class="settings_item">
                                    <i class='bx bx-edit'></i>
                                    Edit Group
                                </div>
                                <div class="settings_item">
                                    <i class='bx bx-exit'></i>
                                    Exit Group
                                </div>
                            </div>
                        </div>
                        <div class="members_list">
                            <small>Members</small>
                            <div class="settings_item">
                                <i class='bx bx-plus-circle'></i>
                                Add Member
                            </div>
                            <div class="member_scroll_list">
                                <div class="member-item">
                                    <img class="avatar" src="../../../public/images/cool-background.png"
                                        alt="Member Avatar">
                                    <div class="member-details">
                                        <h3>Member Name</h3>
                                        <p>member@example.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    }, methods: {
        scrollToBottom() {
            this.$refs.conversationContainer.scrollTop = this.$refs.conversationContainer.scrollHeight;
        },
    }, mounted() {
        this.scrollToBottom()
    }
}
</script>

<style>@import url("../Styles/viewgroup.css");</style>