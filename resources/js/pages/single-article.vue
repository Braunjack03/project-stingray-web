<template>
  <Layout>
    <Head :title="'Articles'" />
    <section class="relative singleArticles--outer" data-app>
      <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 md:py-20 relative">
        <v-row class="blogPost--block singlePage--articles justify-center mt-8">
           <v-col cols="12" md="9">
              <div class="postBlock">
                 <div class="postBlock--content">
                     <h3 class="postBlock--title text-center lg:text-left">{{data.title}}</h3>
                     <p class="text-center lg:text-left">{{data.sub_title}}</p>
                     <div class="postPersonal--detail justify-between mobileJustify">
                      <div class="flex items-center">
                        <img src="/images/news-author-01.jpg" alt="post-images">
                        <p><a href="#">{{data.name}} </a> - {{new Date(data.created_at).toDateString().slice(4,10)+','+new Date(data.created_at).toDateString().slice(10)}}</p>
                      </div>
                      <div class="mt-4 lg:mt-0">
                        <button class="text-white rounded-full" :class="tag.name.toLowerCase()+'Btn'" v-for="tag in data.tags" :key="tag.id">
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
                     <img :src="data.header_image" :alt="data.title">
                 </div>
              </div>
           </v-col>
        </v-row>

        <v-row class="blogPost--block mb-0 md:mb-6 singlePage--content justify-center">
           <v-col cols="12" md="9">
              <div class="postBlock--content">
                  {{data.content}}
              </div>
           </v-col>
        </v-row>

        <v-row class="blogPost--block">
         <v-col cols="12">
            <h2 class="articlesTitle">More from Open PRO</h2>
         </v-col>
          <CustomCard v-for="data1 in articles" :key="data1.id" :data="data1"/>
        </v-row>
      </div>

    </section>
  </Layout>
</template>
<script>
import { Link, Head } from "@inertiajs/inertia-vue";
import Article from '../components/Article.vue';
import Pagination from '../components/CompanyPagination.vue';
import Layout from "./Layout";
export default {
  components: {
    Link,
    Layout,
    'CustomCard': Article,
    Pagination,
    Head,
  },
  props: {
    errors: Object,
    success: Object,
    data: Object,
    articles: Array,
  }, 
};
</script>
