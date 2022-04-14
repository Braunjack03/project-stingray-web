<template>
   <Layout>
              <section data-app>
               <div class="relative max-w-6xl px-4 py-10 mx-auto sm:px-6 md:py-20">

                   <div class="pt-16 pb-6 md:pb-12 jobpost-page-title">
                    <h1 class="text-center text-gray-700 h1">Jobs in the Tampa Bay Area</h1>

                     <div class="pt-10 pb-3 mx-auto text-center">
                        <div class="flex filter-outer jobsFilter">
                           <span class="searc-show-title">
                              Total Number of jobs: {{job_posts_count}}
                           </span>
                           <div class="relative filter-opt">
                           <input type="text" name="table_search" :class="{ 'error--text': $v.term.$error }" class="float-right form-control" placeholder="Search" v-model="term" @keydown.enter="submit">
                           <div v-if="$v.term.$error && !$v.term.required"  class="text-lg text-red-500 jobserach-error">Search is required</div>
                           <v-select
                           v-model="location_id"
                           item-text="name"
                           item-value="id"
                           :items="locations"
                           label="Location"
                           persistent-hint
                           single-line
                           ></v-select>
                          

                              <v-btn class="ml-3 text-white bg-purple-600 btn hover:bg-purple-700 jobsearchBtn" 
                              @click="submit">
                                 Search
                              </v-btn>
                        </div>
                        </div>
                    </div>
                  </div>
                  <div v-if="job_posts.data.length > 0">
                     <v-row >
                        <v-col cols="12" md="12" class="pa-3 d-flex flex-column" v-for="data in job_posts.data" :key="data.id">
                           <CustomCard :data="data" />
                        </v-col>
                     </v-row>
                     <pagination class="mt-5" :links="job_posts.links" :location_id="location_id" :term="term"/>
                  </div>  
                  <div v-else >
                      <v-row >
                        <v-col cols="12" class="mt-5 text-lg text-center text-gray-700">
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
import Footer from '../partials/Footer.vue';
import { validationMixin } from 'vuelidate'
import { required} from 'vuelidate/lib/validators'

export default {
     mixins: [validationMixin],
     validations: {
      term: { required },
    },
   //  metaInfo: {
   //    title: "Job Posts",
   //    titleTemplate: "%s - Made in Tampa",
   //    meta: [
   //       { name: 'description', content: 'Jobs in the Tampa Bay' },
   //    ]
   // },
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
      loc_id : String,
      locations : Array,
      job_posts_count: Number,
    },
    data () {
      return {
        location_id: (parseInt(new URL(location.href).searchParams.get('loc')) === undefined) ? 0: parseInt(new URL(location.href).searchParams.get('loc')), 
      }
    },
      methods: {

          submit() {
            this.$v.$touch()
          if(this.$v.$invalid) {
            console.log('error!')
          } else {
              if(this.term === null)
             {
                this.term = '';
             }
            this.$inertia.replace(
                "/jobs?loc=" + this.location_id + "&q=" + this.term
            );
          }
        },
      }
}
</script>
