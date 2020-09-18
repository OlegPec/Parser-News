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
        <div class="row">
            <div class="col-12">
                <div class="favorites" :class="{ active: inFavorites }" @click="addFavorites">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="favorites-path" d="M14.1666 2.5H5.83329C4.91663 2.5 4.17496 3.25 4.17496 4.16667L4.16663 17.5L9.99996 15L15.8333 17.5V4.16667C15.8333 3.25 15.0833 2.5 14.1666 2.5ZM14.1666 15L9.99996 13.1833L5.83329 15V4.16667H14.1666V15Z" fill="#4D4D4D"/>
                    </svg>
                    В избранное
                </div>
            </div>
        </div>
        <div class="row" v-if="$auth.check(2)">
            <div class="text-center w-100">
                <a :href="'/images/news/generated/'+showNews.generated_image" download>Скачать сгенерированную картинку</a>
            </div>
            <div class="mt-5 pb-5">
<!--                <form action="{{ route('uploadNewsImg', $news->id) }}" method="POST" enctype="multipart/form-data">-->

                <label>File
                    <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
                </label>
                <button class="btn btn-bold btn-success img-save" v-on:click="submitFile()">Сохранить</button>
<!--                    <input type="file" name="image" id="upload">-->
<!--                    <button class="btn btn-bold btn-success img-save" type="submit">Сохранить</button>-->
<!--                </form>-->
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
                showNews: [],
                newsId: this.$route.params.id,
                test: true,
                file: '',
                inFavorites: false
            }
        },
        created() {
            this.showCurrentNews();
        },
        mounted() {
        },
        methods: {
            handleBack() {
                this.$router.back();
            },
            showCurrentNews() {
                axios.get('/news/'+this.newsId, {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                })
                    .then(response => {
                        // console.log(response.data);
                        if(response.data.data) {
                            // this.messages = response.data.messages;
                            // this.auth_id = response.data.auth_id;
                            // this.isOpen = response.data.open;
                            // this.preloader = false;
                            // this.$emit('readTicket');
                            // this.isEditCategory = false;
                            // this.showNews = response.data.result;
                            this.showNews = Object.assign({}, this.showNews, response.data.data)
                            this.inFavorites = this.showNews.in_favorites
                        }else {
                            this.showNews = null;
                        }
                        // let messBlock = document.querySelector('.message-box');
                        // Vue.nextTick()
                        //     .then(function () {
                        //         messBlock.scrollTop = messBlock.scrollHeight;
                        //     });
                    });
            },
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            submitFile() {
                let formData = new FormData();
                formData.append('image', this.file);
                axios.post( '/uploadImg/'+this.showNews.id,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then((response) => {
                    this.showNews.title_image = response.data.title_image;
                    this.showNews.generated_image = response.data.generated_image;
                })
                .catch(function(){

                });
            },
            addFavorites() {
                let data = JSON.stringify({'news_id': this.showNews.id})
                axios.post('favorites', data, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then((response) => {
                    // console.log(response.data.method)
                    this.inFavorites = response.data.method === 'attached';
                })
                .catch(function(){

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
