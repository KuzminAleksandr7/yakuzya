<template>
    <h2 class="mb-5 text-muted">Positions</h2>

    <div>
        <table v-if="!error" class="table table-sm mb-4">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Position</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="position in positions">
                <th scope="row">{{ position.id }}</th>
                <td>{{ position.name }}</td>
            </tr>
            </tbody>
        </table>
        <div v-else class="alert alert-secondary" role="alert">{{ error }}!
            <router-link :to="{ name: 'home' }" class="alert-link ms-1">Go home</router-link>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Index",

    data() {
        return {
            positions: null,
            error: null,
        }
    },

    mounted() {
        this.getPositions()
    },

    methods: {
        getPositions() {
            axios.get('/api/positions')
                .then(res => {
                    this.positions = res.data.positions
                }).catch(res => {
                    this.error = res.response.data.message
            })
        }
    }
}
</script>

<style scoped>

</style>
