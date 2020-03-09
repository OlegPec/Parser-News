<template>
    <div class="container">
        <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="10">
            <div class="card-deck mt-5">
                <div class="row">
                    <div class="card" v-for="element in newsList">
                        <a :href="/show/+element.id">
                            <img :src="getImgUrl(element.title_image)" alt="Card image cap" class="card-img-top img-fluid" v-if="element.title_image">
                        </a>
                        <div class="card-body">
<!--                            <a href="{{ route('showNews', $element->id) }}">-->
<!--                                <h5 class="card-title">{!! $element->title !!}</h5>-->
<!--                                <p class="card-text">{!! rtrim(mb_strimwidth($element->description, 0, 252))."..." !!}</p>-->
<!--                            </a>-->
                            <a :href="/show/+element.id">
                                <h5 class="card-title" v-html="element.title"></h5>
                                <p class="card-text" v-html="getDescription(element.description)"></p>
                            </a>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">{{ element.public_date }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import image from '../images/news/preview';
    // var count = 0;
    export default {
        props: [
            'news',
        ],
        data() {
            return {
                page: 1,
                newsList: this.news,
                // image
                // busy: false
            }
        },
        methods: {
            loadMore: function() {
                axios.get('/get-news?page='+this.page, {
                    // _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    // page: this.page
                })
                    .then(response => {
                        // console.log(response.data);
                        if(response.data.success) {
                            this.page++;
                            this.newsList = this.newsList.concat(response.data.result);
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
                var sliced = desc.slice(0,250);
                if (sliced.length < desc.length) {
                    sliced = sliced.trim();
                    sliced += '...';
                }
                return sliced;
                // {!! rtrim(mb_strimwidth($element->description, 0, 252))."..." !!}
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
