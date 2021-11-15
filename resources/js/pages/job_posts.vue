<template>
   <Layout>
      <Head title="Job Listing" />
              <section data-app>
               <div class="max-w-6xl mx-auto px-4 sm:px-6 relative">
                  <div class="pt-10 pb-12">

                     <div class="mx-auto text-center pt-10 pb-3">
                        <div class="flex filter-outer">
                           <span class="searc-show-title">
                              showing result {{job_posts.data.length}}
                           </span>
                           <div class="filter-opt">
                           <v-select
                           v-model='location_id'
                           item-text="name"
                           item-value="id"
                           :items="locations"
                           label="Location"
                           @change="search"
                           solo
                           ></v-select>
                           <input type="text" name="table_search" value= '' class="form-control float-right" placeholder="Search" v-model="term" @keyup="search">
                        </div>
                        </div>
                    </div>
                  </div>

                  <div v-if="job_posts.data.length > 0">
                     <v-row >
                        <v-col cols="12" md="12" class="pa-3 d-flex flex-column" v-for="data in job_posts.data" :key="data.id">
                           <CustomCard :data="data"/>
                        </v-col>
                     </v-row>
                     <pagination class="mt-5" :links="job_posts.links" />
                  </div>  
                  <div v-else >
                      <v-row >
                        <v-col cols="9" class="mt-5 text-center">
                             No Job Found 
                        </v-col>
                      </v-row>  
                  </div>
            </div>
         </section>
          <Footer/>
   </Layout>   
</template>

<script>
//import Card from '../components/Card.vue';
import JobPost from '../components/JobPost.vue';
import Layout from './Layout';
import { Head,Link } from '@inertiajs/inertia-vue';
import Pagination from '../components/JobPagination.vue';
import Footer from '../partials/Footer.vue';

export default {
   components: {
      Head,
      Layout,
      'CustomCard': JobPost,
      Pagination,
      Footer,
   },
   props: {
      job_posts : Object,  
      members:Object,
      filters: Object,
      term : String,
      locations : Array,
    },
    data () {
      return {
        location_id: '',
      }
    },
      methods: {
         search() {
             if(this.term === null)
             {
                this.term = '';
             }
             this.$inertia.replace('/jobs?loc='+this.location_id+'&q='+this.term);
         }
      }
}
</script>
