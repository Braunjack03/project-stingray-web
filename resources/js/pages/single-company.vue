<template>
  <Layout>
    <Head :title="'Companies | ' + (data.name) ? data.name : ''" />
    <section class="relative companyProfile--outer" data-app>
      <div class="companyPageBanner">
        <img src="/images/company-banner.jpg" alt="">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="companyDetail--title">
          <h2 class="post-title mb-0 text-gray-700">
            {{ data.name }}
            <v-btn
              v-if="data.unclaimed == 1"
              v-on:click="claimProfile(data.uuid)"
              class="link-text"
              text
              >(Claim this Profile)</v-btn
            >
          </h2>
          <p class="types-title mt-0">{{ data.industry_types }}</p>
        </div>
      </div>
      </div>
      <div class="companyDetailOuter">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
          <div v-if="$page.props.flash.message" class="mt-2 success">
            {{ $page.props.flash.message }}
          </div>
          <div class="companyDetail">
            <div class="companyLogo">
              <v-img
                :src="(data.logo_image_url) ? data.logo_image_url : '/images/default-logo.png'"
              ></v-img>
            </div>
            <div class="conpanymainDetail">
              <v-row class="mt-0">
                <v-col cols="12" sm="6" md="4">
                  <div class="extra-info flex flex-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="#5d5dff">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>  Location
                    <span class="loactionCity" v-if="data.state" 
                      ><strong><span v-if="data.city" >{{ data.city }}, </span>{{ data.state }}</strong>
                    </span>
                  </div>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <div class="extra-info">
                    <div class="employeesDetails flex flex-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="#5d5dff">
                      <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>  Local Employees: <strong>{{ data.local_employees }}</strong>
                  </div>
                  <div class="employeesDetails flex flex-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="#5d5dff">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>  Global Employees: <strong>{{ data.global_employees }}</strong>
                  </div>
                  </div>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <!--div class="extra-info">
                    Year Founded: <strong>{{ data.year_founded }}</strong
                    ><br />
                  </div-->

                  <a
                    :href="data.website_url"
                    target="_blank"
                    class="background-transparent flex flex-wrap viewSite items-center"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="#5d5dff">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                  </svg> View website
                  </a>
                </v-col>
              </v-row>
            </div>
          </div>
        </div>
      </div>

      <div class="max-w-6xl mx-auto px-4 sm:px-6 companyAbout">
        <v-row>
          <v-col cols="12" md="6" class="pa-3 d-flex flex-column">
             <div class="aboutImg">
                <v-img
                :src="(data.featured_image_url) ? data.featured_image_url : '/images/aboutImg.jpg'"
              ></v-img>
            </div>
          </v-col>
          <v-col cols="12" md="6" class="pa-3 d-flex flex-column">
             <div class="aboutContent">
                <h3 class="post-title">About {{ data.name }}</h3>
                <div class="desc" v-html="data.mission"></div>
            </div>
          </v-col>
       </v-row>
      </div>

      <div class="companyJobList">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 pt-4">
          <v-row class="items-center">
            <v-col cols="12" md="9" class="pa-3 d-flex flex-column">
               <h3 class="post-title">Jobs at {{ data.name }}</h3>
            </v-col>
            <v-col cols="12" md="3" class="pa-3 d-flex flex-column text-right">
               <span class="text-gray-700">{{job_posts_count}} Positions</span>
            </v-col>
         </v-row>
          <div v-if="job_posts.data.length > 0">
                     <v-row >
                        <v-col cols="12" md="12" class="pa-3 d-flex flex-column" v-for="data in job_posts.data" :key="data.id">
                           <CustomCard :data="data" />
                        </v-col>
                     </v-row>
                     <pagination class="mt-5" :links="job_posts.links" />
                  </div>  
                  <div v-else >
                      <v-row >
                        <v-col cols="12" class="mt-5 text-center text-gray-700">
                             {{ data.name }} has no jobs posted 
                        </v-col>
                      </v-row>  
                  </div>

          <!--v-row v-if="job_posts">
              <v-col cols="12" md="12" class="pa-3 d-flex flex-column" v-for="data in job_posts" :key="data.id">
                 <CustomCard :data="data" />
              </v-col>

              <v-col cols="12" md="12" class="pa-3 d-flex flex-column text-center my-3">
                 <button class="viewOther--Btn" @click="handleButton(page)">
                    View Other {{ data.name }} Jobs
                  </button>
              </v-co>
              <pagination class="mt-5" :links="job_posts.links" />
           </v-row-->
           
        </div> 
      </div>

    </section>
  </Layout>
</template>
<script>
import { Link, Head } from "@inertiajs/inertia-vue";
import CompanyJobPost from '../components/CompanyJobPost.vue';
import Pagination from '../components/CompanyPagination.vue';
import Layout from "./Layout";
export default {
  components: {
    Link,
    Layout,
     'CustomCard': CompanyJobPost,
    Pagination,
    Head,
  },
  props: {
    errors: Object,
    success: Object,
    data: Object,
    job_posts: Object,
    selected : String,
    job_posts_count:Number,
  },
   mounted() {
      this.tab = this.selected
  },  
  data: () => ({
    message: "",
     tab: null,
     page:1,
  }),
  methods: {
    claimProfile(id) {
      this.$inertia.get("/claim-profile/" + id);
    },
    handleButton(page) {

      console.log('here',page);
            //if(!this.moreMsgFetched){
                var newdata = this.$inertia.get(this.data.slug+'?page=2')
                console.log('testing', newdata);
                /*.then((response) => {
                    this.moreMessages = response.data;
                    this.messages = this.moreMessages.splice(0, 10);
                    this.moreMsgFetched = true;
                });*/
                this.page += 1;
            //}
             //if you want to replace the messages array every time with 10 more messages
            //this.messages = nextMsgs
            //if you wnt to add 10 more messages to messages array
            //this.messages.push(nextMsgs);
        }

  },
};
</script>
