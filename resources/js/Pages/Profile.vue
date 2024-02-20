<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Picture -->
                <img :src="profilePic" alt="Profile" class="img-fluid rounded-circle mb-3" />

                <!-- Change Profile Picture Button -->
                <input type="file" @change="changeProfilePic" class="form-control mb-3" accept="image/*" />

                <!-- Name -->
                <label>Name:</label>
                <input type="text" v-model="name" class="form-control mb-3" :readonly="true" />

                <!-- Email -->
                <label>Email:</label>
                <input type="text" v-model="email" class="form-control mb-3" :readonly="true" />

                <!-- Email Verification Status -->
                <div v-if="!emailVerified">
                    <span class="text-danger">Email not verified</span>
                    <button @click="verifyEmail" class="btn btn-link p-0">Verify Email</button>
                </div>
                <div v-else>
                    <span class="text-success">Email verified</span>
                </div>

                <!-- Password Change -->
                <button @click="changePassword" class="btn btn-primary mt-3">Change Password</button>
            </div>
            <div class="col-md-8">
                <!-- Hidden Fields -->
                <input type="hidden" v-model="password" />
                <input type="hidden" v-model="hiddenField" />

                <!-- Additional Content -->
                <!-- Add more content as needed -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            profilePic: 'images/no_profile.png',
            name: 'John Doe',
            email: 'john@example.com',
            emailVerified: false,
            password: '********', // Dummy password, should be handled securely
            hiddenField: '********', // Other hidden fields, if needed
        };
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

/* Add more styles as needed */
</style>
