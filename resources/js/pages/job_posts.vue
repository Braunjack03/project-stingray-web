<template>
   <Layout>
      <div>
            <v-app app>
               <v-container>
                  <h2>Project Stingray</h2>

                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search" v-model="term" @keyup="search">

                  <div :v-if="job_posts.data.length > 0">
                     <v-row >
                        <v-col  cols="3" v-for="data in job_posts.data" :key="data.id">
                           <CustomCard :data="data"/>
                        </v-col>
                     </v-row>
                     <pagination class="mt-5" :links="job_posts.links" />
                  </div>
                  {{job_posts.data.length}}
                  <div :v-if="job_posts.data.length === 1" >
                      <v-row >
                        <v-col cols="9" class="mt-5">
                             No Job Found 
                        </v-col>
                      </v-row>  
                  </div>
               </v-container>
         </v-app>
      </div>
   </Layout>   
</template>

<script>
//import Card from '../components/Card.vue';
import JobPost from '../components/JobPost.vue';
import Layout from './Layout';
import { Head,Link } from '@inertiajs/inertia-vue';
import Pagination from '../components/UserPagination.vue';


export default {
   components: {
      Head,
      Layout,
      'CustomCard': JobPost,
      Pagination
   },
   props: {
      job_posts : Object,  
      members:Object,
      filters: Object
    },
    data () {
      return {
        term: null, 
      }
    },
   props: ['job_posts'],
      methods: {
         search() {
             this.$inertia.replace('/?q='+this.term);
         }
      }
}
</script>
