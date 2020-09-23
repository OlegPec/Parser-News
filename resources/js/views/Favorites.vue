<template>
    <div class="content">
        <div v-infinite-scroll="loadMore"
             infinite-scroll-disabled="busy"
             infinite-scroll-distance="10"
             infinite-scroll-immediate-check="true" class="card">
            <div class="card-item" v-for="element in getNews">
                <router-link :to="'/show/'+element.id">
                    <img :src="getImgUrl(element.title_image)" alt="Card image cap" class="card-img-top img-fluid" v-if="element.title_image">
                    <img src="/images/news/default_img.svg" alt="Card image cap" class="card-img-top img-fluid" v-if="!element.title_image" style="margin-left: -22%;">
                </router-link>
                <div class="card-body">
                    <small class="card-date">{{ element.public_date }}</small>
                    <router-link :to="'/show/'+element.id">
                        <h5 class="card-title" v-html="element.title"></h5>
                        <p class="card-text" v-html="getDescription(element.description)"></p>
                    </router-link>
                </div>
            </div>
            <div class="preloader-block" :class="{'show': preloader, 'fade': !preloader, 'last': endNews}">
                <div class="preloader">
                    <div class="preloader-content">
                        <div class="spinner-border" role="status">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                page: 2,
                preloader: false,
                endNews: false,
                newsList: [],
            }
        },
        created() {
            this.$store.commit('resetFavorites', {})
        },
        mounted() {
            this.getFavorites();
        },
        methods: {
            loadMore() {
                this.preloader = true;
                axios.get('/favorites?page='+this.page, {})
                .then(response => {
                    if(response.data.data.length !== 0) {
                        this.preloader = false;

                        this.page++;
                        this.$store.commit('favoritesNews', response.data.data)
                    }else {
                        this.endNews = true;
                    }
                });
            },
            getImgUrl(pic) {
                return '../images/news/preview/'+pic;
            },
            getDescription(desc){
                var sliced = desc.slice(0,150);
                if (sliced.length < desc.length) {
                    sliced = sliced.trim();
                    sliced += '...';
                }
                return sliced;
            },
            getFavorites() {
                axios.get('/favorites/', {})
                .then(response => {
                    if(response.data.data.length !== 0) {
                        // this.newsList = Object.assign({}, this.newsList, response.data.data)
                        this.$store.commit('favoritesNews', response.data.data)
                    }else {
                        this.$store.commit('favoritesNews', null)
                    }
                });
            }
        },
        computed: {
            getNews(){
                return this.$store.state.favorites
            },
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

</style>
