<template>
  <Layout>
    <Head>
      <title>Made in Tampa - {{ data.title }}</title>
    </Head>
    <section class="relative singleArticles--outer" data-app>
      <div class="relative max-w-6xl px-4 py-10 mx-auto sm:px-6 md:py-20">
        <v-row class="justify-center mt-8 blogPost--block singlePage--articles">
          <v-col cols="12" md="9">
            <div class="postBlock">
              <div class="postBlock--content">
                <h3 class="text-center postBlock--title md:text-left">
                  {{ data.title }}
                </h3>
                <p class="text-center md:text-left">
                  {{ data.sub_title }}
                </p>
                <div class="justify-between postPersonal--detail mobileJustify">
                  <div class="flex items-center">
                    <img src="/images/news-author-01.png" alt="post-images" />
                    <p>
                      By: {{ data.author_name }} 
                    </p>
                  </div>
                  <div class="mt-4 md:mt-0">
                    <button
                      v-for="tag in data.tags"
                      :key="tag.id"
                      class="text-white rounded-full"
                      :class="'bg-' + tag.color + '-500'"
                    >
                      {{ tag.name }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </v-col>
          <v-col cols="12" md="12">
            <div class="postBlock">
              <div class="postSingle--img">
                <img
                  class="mx-auto"
                  :src="data.header_image + '?tr=w-1024,h-567'"
                  :alt="data.title"
                />
              </div>
            </div>
          </v-col>
        </v-row>

        <v-row class="justify-center mb-0 blogPost--block md:mb-6 singlePage--content">
          <v-col cols="12" md="9">
            <div class="postBlock--content">
              <p><span v-html="data.content" /></p>
            </div>
          </v-col>
        </v-row>
        <v-row v-if="articles && articles.data.length > 0" class="blogPost--block">
          <v-col cols="12">
            <h2 class="articlesTitle">Companies Mentioned in the Article</h2>
          </v-col>
          <CustomCard v-for="data in articles.data" :key="data.id" :data="data" />
        </v-row>
      </div>
    </section>
  </Layout>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue";
import Company from "../components/Company.vue";
import Layout from "./Layout.vue";

export default {
  name: "ArticleItem",
  // child
  metaInfo() {
    return {
      title: `Made in Tampa - Article`,
      meta: [
        {  
          name: 'description',
          content: 'Made in Tampa',
        },
        {  
          property: 'og:title',
          content: this.data.title,
        },
        {  
          property: 'og:type',
          content: 'article',
        },
        {  
          property: 'og:image',
          content: this.data.header_image,
        },
        {  
          property: 'og:url',
          content: this.base_url+'/articles/'+this.data.slug,
        },
        {  
          property: 'twitter:card',
          content: this.data.header_image,
        },
        {  
          name: 'og:description',
          content: this.data.sub_title,
        },
        {  
          name: 'og:site_name',
          content: 'Made in Tampa',
        },
      ]
    }
  },
  components: {
    Layout,
    CustomCard: Company,
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
      // eslint-disable-next-line camelcase
      base_url: window.location.origin,
    };
  },
};
</script>
