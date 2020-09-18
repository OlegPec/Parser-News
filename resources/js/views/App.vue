<template>
    <div>
        <nav class="navbar navbar-dark bg-black justify-content-center">
            <router-link :to="{ name: 'home',  params:{someUnrelatedVar: 100} }" class="navbar-brand">evolnews</router-link>
<!--            <a class="navbar-brand" href="{{ route('home') }}">evolnews</a>-->
            <div class="nav-favorite">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 18L21 19V3C21 1.9 20.1 1 19 1H8.99C7.89 1 7 1.9 7 3H17C18.1 3 19 3.9 19 5V18ZM15 5H5C3.9 5 3 5.9 3 7V23L10 20L17 23V7C17 5.9 16.1 5 15 5Z" fill="#E1E1E1"/>
                </svg>
                <router-link :to="{ name: 'favorites' }">
                    Избранное
                </router-link>
            </div>
        </nav>

<!--        <h1>Vue Router Demo App</h1>-->
        <navigationMenu></navigationMenu>



        <div class="container">

<!--            <p>-->
                <!--            <router-link :to="{ name: 'home' }">Home</router-link> |-->
<!--                <router-link to="/show/1234">Hello World</router-link>-->
<!--            </p>-->
            <router-view>

            </router-view>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import Vuex from 'vuex'
    import navigationMenu from '../components/Menu.vue'

    Vue.use(Vuex);
    // Vue.use(Vuex);
    const store = new Vuex.Store({
        state: {
            newsStor: [],
            favorites: []
        },
        mutations: {
            addNews(state, newsAdd) {
                state.newsStor = newsAdd
            },
            concatNews(state, newsAdd) {
                state.newsStor = state.newsStor.concat(newsAdd)
            },
            favoritesNews(state, newsAdd) {
                state.favorites = state.favorites.concat(newsAdd)
            },
            resetFavorites(state){
                state.favorites = []
            }
        }
    });
    export default {
        name: "App",
        props: ['news'],
        mounted() {
            store.commit('addNews', this.news)
        },
        store,
        computed: {
            getNews () {
                return store.state.newsStor
            }
        },
        components: {
            navigationMenu
        }
    }
</script>

<style scoped>
    .height-img {
        height: 240px;
    }
    .bg-black {
        background: #000;
    }
    .card a {
        color: black;
    }
    .card {
        /*height: 500px;*/
    }
    .card-deck .card {
        /*width: calc(100px - 20px) !important;*/
        /*min-width: 290px;*/
        min-width: 290px;
        /*margin-right: 15px;*/
        /*margin-left: 15px;*/
        margin-bottom: 20px;
    }
    .preloader-block.show {
        display: block;
    }
    .preloader-block.fade, .preloader-block.last {
        display: none;
    }
    .preloader {
        /*position: absolute;*/
        /*left: 0;*/
        /*top: 0;*/
        /*z-index: 999;*/
        width: 100%;
        height: 100%;
        text-align: center;
        justify-content: center;
        align-items: center;
        /*display: none;*/
    }
    /*.preloader-content > .spinner-border{*/
    /*    border: .25em solid #363a7b;*/
    /*    border-right-color: transparent;*/
    /*}*/
    .spinner-border {
        display: inline-block;
        width: 2.5rem;
        height: 2.5rem;
        vertical-align: text-bottom;
        border: .25em solid #363a7b;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner-border 0.75s linear infinite;
    }
    .preloader-block {
        /*position: relative;*/
        height: 50px;
        width: 100%;
        margin-top: -10px;
        margin-bottom: 15px;
    }
    @keyframes spinner-border {
        to {
            transform: rotate(360deg);
        }
    }
</style>
