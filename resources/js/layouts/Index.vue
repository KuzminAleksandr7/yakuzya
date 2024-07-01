<template>
    <header class="custom-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <router-link :to="{ name: 'home' }" class="custom-logo ff-work">Yakuzya.space</router-link>

                <div class="d-none d-md-block">
                    <router-link :to="{ name: 'user.index' }" class="me-3 custom-link">Users</router-link>
                    <router-link :to="{ name: 'positions.index' }" class="me-3 custom-link">Positions</router-link>
                    <router-link v-if="!token" :to="{ name: 'user.create' }" class="me-3 custom-link">Registration</router-link>
                    <a v-if="token" @click.prevent="logout" class="custom-link cursor-pointer">Logout</a>
                </div>
                <div class="d-block d-md-none"
                     data-bs-toggle="collapse"
                     data-bs-target="#bar"
                     aria-controls="bar"
                     aria-expanded="false">
                    <svg class="custom-bar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
                </div>

            </div>
        </div>
    </header>
    <div class="collapse custom-menu-wrapper" id="bar">
        <div class="container">
            <div class="row">
                <ul class="list-group list-group-flush custom-menu-list p-0">
                    <li class="list-group-item text-end">
                        <router-link :to="{ name: 'user.index' }" class="custom-link">Users</router-link>
                    </li>
                    <li class="list-group-item text-end">
                        <router-link :to="{ name: 'positions.index' }" class="custom-link">Positions</router-link>
                    </li>
                    <li class="list-group-item text-end">
                        <router-link v-if="!token" :to="{ name: 'user.create' }" class="custom-link">Registration</router-link>
                    </li>
                    <li class="list-group-item text-end">
                        <a v-if="token" @click.prevent="logout" class="custom-link cursor-pointer">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="custom-content mt-4">
        <div class="container">
            <div class="row">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Index",

    data() {
        return {
            token: null
        }
    },

    mounted() {
        this.getToken()
    },

    watch() {
        console.log(123);
    },

    methods: {
        getToken() {
            this.token = localStorage.getItem('token')
        },
        logout() {
            axios.post('/logout').then( res => {
                if (localStorage.getItem('token')) {
                    localStorage.removeItem('token')
                    this.token = null

                    this.$router.push('/')
                }
            })
        }
    }
}
</script>

<style scoped>
.custom-header {
    background-color: #161616;
    height: 80px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 5;
    display: flex;
    align-items: center;
}

.custom-logo {
    color: #ffffff;
    text-decoration: none;
    font-size: 20px;
    font-family: "Work Sans", sans-serif;
}

.custom-menu-wrapper {
    background-color: #161616;
    position: relative;
    top: 80px;
}
.custom-menu-list {
    background-color: #161616;
}
.custom-menu-list li {
    background-color: #161616;
    border-color: #1a202c;
}

.custom-content {
    position: relative;
    top: 80px;
    margin-bottom: 180px;
}

.custom-bar {
    fill: #ffffff;
    width: 24px;
    height: 24px;
}
.custom-link {
    position: relative;
    text-decoration: none;
    color: #c0c0c0;
    cursor: pointer;
}
.custom-link:not(.router-link-active):hover {
    color: #ffffff;
}
.router-link-active {
    color: #ffffff;
}
.router-link-active::after, .custom-link:hover::after {
    content: "";
    position: absolute;
    bottom: -2px;
    left: 0;
    height: 2px;
    width: 100%;
}
.custom-link:not(.router-link-active):hover::after {
    background-color: #0d6efd;
}
.router-link-active:not(.custom-logo)::after {
    background-color: #fd790d;
}
</style>
