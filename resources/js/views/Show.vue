<template>
    <div class="content">
<!--        <p>Hello World! {{ $route.params.id }}</p>-->
<!--        <p>{{operationId}}</p>-->

        <div class="show-news-date">
            <div class="news-back-mobile">
                <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg" v-on:click.prevent="handleBack()" class="back-button">
                    <path d="M29.1666 16.0416H11.4187L19.5708 7.88956L17.5 5.83331L5.83331 17.5L17.5 29.1666L19.5562 27.1104L11.4187 18.9583H29.1666V16.0416Z" fill="#111111"/>
                </svg>
            </div>
            <span class="card-date"> {{ showNews.public_date }} </span>
        </div>

        <div class="show-news">

            <div class="news-back-desktop">
<!--                <button ><-</button>-->
                <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg" v-on:click.prevent="handleBack()" class="back-button">
                    <path d="M29.1666 16.0416H11.4187L19.5708 7.88956L17.5 5.83331L5.83331 17.5L17.5 29.1666L19.5562 27.1104L11.4187 18.9583H29.1666V16.0416Z" fill="#111111"/>
                </svg>

            </div>

            <div class="news-content">
                <div class="news-content__first">
                    <h4 class="news-title">{{ showNews.title }}</h4>
                </div>
                <div class="news-content__second">
                    <p class="news-description" v-html="showNews.description"></p>
                    <div class="read-button">
                        <a class="btn btn-dark" :href="showNews.news_url" target="_blank" v-if="showNews.news_channel">Читать на {{ showNews.news_channel.name }}</a>
                    </div>
                </div>
                <div class="news-content__third">
                    <div class="news-gallery">
                        <img :src="'/images/news/preview/'+showNews.title_image" alt="Card image cap" class="img-fluid" v-if="showNews.title_image">
                    </div>
                </div>
            </div>
        </div>

        <div class="news-footer">
            <div class="favorites" :class="{ active: inFavorites }" @click="addFavorites">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="favorites-path" d="M14.1666 2.5H5.83329C4.91663 2.5 4.17496 3.25 4.17496 4.16667L4.16663 17.5L9.99996 15L15.8333 17.5V4.16667C15.8333 3.25 15.0833 2.5 14.1666 2.5ZM14.1666 15L9.99996 13.1833L5.83329 15V4.16667H14.1666V15Z" fill="#4D4D4D"/>
                </svg>
                В избранное
            </div>
            <div class="share">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 13.4C14.3667 13.4 13.8 13.65 13.3667 14.0416L7.425 10.5833C7.46667 10.3916 7.5 10.2 7.5 9.99996C7.5 9.79996 7.46667 9.60829 7.425 9.41663L13.3 5.99163C13.75 6.40829 14.3417 6.66663 15 6.66663C16.3833 6.66663 17.5 5.54996 17.5 4.16663C17.5 2.78329 16.3833 1.66663 15 1.66663C13.6167 1.66663 12.5 2.78329 12.5 4.16663C12.5 4.36663 12.5333 4.55829 12.575 4.74996L6.7 8.17496C6.25 7.75829 5.65833 7.49996 5 7.49996C3.61667 7.49996 2.5 8.61663 2.5 9.99996C2.5 11.3833 3.61667 12.5 5 12.5C5.65833 12.5 6.25 12.2416 6.7 11.825L12.6333 15.2916C12.5917 15.4666 12.5667 15.65 12.5667 15.8333C12.5667 17.175 13.6583 18.2666 15 18.2666C16.3417 18.2666 17.4333 17.175 17.4333 15.8333C17.4333 14.4916 16.3417 13.4 15 13.4Z" fill="#4D4D4D"/>
                </svg>
                Поделиться
            </div>
        </div>


        <!--<div class="row" v-if="$auth.check(2)">
            <div class="text-center w-100">
                <a :href="'/images/news/generated/'+showNews.generated_image" download>Скачать сгенерированную картинку</a>
            </div>
            <div class="mt-5 pb-5">
                <label>File
                    <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
                </label>
                <button class="btn btn-bold btn-success img-save" v-on:click="submitFile()">Сохранить</button>
            </div>
        </div>-->
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
