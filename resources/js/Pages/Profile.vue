<template>
    <section class="profile-section">
        <HeaderHome :HeaderHome="HeaderHome"></HeaderHome>
        <div class="container mt-4 profile-container">
            <div class="row">
                <div class="">
                    <!-- Profile Picture -->
                    <img :src="user.profilePic" alt="Profile" class="img-fluid profile-picture" />
                    <input type="file" @change="changeProfilePic" class="file-input" accept="image/*" />
                    <label class="label-text mb-4">Time Created Account: <small>{{ user.timeCreated }}</small></label>
                </div>
                <div class="mt-4">
                    <!-- Change Profile Picture Button -->

                    <!-- Full Name -->
                    <label class="label-text">Full Name:</label>
                    <input type="text" v-model="user.fullName" class="input-field" />

                    <!-- Username -->
                    <label class="label-text">Username:</label>
                    <input type="text" v-model="user.username" class="input-field" />

                    <!-- Email -->
                    <label class="label-text">Email:</label>
                    <p>{{ user.email }}</p>

                    <!-- Email Verification Status -->
                    <div v-if="!user.emailVerified">
                        <span class="verification-status text-danger">Email not verified</span>
                        <button @click="verifyEmail" class="verify-email-btn">Verify Email</button>
                    </div>
                    <div v-else>
                        <span class="verification-status text-success">Email verified</span>
                    </div>

                    <!-- Password -->
                    <label class="label-text">Password:</label>
                    <input type="password" v-model="user.password" class="input-field" :readonly="true" />

                    <label class="label-text">New Password:
                        <input type="text" v-model="user.newPassword" class="input-field" />
                    </label>
                    <button @click="changeProfile" class="change-password-btn">Update Profile</button>
                    <!-- Time Created Account -->

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
import axios from 'axios';
import HeaderHome from './HomeComponents/HeaderHome.vue';
import moment from 'moment';

export default {
    props: ["userData", "userName"],
    data() {
        return {
            user: {
                profilePic: 'images/no_profile.png',
                fullName: '',
                username: '',
                email: '',
                emailVerified: false,
                password: '********',
                timeCreated: '',
                hiddenField: '********',
                userName: "",
                newPassword: "",
                updateprofile: ""
            }
        };
    },
    mounted() {
        this.user.profilePic = this.userData.profile_path ? window.Laravel.appUrl + "storage/" + this.userData.profile_path : 'images/no_profile.png';
        this.user.fullName = this.userData.fullName || "John Doe";
        this.user.username = this.userData.name;
        this.user.email = this.userData.email;
        this.user.timeCreated = moment(this.userData.created_at).fromNow().toLocaleUpperCase();
        this.user.emailVerified = this.userData.user_verification ? this.userData.user_verification.emailStatus === 'true' : false;
    },
    components: {
        HeaderHome
    },
    methods: {
        changeProfilePic(event) {
            const file = event.target.files[0];
            if (file) {
                let reader = new FileReader()

                reader.onload = (e) => {
                    this.user.profilePic = e.target.result;
                }
                reader.readAsDataURL(file);
                this.user.updateprofile = file;
            }
        },
        verifyEmail() {
            // Implement your logic to send an email verification request
            // For example, you might send a request to the server
            // and update this.user.emailVerified when the verification is successful
            this.user.emailVerified = true;
            this.$swal('Success', 'Email verified!', 'success');
        },
        changeProfile() {
            let newData = {
                username: this.user.username,
                fullName: this.user.fullName,
                newPassword: this.user.newPassword,
                updateprofile: this.user.updateprofile,

            }
            // axios.post("/", newData)
            //     .then((response) => { })
            //     .catch((err) => {
            //         this.$swal("Failed", "Please try again later.", "warning");
            //     })
            // this.$swal('Info', 'Implement password change logic here!', 'info');
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