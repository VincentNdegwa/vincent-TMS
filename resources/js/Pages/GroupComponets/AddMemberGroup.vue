<script>
import axios from 'axios';
import SweetAlerts from '@/modules/SweetAlerts.vue';

export default {
    props: {
        ShowAddMember: Boolean,
        groupId: Number
    },
    data() {
        return {
            memberInput: '',
            searchResults: [],
            selectedUser: null,
            Alerts: ""
        };
    },
    components: {
        SweetAlerts,
    },
    methods: {
        async searchMembers() {
            try {
                if (this.memberInput.trim()) {
                    const response = await axios.post('/group/member/search', {
                        "search": this.memberInput,
                    });
                    this.searchResults = response.data;
                }
            } catch (error) {
                console.error('Error searching members:', error);
            }
        },
        selectUser(userId) {
            this.selectedUser = this.searchResults.find(user => user.id === userId);
        },
        submitSelectedUser() {
            if (this.selectedUser) {
                axios.post('/group/member/add', {
                    "user_id": this.selectedUser.id,
                    "group_id": this.groupId
                })
                    .then(response => {
                        if (!response.data.error) {
                            console.log(response.data.message)
                            this.Alerts.showNotification(response.data.message)
                        } else {
                            console.log(response.data.message)
                            this.Alerts.showNotificationError(response.data.message)
                        }

                    })
                    .catch(error => {
                        this.Alerts.ShowAlert(error)
                        console.error('Error:', error);
                    });
                console.log(this.Alerts)

                this.$emit("cancel-overlay")
            }
        },
    },
    mounted() {
        this.Alerts = this.$refs.SweetAlerts
    }
}
</script>

<template>
    <div v-if="ShowAddMember" class="add-member-container">
        <SweetAlerts ref="SweetAlerts"></SweetAlerts>
        <div class="search-container">
            <label for="memberInput">Enter Member Name or Email:</label>
            <input type="text" id="memberInput" v-model="memberInput" @input="searchMembers"
                placeholder="Search for members..." />

            <ul v-if="searchResults.length > 0" class="search-results">
                <li v-for="user in searchResults" :key="user.id" @click="selectUser(user.id)">
                    {{ user.name }} - {{ user.email }}
                </li>
            </ul>
        </div>

        <div v-if="selectedUser" class="selected-user-container">
            <p>Selected User:</p>
            <p>{{ selectedUser.name }} - {{ selectedUser.email }}</p>
            <button @click="submitSelectedUser">Submit</button>
        </div>
    </div>
</template>
<style>
.add-member-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: var(--light-dark);
    color: var(--white);
}

.search-container {
    margin-bottom: 20px;
}

label {
    color: var(--yellow);
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid var(--white);
    border-radius: 5px;
    background-color: var(--light-dark);
    color: var(--dark);
}

.search-results {
    list-style: none;
    padding: 0;
    margin: 0;
}

.search-results li {
    cursor: pointer;
    padding: 5px;
    border: 1px solid var(--white);
    border-radius: 5px;
    margin-bottom: 5px;
}

.selected-user-container {
    padding: 10px;
    border: 1px solid var(--white);
    border-radius: 5px;
    background-color: var(--light-dark);
}

.selected-user-container>button {
    outline: none;
    border: 1px solid var(--orange);
    background: var(--dark);
    border-radius: 0.5rem;
    transition: all ease-in-out 0.5s;
}

.selected-user-container>button:hover {
    border: 1px solid var(--dark);
    background: var(--orange);
    transition: all ease-in-out 0.5s;

}
</style>
