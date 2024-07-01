<template>
    <div>
        <div class="alert alert-info" role="alert">Not found!
            <router-link :to="{ name: 'home' }" class="alert-link ms-1">Go home</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotFound"
}
</script>

<style scoped>

</style>
