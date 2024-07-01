<template>
    <div v-if="!error">
        <h2 class="mb-md-5 text-muted">{{ user.firstname }} {{ user.lastname }}</h2>

        <div class="d-md-flex">
            <div class="avatar-wrapper">
                <img :src="user.photo === null ? '/assets/images/no_avatar.png' : user.photo" class="avatar">
            </div>
            <div>
                <p>Position: <span class="text-muted">{{ user.position }}</span></p>
                <p>Email: <span class="text-muted">{{ user.email }}</span></p>
                <p>Phone: <span class="text-muted">{{ user.phone }}</span></p>
            </div>
        </div>
    </div>
    <div v-else class="alert alert-secondary" role="alert">{{ error }}!
        <router-link :to="{ name: 'home' }" class="alert-link ms-1">Go home</router-link>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Show",

    data() {
        return {
            user: Object,
            error: null
        }
    },

    mounted() {
        this.getUser(this.$route.params.userId)
    },

    methods: {
        getUser(userId) {
            axios.get(`/api/users/${userId}`)
                .then(res => {
                    this.user = res.data.user
                }).catch(res => {
                    this.error = res.response.data.message
            })
        }
    }
}
</script>

<style scoped>
.avatar-wrapper {
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.avatar {
    display: block;
    object-fit: cover;
    border-radius: 50%;
    width: 70px;
    height: 70px;
}

@media (min-width: 768px) {
    .avatar-wrapper {
        height: initial;
        margin-right: 24px;
    }
    .avatar {
        width: 140px;
        height: 140px;
    }
}
</style>
