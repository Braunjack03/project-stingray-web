<template>
   <Layout>
            <section data-app>
               <div class="relative max-w-6xl px-4 py-10 mx-auto sm:px-6 md:py-20">
                  <v-row>
                     <v-col cols="12" md="8">
                        <div class="pt-16 pb-2 md:pb-8 company-page-title">
                           <h1 class="text-center text-gray-700 h1 md:text-left">The Latest Tampa Bay Technology and Start-up News</h1>
                        </div>
                     </v-col>
                  </v-row>

                  <v-row class="items-center mb-0 blogPost--block blogPostTop--block md:mb-6">
                     <v-col cols="12" md="6">
                        <div class="postBlock">
                           <div class="postBlock--img">
                               <Link :href="'/articles/'+latest.slug"><img :src="latest.header_image + '?tr=w-700,h-410'" :alt="latest.title"></Link>
                               <div class="imgShadow"></div>
                           </div>
                        </div>
                     </v-col>
                     <v-col cols="12" md="6">
                        <div class="postBlock">
                           <div class="postBlock--content">
                              <button class="text-white rounded-full" :class="'bg-'+tag.color+'-500'" v-for="tag in latest.tags" :key="tag.id">
                                 {{tag.name}}
                               </button>
                               <h3 class="postBlock--title"><Link :href="'/articles/'+latest.slug">{{latest.title}}</Link></h3>
                               <p>{{latest.content.substring(0,255) | stripHTML}}</p>
                               <div class="postPersonal--detail">
                                  <img src="/images/news-author-01.png" alt="post-images">
                                  <p>By: {{latest.author_name}}</p>
                               </div>
                           </div>
                        </div>
                     </v-col>
                  </v-row>
                  <v-row class="blogPost--block" >
                     <v-col cols="12">
                        <h2 class="articlesTitle">Latest articles</h2>
                     </v-col>
                        <CustomCard v-for="data in articles.data" :key="data.id" :data="data"/>
                  </v-row>
                  <pagination class="mt-5" :links="articles.links" />
               </div>
            </section>
   </Layout>   
</template>

<script>
import Article from '../components/Article.vue';
import Layout from './Layout';
import { Head,Link } from '@inertiajs/inertia-vue';
import Pagination from '../components/CompanyPagination.vue';
import Footer from '../partials/Footer.vue';
import { validationMixin } from 'vuelidate'
import { required} from 'vuelidate/lib/validators'

export default {
   name: "ArticleItems",
   metaInfo: {
      title: "News",
      titleTemplate: "%s - Made in Tampa",
      meta: [
         { name: 'description', content: 'Made in Tampa News' },
      ]
   },
     mixins: [validationMixin],
     validations: {
      term: { required },
    },
   components: {
      Head,
      Layout,
      Link,
      'CustomCard': Article,
      Pagination,
      Footer,
   },
   props: {
      latest: Object,
      articles : Object,
    },
    data () {
      return {
        location_id: '',
      }
    },
     methods: {

       setDateFormat(dateObject) {
            var d = new Date(dateObject);
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
            day = "0" + day;
            }
            if (month < 10) {
            month = "0" + month;
            }
            var date = month + "/" + day + "/" + year;

            return date;
         },
      setDateFomat(date) 
         {
            return date.toLocaleDateString("en-US", { weekday: 'long', year: 'numeric', month: 'long'})
         },
    }
}
</script>
