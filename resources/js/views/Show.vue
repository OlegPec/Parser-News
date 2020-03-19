<template>
    <div>
<!--        <p>Hello World! {{ $route.params.id }}</p>-->
<!--        <p>{{operationId}}</p>-->

        <div class="row mt-3 pb-3">
            <div class="col-12">
                <h4><button v-on:click.prevent="handleBack()"><-</button> {{ showNews.title }}</h4>
                <p class="text-center">
<!--                    @if($news->title_image)-->
                    <img :src="'/images/news/preview/'+showNews.title_image" alt="Card image cap" class="img-fluid" v-if="showNews.title_image">
<!--                    @endif-->
                </p>
                <p v-html="showNews.description"></p>
                <a class="btn btn-dark bg-black w-100" :href="showNews.news_url" target="_blank" v-if="showNews.news_channel">Читать на {{ showNews.news_channel.name }}</a>
<!--                @if(Auth::user())-->
<!--                <div class="d-flex justify-content-center">-->
<!--                    <a href="{{ asset('images/news/generated/'.$news->generated_image) }}" download>Скачать сгенерированную картинку</a>-->
<!--                </div>-->
<!--                <div class="mt-5 pb-5">-->
<!--                    <form action="{{ route('uploadNewsImg', $news->id) }}" method="POST" enctype="multipart/form-data">-->
<!--                        @csrf-->
<!--                        <input type="file" name="image" id="upload">-->
<!--                        <button class="btn btn-bold btn-success img-save" type="submit">Сохранить</button>-->
<!--                    </form>-->
<!--                </div>-->
<!--                @endif-->
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Show",
        data() {
            return {
                'showNews': [],
                'newsId': this.$route.params.id,
                'test': true
            }
        },
        created() {
            this.showCurrentNews();
        },
        methods: {
            handleBack() {
                this.$router.back();
            },
            showCurrentNews() {
                axios.post('/news/'+this.newsId, {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                })
                    .then(response => {
                        // console.log(response.data);
                        if(response.data.success) {
                            // this.messages = response.data.messages;
                            // this.auth_id = response.data.auth_id;
                            // this.isOpen = response.data.open;
                            // this.preloader = false;
                            // this.$emit('readTicket');
                            // this.isEditCategory = false;
                            // this.showNews = response.data.result;
                            this.showNews = Object.assign({}, this.showNews, response.data.result)
                        }else {
                            this.showNews = null;
                        }
                        // let messBlock = document.querySelector('.message-box');
                        // Vue.nextTick()
                        //     .then(function () {
                        //         messBlock.scrollTop = messBlock.scrollHeight;
                        //     });
                    });
            }
        },
        computed: {

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
    #upload {
        /*display: none*/
    }
</style>
