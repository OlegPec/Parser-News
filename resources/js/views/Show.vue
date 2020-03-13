<template>
    <div>
        <p>Hello World! {{ $route.params.id }}</p>
        <button v-on:click.prevent="handleBack()">Назад</button>
    </div>
</template>

<script>
    export default {
        name: "Show",
        data() {
            return {
                'test': true
            }
        },
        methods: {
            handleBack() {
                this.$router.back();
            }
        }
    }
</script>

<style scoped>

</style>
