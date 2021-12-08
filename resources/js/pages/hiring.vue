<template>
   <Layout>
      <Head title="Job Listing" />
              <section data-app>
               <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 md:py-20 relative">
                  <div class="pt-16 pb-6 md:pb-12 company-page-title">
                     <h3 class="h3 text-gray-700 text-center">Tech Companies Hiring Right Now</h3>
                  </div>
                  <div v-if="data.data.length > 0">
                     <v-row v-for="data in data.data" :key="data.id">
                        <CustomCard :data="data"/>   
                        <!--v-col cols="12" md="12" class="pa-3 d-flex flex-column">
                           <v-card class="elevation-5 flex d-flex flex-column cardStyle">
                              <v-card-text class="job-card-wrap company-card-wrap">
                                 <div class="company-img-block">
                                    <img src="http://192.168.0.55:8000/images/how-it-work.jpg">
                                 </div>
                                 <div class="company-text-block">
                                    <v-card-title class="p-0">Optical Instrument Assembler</v-card-title> 
                                    <div class="text-subtitle-1"><span>Fintech</span></div>
                                    <p class="description">A diversified trading firm that utilizes our own capital and trades at our own risk. We bring sophisticated technology and exceptional people together to solve complex problems in markets around the world and across many asset classes.</p>
                                 </div>
                                 <div class="company-jobs-block">
                                    <a class="flex justify-center items-center" href="#">View 73 Jobs 
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                       </svg>
                                    </a>
                                    <div class="company-location">
                                       <p><span>Chicago</span> Location</p>
                                    </div>
                                 </div>
                              </v-card-text>
                           </v-card>
                        </v-col>
                        <v-col cols="12" md="12" class="pa-3 d-flex flex-column">
                           <v-card class="elevation-5 flex d-flex flex-column cardStyle">
                              <v-card-text class="job-card-wrap company-card-wrap">
                                 <div class="company-img-block">
                                    <img src="http://192.168.0.55:8000/images/how-it-work.jpg">
                                 </div>
                                 <div class="company-text-block">
                                    <v-card-title class="p-0">Optical Instrument Assembler</v-card-title> 
                                    <div class="text-subtitle-1"><span>Fintech</span></div>
                                    <p class="description">A diversified trading firm that utilizes our own capital and trades at our own risk. We bring sophisticated technology and exceptional people together to solve complex problems in markets around the world and across many asset classes.</p>
                                 </div>
                                 <div class="company-jobs-block">
                                    <a class="flex justify-center items-center" href="#">View 73 Jobs 
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                       </svg>
                                    </a>
                                    <div class="company-location">
                                       <p><span>Chicago</span> Location</p>
                                    </div>
                                 </div>
                              </v-card-text>
                           </v-card>
                        </v-col>
                        <v-col cols="12" md="12" class="pa-3 d-flex flex-column">
                           <v-card class="elevation-5 flex d-flex flex-column cardStyle">
                              <v-card-text class="job-card-wrap company-card-wrap">
                                 <div class="company-img-block">
                                    <img src="http://192.168.0.55:8000/images/how-it-work.jpg">
                                 </div>
                                 <div class="company-text-block">
                                    <v-card-title class="p-0">Optical Instrument Assembler</v-card-title> 
                                    <div class="text-subtitle-1"><span>Fintech</span></div>
                                    <p class="description">A diversified trading firm that utilizes our own capital and trades at our own risk. We bring sophisticated technology and exceptional people together to solve complex problems in markets around the world and across many asset classes.</p>
                                 </div>
                                 <div class="company-jobs-block">
                                    <a class="flex justify-center items-center" href="#">View 73 Jobs 
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                       </svg>
                                    </a>
                                    <div class="company-location">
                                       <p><span>Chicago</span> Location</p>
                                    </div>
                                 </div>
                              </v-card-text>
                           </v-card>
                        </v-col-->
                     </v-row>
                     <pagination class="mt-5" :links="data.links" />
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
import CompanyList from '../components/Company.vue';
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
