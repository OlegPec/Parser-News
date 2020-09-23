<template>
<!--    <div>-->
        <CardNews></CardNews>
<!--        {{someUnrelatedVar}}-->
<!--    </div>-->
</template>

<script>
    import CardNews from '../components/NewsHomeComponent';
    export default {
        name: "Home",
        // props: ['news'],
        // data() {
        //     return {
        //         getNews: []
        //     }
        // },
        // mounted() {
            // this.getNews = this.$store.state.newsStor;
        // },
        // computed: {
            // getNewsMethod () {
            //     return store.state.newsStor
            // }
        // },
        components: {
            CardNews
        }
    }
</script>

<style scoped>

</style>
