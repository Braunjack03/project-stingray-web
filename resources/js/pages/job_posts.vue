<template>
   <Layout>
      <Head title="Job Listing" />
    
              <section data-app>
               <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 md:py-20 relative">
                  <div class="pt-10 pb-6 md:pb-12">

                     <div class="mx-auto text-center pt-10 pb-3">
                        <div class="flex filter-outer">
                           <span class="searc-show-title">
                              Total Number of jobs: {{job_posts_count}}

                           </span>
                           <div class="filter-opt relative">
                           <v-select
                           v-model="location_id"
                           item-text="name"
                           item-value="id"
                           :items="locations"
                           label="Location"
                           persistent-hint
                           single-line
                           ></v-select>
                           <input type="text" name="table_search" :class="{ 'error--text': $v.term.$error }" class="form-control float-right" placeholder="Search" v-model="term" @keydown.enter="submit">
                           <div v-if="$v.term.$error && !$v.term.required"  class="text-red-500 text-sm jobserach-error">Search is required</div>

                              <v-btn class="
                                 btn
                                 text-white
                                 bg-purple-600
                                 hover:bg-purple-700 ml-3 jobsearchBtn" 
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
                        <v-col cols="12" class="mt-5 text-center text-gray-700">
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
        location_id: new URL(location.href).searchParams.get('loc')
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
