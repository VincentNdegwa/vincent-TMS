<template>
    <section class="profile-section">
        <HeaderHome :HeaderHome="HeaderHome"></HeaderHome>
        <div class="container mt-4 profile-container">
            <div class="row">
                <div class="">
                    <!-- Profile Picture -->
                    <img :src="profilePic" alt="Profile" class="img-fluid profile-picture" />
                    <input type="file" @change="changeProfilePic" class="file-input" accept="image/*" />
                </div>
                <div class="mt-4">
                    <!-- Change Profile Picture Button -->

                    <!-- Full Name -->
                    <label class="label-text">Full Name:</label>
                    <input type="text" v-model="fullName" class="input-field" :readonly="true" />

                    <!-- Username -->
                    <label class="label-text">Username:</label>
                    <input type="text" v-model="username" class="input-field" :readonly="true" />

                    <!-- Email -->
                    <label class="label-text">Email:</label>
                    <input type="text" v-model="email" class="input-field" :readonly="true" />

                    <!-- Email Verification Status -->
                    <div v-if="!emailVerified">
                        <span class="verification-status text-danger">Email not verified</span>
                        <button @click="verifyEmail" class="verify-email-btn">Verify Email</button>
                    </div>
                    <div v-else>
                        <span class="verification-status text-success">Email verified</span>
                    </div>

                    <!-- Password -->
                    <label class="label-text">Password:</label>
                    <input type="password" v-model="password" class="input-field" :readonly="true" />

                    <label class="label-text">New Password:
                        <input type="text" v-model="newPassword" class="input-field" />
                    </label>
                    <button @click="changePassword" class="change-password-btn">Change Password</button>
                    <!-- Time Created Account -->
                    <label class="label-text">Time Created Account:</label>
                    <input type="text" v-model="timeCreated" class="input-field" :readonly="true" />

                    <!-- Change Password Button -->

                    <!-- Hidden Fields -->

                    <!-- Additional Content -->
                    <!-- Add more content as needed -->
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import HeaderHome from './HomeComponents/HeaderHome.vue';
import moment from 'moment';
export default {

    props: ["userData", "userName"],
    data() {
        return {
            profilePic: 'images/no_profile.png',
            fullName: '',
            username: '',
            email: '',
            emailVerified: false,
            password: '********',
            timeCreated: '',
            hiddenField: '********',
            userName: "",
            newPassword: ""
        };
    },
    mounted() {

        this.profilePic = this.userData.profile_path ? window.Laravel.appUrl + "storage/" + this.userData.profile_path : 'images/no_profile.png';
        this.fullName = this.userData.fullName || "John Doe";
        this.username = this.userData.name;
        this.email = this.userData.email;
        this.timeCreated = moment(this.userData.created_at).fromNow().toLocaleUpperCase();
        this.emailVerified = this.userData.user_verification ? this.userData.user_verification.emailStatus === 'true' : false;
    },

    components: {
        HeaderHome
    },
    methods: {
        changeProfilePic(event) {
            // Handle profile picture change
            const file = event.target.files[0];
            if (file) {
                // Implement your logic to upload and update the profile picture
                // For example, you might use FormData and send it to the server
                // this.profilePic = 'path/to/new/profile-pic.jpg'; // Update the profile picture path
                this.$swal('Success', 'Profile picture updated!', 'success');
            }
        },
        verifyEmail() {
            // Implement your logic to send an email verification request
            // For example, you might send a request to the server
            // and update this.emailVerified when the verification is successful
            this.emailVerified = true;
            this.$swal('Success', 'Email verified!', 'success');
        },
        changePassword() {
            // Implement your logic to handle password change
            // For example, you might show a modal or redirect to a password change page
            this.$swal('Info', 'Implement password change logic here!', 'info');
        },
    },
};
</script>

<style>
:root {
    --black: #010101;
    --orange: #fe6902;
    --light-dark: #262626;
    --white: #e5e5e5;
    --yellow: #fde767;
}

body {
    background-color: var(--light-dark);
    color: var(--white);
}

.profile-section {
    height: 100% !important;
}

input {
    color: var(--black);
}

.profile-container {
    background-color: var(--light-dark);
    box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.3);
}


.profile-container>.row {
    display: grid;
    gap: 0.8rem;
    padding: 0.8rem;
    grid-template-columns: 5fr 8fr;
}

.col-md-4 img {
    z-index: 0;
    position: relative;
}


.profile-picture {
    width: 100%;
    border-radius: 50%;
}

.file-input {
    width: 100%;
    margin-bottom: 15px;
}

.input-field {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
}

.label-text {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

.verification-status {
    margin-right: 10px;
}

.verify-email-btn {
    background-color: var(--yellow);
    border: none;
    padding: 0.3rem;
    border-radius: 0.4rem;
    color: var(--orange);
    cursor: pointer;
    text-decoration: none;

}

.change-password-btn {
    background-color: var(--orange);
    color: var(--white);
    border: none;
    padding: 8px 15px;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
    margin-top: 15px;
}

.col-md-4,
.col-md-8 {
    position: relative !important;
    z-index: 0 !important;
}

@media screen and (max-width: 767px) {
    .profile-container {
        height: 100% !important;
    }

    .profile-container>.row {
        grid-template-columns: 1fr;
    }
}
</style>