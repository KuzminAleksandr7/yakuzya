<template>
    <h2 class="mb-5 text-muted">Registration</h2>

    <div>
        <div v-if="errors.conflict" class="alert alert-danger" role="alert">{{ errors.conflict }}!</div>

        <div class="mb-3">
            <label for="firstname" class="form-label">Firstname</label>
            <input v-model="firstname" type="text" class="form-control"
                   :class="errors.firstname ? 'is-invalid' : ''" id="firstname">
            <template v-if="errors.firstname">
                <div v-for="err in errors.firstname" class="invalid-feedback">{{ err }}</div>
            </template>
            <div v-else class="form-text">Firstname should be 2-60 characters.</div>
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Lastname</label>
            <input v-model="lastname" type="text" class="form-control"
                   :class="errors.lastname ? 'is-invalid' : ''" id="lastname">
            <template v-if="errors.lastname">
                <div v-for="err in errors.lastname" class="invalid-feedback">{{ err }}</div>
            </template>
            <div v-else class="form-text">Lastname should be 2-60 characters.</div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input v-model="email" type="email" class="form-control"
                   :class="errors.email || errors.conflict ? 'is-invalid' : ''" id="email">
            <template v-if="errors.email">
                <div v-for="err in errors.email" class="invalid-feedback">{{ err }}</div>
            </template>
            <div v-else class="form-text">Email must be a valid email according to RFC2822.</div>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input v-model="phone" type="text" class="form-control"
                   :class="errors.phone || errors.conflict ? 'is-invalid' : ''" id="phone">
            <template v-if="errors.phone">
                <div v-for="err in errors.phone" class="invalid-feedback">{{ err }}</div>
            </template>
            <div v-else class="form-text">Phone number should start with code of Ukraine +380.</div>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Photo</label>
            <input @input="photo = $event.target.files[0]" class="form-control" type="file" :class="errors.phone ? 'is-invalid' : ''" id="photo">

            <template v-if="errors.photo">
                <div v-for="err in errors.photo" class="invalid-feedback">{{ err }}</div>
            </template>
            <div v-else class="form-text">Photo should be jpg/jpeg image, with resolution at least 70x70px and size must not exceed 5MB.</div>
        </div>

        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <select id="position" v-model="position_id" class="form-select">
                <option selected>Open this select menu</option>
                <option v-for="position in positions" :value="position.id">{{ position.name }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input v-model="password" type="password" class="form-control"
                   :class="errors.password ? 'is-invalid' : ''" id="password">
            <template v-if="errors.password">
                <div v-for="err in errors.password" class="invalid-feedback">{{ err }}</div>
            </template>
            <div v-else class="form-text">Password should be at least 8 characters.</div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input v-model="password_confirmation" type="password" class="form-control" id="password_confirmation">
        </div>

        <button @click.prevent="store" type="button" class="btn btn-primary">Registration</button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Create",

    data() {
        return {
            positions: {},
            firstname: null,
            lastname: null,
            email: null,
            phone: null,
            photo: null,
            position_id: null,
            password: null,
            password_confirmation: null,
            errors: {}
        }
    },

    mounted() {
        this.getPositions()
    },
    methods: {
        store() {
            const formData = new FormData();
            formData.append('firstname', this.firstname);
            formData.append('lastname', this.lastname);
            formData.append('email', this.email);
            formData.append('phone', this.phone);
            formData.append('photo', this.photo);
            formData.append('position_id', this.position_id);
            formData.append('password', this.password);
            formData.append('password_confirmation', this.password_confirmation);

            axios.post('/api/users', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(res => {
                this.errors = {}

                this.getToken()


                if (res.data.success) {
                    this.$router.push(`/users/${res.data.user_id}`).then(() => {
                        window.location.reload();
                    });
                }
            })
                .catch(res => {
                    this.errors = {}
                    if (res.response.status === 422) {
                        this.errors = res.response.data.fails
                    }
                    if (res.response.status === 409) {
                        this.errors['conflict'] = res.response.data.message
                    }
                })
        },
        getPositions() {
            axios.get('/api/positions')
                .then( res => {
                    this.positions = res.data.positions
                })
                .catch( res => {})
        },
        getToken() {
            axios.get('/api/token')
                .then( res => {
                    localStorage.setItem('token', res.data.token);
                })
                .catch( err => {})
        }
    }
}
</script>
