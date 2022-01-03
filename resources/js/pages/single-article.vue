<template>
    <Layout>
        <Head>
            <title>Made in Tampa - {{data.title}}</title>
            <meta name="description" :content="data.title">
            <meta property="og:title" :content="data.title" />
            <meta property="og:type" content="jobs" />
            <meta property="og:url" :content="base_url+'/articles/'+data.slug" />
            <meta property="og:image" :content="data.header_image" />
            <meta property="og:description" :content="data.title">
            <meta property="og:site_name" content="Made in Tampa">
            <meta name="twitter:image:alt" content="Made in Tampa">
        </Head>
        <section class="relative singleArticles--outer" data-app>
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 md:py-20 relative">
                <v-row class="blogPost--block singlePage--articles justify-center mt-8">
                    <v-col cols="12" md="9">
                        <div class="postBlock">
                            <div class="postBlock--content">
                                <h3 class="postBlock--title text-center md:text-left">{{data.title}}</h3>
                                <p class="text-center md:text-left">{{data.sub_title}}</p>
                                <div class="postPersonal--detail justify-between mobileJustify">
                                    <div class="flex items-center">
                                        <img src="/images/news-author-01.jpg" alt="post-images">
                                        <p><a href="#">{{data.author_name}} </a> - {{new Date(data.publish_date).toDateString().slice(4,10)+','+new Date(data.publish_date).toDateString().slice(10)}}</p>
                                    </div>
                                    <div class="mt-4 md:mt-0">
                                        <button class="text-white rounded-full" :class="'bg-'+tag.color+'-500'" v-for="tag in data.tags" :key="tag.id">
                                        {{tag.name}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-col>
                    <v-col cols="12" md="12">
                        <div class="postBlock">
                            <div class="postSingle--img">
                                <img class="mx-auto" :src="data.header_image + '?tr=w-1024,h-567'" :alt="data.title">
                            </div>
                        </div>
                    </v-col>
                </v-row>
    
                <v-row class="blogPost--block mb-0 md:mb-6 singlePage--content justify-center">
                    <v-col cols="12" md="9">
                        <div class="postBlock--content">
                            <p><span v-html="data.content"></span></p>
                        </div>
                    </v-col>
                </v-row>
                <v-row class="blogPost--block" v-if="articles && articles.data.length > 0">
                    <v-col cols="12">
                        <h2 class="articlesTitle">Companies Mentioned in the Article</h2>
                    </v-col>
                    <CustomCard v-for="data in articles.data" :key="data.id" :data="data"/>
                </v-row>
            </div>
    
        </section>
    </Layout>
</template>

<script>
import { Link, Head } from "@inertiajs/inertia-vue";
import Company from '../components/Company.vue';
import Layout from "./Layout";
export default {
    components: {
        Link,
        Layout,
        'CustomCard': Company,
        Head,
    },
    props: {
        errors: Object,
        success: Object,
        data: Object,
        articles: Object,
    },
    data() {
        return {
            base_url: window.location.origin,
        };
    },
};
</script>
