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
