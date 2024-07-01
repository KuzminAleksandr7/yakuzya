<template>
    <h2 class="mb-5 text-muted">Users</h2>

    <div v-if="!error">
        <div class="table-responsive mb-4">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Position</th>
                    <th scope="col">Registered</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users">
                    <th scope="row">{{ user.id }}</th>
                    <td>
                        <img :src="user.photo === null ? '/assets/images/no_avatar.png' : user.photo" class="avatar">
                    </td>
                    <td>
                        <router-link :to="{ name: 'user.show', params: { userId: user.id } }" class="link">
                            {{ user.firstname }} {{ user.lastname }}
                        </router-link>
                    </td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone }}</td>
                    <td>{{ user.position }}</td>
                    <td>{{ this.formatUnixTime(user.registration_timestamp) }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            <div v-if="links" class="btn-group" role="group" aria-label="Basic example">
                <button @click="prevPage" :disabled="!links.prev_url" class="btn btn-dark">Previous</button>
                <button @click="nextPage" :disabled="!links.next_url" class="btn btn-dark">Next</button>
            </div>
        </div>
    </div>
    <div v-else class="alert alert-warning" role="alert">{{ error }}!
        <router-link :to="{ name: 'home' }" class="alert-link ms-1">Go home</router-link>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Index",

    data() {
        return {
            users: null,
            error: null,
            count: null,
            links: null,
            page: null,
            total_pages: null,
            total_users: null
        }
    },

    mounted() {
        this.getUsers()
    },
    watch: {
        '$route.query.page': 'getUsers'
    },
    methods: {
        getUsers() {
            const page = this.$route.query.page || 1;
            const count = this.$route.query.count || 6;

            axios.get(`/api/users?page=${page}&count=${count}`)
                .then(res => {
                    this.users = res.data.users
                    this.count = res.data.count
                    this.links = res.data.links
                    this.page = res.data.page
                    this.total_pages = res.data.total_pages
                    this.total_users = res.data.total_users
                }).catch(err => {
                    if (err.response.status == 401) {
                        this.$router.push({ name: 'user.create'});
                    }

                    this.error = err.response.data.message
            })
        },

        nextPage() {
            if (this.links.next_url) {
                const nextPage = this.page + 1;
                this.$router.push({query: {page: nextPage, count: 6}});
            }
        },

        prevPage() {
            if (this.links.prev_url) {
                const nextPage = this.page - 1;
                this.$router.push({query: {page: nextPage, count: 6}});
            }
        },

        formatUnixTime(unixTime) {
            const date = new Date(unixTime * 1000)
            const day = String(date.getDate()).padStart(2, '0')
            const month = String(date.getMonth() + 1).padStart(2, '0')
            const year = date.getFullYear()
            return `${day}-${month}-${year}`
        }
    }
}
</script>

<style scoped>
.avatar {
    display: block;
    object-fit: cover;
    border-radius: 50%;
    width: 48px;
    height: 48px;
}
</style>
