<template>
    <div v-if="ShowAddMember" class="add-member-container">
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

<script>
import axios from 'axios';

export default {
    props: {
        ShowAddMember: Boolean,
    },
    data() {
        return {
            memberInput: '',
            searchResults: [],
            selectedUser: null,
        };
    },
    methods: {
        async searchMembers() {
            try {
                const response = await axios.post('/group/member/search', {
                    "search": this.memberInput,
                });
                this.searchResults = response.data;
            } catch (error) {
                console.error('Error searching members:', error);
            }
        },
        selectUser(userId) {
            this.selectedUser = this.searchResults.find(user => user.id === userId);
        },
        submitSelectedUser() {
            if (this.selectedUser) {
                axios.post('/group/addMember', {
                    user_id: this.selectedUser.id,
                })
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.error('Error adding member:', error);
                    });
            }
        },
    }
}
</script>

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
    color: var(--white);
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
