<template>
    <div class="content">
        <div v-infinite-scroll="loadMore"
             infinite-scroll-disabled="busy"
             infinite-scroll-distance="10"
             infinite-scroll-immediate-check="true" class="card">
            <div class="card-item" v-for="element in getNews">
<!--                        <a :href="/show/+element.id">-->
                <router-link :to="'/show/'+element.id">
                    <img :src="getImgUrl(element.title_image)" alt="Card image cap" class="card-img-top img-fluid" v-if="element.title_image">
                    <img src="/images/news/default_img.svg" alt="Card image cap" class="card-img-top img-fluid" v-if="!element.title_image" style="margin-left: -22%;">
                </router-link>
<!--                        </a>-->
                <div class="card-body">
                    <small class="card-date">{{ element.public_date }}</small>
<!--                            <a href="{{ route('showNews', $element->id) }}">-->
<!--                                <h5 class="card-title">{!! $element->title !!}</h5>-->
<!--                                <p class="card-text">{!! rtrim(mb_strimwidth($element->description, 0, 252))."..." !!}</p>-->
<!--                            </a>-->
<!--                            <a :href="/show/+element.id">-->
                    <router-link :to="'/show/'+element.id">
                        <h5 class="card-title" v-html="element.title"></h5>
                        <p class="card-text" v-html="getDescription(element.description)"></p>
                    </router-link>
<!--                            </a>-->
                </div>
                <!--<div class="card-footer">
                    <small class="text-muted">{{ element.public_date }}</small>
                </div>-->
            </div>
            <div class="preloader-block" :class="{'show': preloader, 'fade': !preloader, 'last': endNews}">
                <div class="preloader">
                    <div class="preloader-content">
                        <div class="spinner-border" role="status">

                        </div>
<!--                                <p>Загрузка...</p>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import image from '../images/news/preview';
    import axios from 'axios';
    // var count = 0;
    export default {
        name: "CardNews.vue",
        props: [
            // 'news',
        ],
        // store,
        data() {
            return {
                page: 1,
                // newsList: this.news,
                // newsList: this.getNewsTest(),
                preloader: false,
                endNews: false,
                // image
                // busy: false
            }
        },
        methods: {
            loadMore: function() {
                this.preloader = true;
                axios.get('/get-news?page='+this.page, {
                    // _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    // page: this.page
                })
                    .then(response => {
                        // console.log(response.data);
                        if(response.data.success) {
                            this.preloader = false;
                            if(response.data.result.length === 0){
                                this.endNews = true;
                            }
                            this.page++;


                            // this.newsList = this.newsList.concat(response.data.result);
                            this.$store.commit('concatNews', response.data.result)

                            // console.log(this.newsList);
                            // console.log(this.page)
                            // this.isOpen = !this.isOpen;
                            // this.isEditCategory = false;
                        }
                    });
                // console.log('load')
                // console.log(1)
                // this.busy = true;

                /*setTimeout(() => {
                    for (var i = 0, j = 10; i < j; i++) {
                        this.data.push({ name: count++ });
                    }
                    this.busy = false;
                    console.log(count)
                }, 1000);*/
            },
            getImgUrl(pic) {
                return '../images/news/preview/'+pic;
            },
            getDescription(desc){
                // var sliced = desc.slice(0,250);
                var sliced = desc.slice(0,150);
                if (sliced.length < desc.length) {
                    sliced = sliced.trim();
                    sliced += '...';
                }
                return sliced;
                // {!! rtrim(mb_strimwidth($element->description, 0, 252))."..." !!}
            },
            getNewsTest() {
                return this.$store.state.newsStor;
            }
        },
        mounted() {
            console.log('Component mounted.');

        },
        computed: {
            getNews(){
                return this.$store.state.newsStor
            },
            classObject(id) {
                // let items = [1];
                // let item = items[Math.floor(Math.random() * items.length)];
                // console.log(item);
                let test = id % 2 === 1;
                return {
                    'flex-grow-1': true,
                    'flex-grow-2': test
                }
            }
        }
    }
</script>
<!--<style scoped>
    .flex-grow-1 {
        flex-grow: 1;
    }
    .flex-grow-2 {
        flex-grow: 2;
    }
</style>-->
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
