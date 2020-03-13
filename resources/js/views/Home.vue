<template>
    <div>
        <CardNews :news="news"></CardNews>
<!--        {{someUnrelatedVar}}-->
    </div>
</template>

<script>
    import CardNews from '../components/NewsHomeComponent';
    export default {
        name: "Home",
        props: ['news'],
        components: {
            CardNews
        }
    }
</script>

<style scoped>

</style>
