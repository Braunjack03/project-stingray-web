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
                     <img class="mx-auto" :src="data.header_image" :alt="data.title">
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
        <v-row class="blogPost--block" v-if="articles.length">
         <v-col cols="12">
            <h2 class="articlesTitle">Companies</h2>
         </v-col>

          <v-col cols="12" md="12" class="pa-3 d-flex flex-column" v-for="data1 in articles" :key="data1.id">
              <v-card class="elevation-5 flex d-flex flex-column cardStyle">
                  <v-card-text class="job-card-wrap company-card-wrap">
                      <div class="company-img-block">
                        <v-img
                          :src="(data1.logo_image_url) ? data1.logo_image_url : '/images/default-logo.png'"
                        ></v-img>
                      </div>
                      <div class="company-text-block">
                      <v-card-title class="p-0">{{data1.name}}</v-card-title> 
                      <div class="text-subtitle-1"><span>{{data1.industry_types}}</span></div>
                      <p class="description">{{data1.mission}}</p>
                      </div>
                      <div class="company-jobs-block">
                      <Link :href="'/companies/'+data1.slug" color="text" class="flex justify-center items-center">View {{data1.job_posts.length}} Jobs 
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                          </svg>
                      </Link>
                      <div class="company-location" v-if="data1.city">
                          <p><span>{{data1.city}}, {{data1.state}}</span> Location</p>
                      </div>
                      </div>
                      <Link :href="'/companies/'+data1.slug" class="overlayLink"></Link>
                  </v-card-text>
              </v-card>
          </v-col>
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
    articles: Array,
  }, 
};
</script>
