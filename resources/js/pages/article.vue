<template>
   <Layout>
      <Head title="Articles" /> 
            <section data-app>
               <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 md:py-20 relative">
                  <v-row>
                     <v-col cols="12" md="8">
                        <div class="pt-16 pb-2 md:pb-8 company-page-title">
                           <h1 class="h1 text-gray-700 text-center md:text-left">Refreshing news for developers and designers</h1>
                        </div>
                     </v-col>
                  </v-row>

                  <v-row class="blogPost--block blogPostTop--block mb-0 md:mb-6 items-center">
                     <v-col cols="12" md="6">
                        <div class="postBlock">
                           <div class="postBlock--img">
                               <img src="/images/blog-post-01.jpg" alt="post-images">
                               <div class="imgShadow"></div>
                           </div>
                        </div>
                     </v-col>
                     <v-col cols="12" md="6">
                        <div class="postBlock">
                           <div class="postBlock--content">
                               <button class="text-white rounded-full">
                                 Product
                               </button>
                               <button class="text-white rounded-full engineeringBtn">
                                 Engineering
                               </button>
                               <h3 class="postBlock--title"><a href="#">The quick brown fox jumped over the lazy dog.</a></h3>
                               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                               <div class="postPersonal--detail">
                                  <img src="/images/news-author-01.jpg" alt="post-images">
                                  <p><a href="#">Anastasia Dan </a> - Jan 17, 2020</p>
                               </div>
                           </div>
                        </div>
                     </v-col>
                  </v-row>
                  <v-row class="blogPost--block">
                     <v-col cols="12">
                        <h2 class="articlesTitle">Latest articles</h2>
                     </v-col>
                     <v-col cols="12" md="4" sm="6">
                        <div class="postBlock">
                           <div class="postBlock--img">
                               <img src="/images/news-01.jpg" alt="post-images">
                           </div>
                           <div class="postBlock--content">
                               <button class="text-white rounded-full">
                                 Product
                               </button>
                               <button class="text-white rounded-full engineeringBtn">
                                 Engineering
                               </button>
                               <h3 class="postBlock--title"><a href="#">The quick brown fox jumped over the lazy dog.</a></h3>
                               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                               <div class="postPersonal--detail">
                                  <img src="/images/news-author-01.jpg" alt="post-images">
                                  <p><a href="#">Anastasia Dan </a> - Jan 17, 2020</p>
                               </div>
                           </div>
                          </div>
                      </v-col>
                      <v-col cols="12" md="4" sm="6">
                        <div class="postBlock">
                           <div class="postBlock--img">
                               <img src="/images/news-01.jpg" alt="post-images">
                           </div>
                           <div class="postBlock--content">
                               <button class="text-white rounded-full">
                                 Product
                               </button>
                               <button class="text-white rounded-full desingBtn">
                                 Desing
                               </button>
                               <h3 class="postBlock--title"><a href="#">The quick brown fox jumped over the lazy dog.</a></h3>
                               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                               <div class="postPersonal--detail">
                                  <img src="/images/news-author-01.jpg" alt="post-images">
                                  <p><a href="#">Anastasia Dan </a> - Jan 17, 2020</p>
                               </div>
                           </div>
                          </div>
                      </v-col>
                      <v-col cols="12" md="4" sm="6">
                        <div class="postBlock">
                           <div class="postBlock--img">
                               <img src="/images/news-01.jpg" alt="post-images">
                           </div>
                           <div class="postBlock--content">
                               <button class="text-white rounded-full">
                                 Product
                               </button>
                               <button class="text-white rounded-full tutorialsBtn">
                                 Tutorials and articles
                               </button>
                               <h3 class="postBlock--title"><a href="#">The quick brown fox jumped over the lazy dog.</a></h3>
                               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                               <div class="postPersonal--detail">
                                  <img src="/images/news-author-01.jpg" alt="post-images">
                                  <p><a href="#">Anastasia Dan </a> - Jan 17, 2020</p>
                               </div>
                           </div>
                          </div>
                      </v-col>
                      <v-col cols="12" md="4" sm="6">
                        <div class="postBlock">
                           <div class="postBlock--img">
                               <img src="/images/news-01.jpg" alt="post-images">
                           </div>
                           <div class="postBlock--content">
                               <button class="text-white rounded-full">
                                 Product
                               </button>
                               <button class="text-white rounded-full">
                                 Engineering
                               </button>
                               <h3 class="postBlock--title"><a href="#">The quick brown fox jumped over the lazy dog.</a></h3>
                               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                               <div class="postPersonal--detail">
                                  <img src="/images/news-author-01.jpg" alt="post-images">
                                  <p><a href="#">Anastasia Dan </a> - Jan 17, 2020</p>
                               </div>
                           </div>
                          </div>
                      </v-col>
                  </v-row>
               </div>
            </section>
   </Layout>   
</template>

<script>
//import Card from '../components/Card.vue';
import CompanyList from '../components/Company.vue';
import Layout from './Layout';
import { Head,Link } from '@inertiajs/inertia-vue';
import Pagination from '../components/CompanyPagination.vue';
import Footer from '../partials/Footer.vue';
import { validationMixin } from 'vuelidate'
import { required} from 'vuelidate/lib/validators'

export default {
     mixins: [validationMixin],
     validations: {
      term: { required },
    },
   components: {
      Head,
      Layout,
      'CustomCard': CompanyList,
      Pagination,
      Footer,
   },
   props: {
      data : Object,  
      members:Object,
      filters: Object,
      term : String,
      locations : Array,
      job_posts_count: Number,
    },
    data () {
      return {
        location_id: '',
      }
    },
}
</script>
