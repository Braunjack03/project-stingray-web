<template>
   <Layout>
      <Head title="Job Listing" />

              <section>
               <div class="max-w-6xl mx-auto px-4 sm:px-6 relative">
                  <div class="pt-10 pb-12 md:pt-16 md:pb-20">

                     <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                     
                        <v-select
                          v-model='location_id'
                          item-text="name"
                          item-value="id"
                          :items="locations"
                          label="Location"
                          @change="search"
                        ></v-select>
                     <input type="text" name="table_search" value= '' class="form-control float-right" placeholder="Search" v-model="term" @keyup="search">
  
                    </div>
                  </div>

                  <div v-if="job_posts.data.length > 0">
                     <v-row >
                        <v-col md="3" class="pa-3 d-flex flex-column" v-for="data in job_posts.data" :key="data.id">
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
   </Layout>   
</template>

<script>
//import Card from '../components/Card.vue';
import JobPost from '../components/JobPost.vue';
import Layout from './Layout';
import { Head,Link } from '@inertiajs/inertia-vue';
import Pagination from '../components/JobPagination.vue';

export default {
   components: {
      Head,
      Layout,
      'CustomCard': JobPost,
      Pagination,
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
             this.$inertia.replace('/?loc='+this.location_id+'&q='+this.term);
         }
      }
}
</script>
