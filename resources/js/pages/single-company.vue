<template>
  <Layout>
    <Head :title="'Companies | ' + (data.name) ? data.name : ''" />
    <section class="relative companyProfile--outer" data-app>
      <div class="companyDetailOuter">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
          <div v-if="$page.props.flash.message" class="mt-2 success">
            {{ $page.props.flash.message }}
          </div>
          <v-row class="companyDetail">
            <v-col lg="2" md="2" sm="4" cols="12">
              <v-img
                :src="data.logo_image_url"
              ></v-img>
            </v-col>
            <v-col lg="10" md="10" sm="8" cols="12">
              <h2 class="post-title mb-0 text-gray-700">
                {{ data.name }}
                <v-btn
                  v-if="data.unclaimed == 1 && data.role == 3"
                  v-on:click="claimProfile(data.uuid)"
                  class="link-text ml-2"
                  text
                  >(Claim this Profile)</v-btn
                >
              </h2>
              <p class="types-title mt-0">{{ data.industry_types }}</p>
              <v-row class="mt-0 ">
                <v-col cols="12" sm="6" md="4">
                  <div class="extra-info flex flex-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="#5d5dff">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>  Location
                    <span class="loactionCity" 
                      ><strong>{{ data.location }}</strong></span
                    >
                  </div>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <div class="extra-info">
                    <div class="employeesDetails flex flex-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="#5d5dff">
                      <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>  Local Employees: <strong>{{ data.local_employees }}</strong
                    >
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
            </v-col>
          </v-row>
        </div>
      </div>

      <div id="tabBg">
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <v-tabs
            v-model="tab"
            centered
          >
            <v-tabs-slider></v-tabs-slider>

            <v-tab href="#tab-1">
              Overview
            </v-tab>

            <v-tab href="#tab-2">
              Jobs ({{job_posts.length}})
            </v-tab>
          </v-tabs>
        </div>
      </div>

      <div class="max-w-6xl mx-auto">
        <v-tabs-items v-model="tab">
          <v-tab-item
            value="tab-1"
          >
            <v-card flat>
              <v-card-text>
                <div class="max-w-6xl mx-auto px-2 pt-5">
                  <div class="aboutContent">
                      <h3 class="post-title">About {{ data.name }}</h3>
                      <div class="desc" v-html="data.mission"></div>
                  </div>
                  <div class="aboutContent">
                      <h3 class="desc text-gray-700 mb-3">Jobs at {{ data.name }}</h3>
                      <ul v-if="job_posts" id="example-1">
                        <li v-for="company in job_posts" :key="company.id">
                          <h4 class="post-title">
                            <a :href="`/jobs/${data.slug}/${company.slug}`" class="text-gray-700"
                              >{{ company.name }}
                              <span class="text-sm"
                                >({{ company.location_id }})</span
                              ></a
                            >
                          </h4>
                          <div class="post-detail-wrap" v-html="company.content"></div>
                        </li>
                      </ul>
                  </div>
              </div>
              </v-card-text>
            </v-card>
          </v-tab-item>
          <v-tab-item
            value="tab-2"
          >
            <v-card flat>
              <v-card-text>
                
                <div class="max-w-6xl mx-auto px-4 sm:px-6 pt-4">

                  <v-row v-if="job_posts">

                        <v-col cols="12" md="12" class="pa-3 d-flex flex-column" v-for="data in job_posts" :key="data.id">
                           <CustomCard :data="data"/>
                        </v-col>
                     </v-row>
              </div> 
              </v-card-text>
            </v-card>
          </v-tab-item>
        </v-tabs-items>
      </div>

    <!--   <div class="max-w-6xl mx-auto px-4 sm:px-6">
          <v-row class=" aboutContent">
            <v-col cols="12" md="12">
              <h3 class="post-title">About {{ data.name }}</h3>
              <div class="desc" v-html="data.mission"></div>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" class="pa-2">
              <h3 class="desc text-gray-700">Jobs at {{ data.name }}</h3>
              <ul v-if="job_posts" id="example-1" class="text-gray-500">
                <li v-for="company in job_posts" :key="company.id">
                  <h4 class="post-title">
                    <a :href="`/jobs/${data.slug}/${company.slug}`" class="text-gray-700"
                      >{{ company.name }}
                      <span class="text-sm"
                        >({{ company.location_id }})</span
                      ></a
                    >
                  </h4>
                  <div class="post-detail-wrap" v-html="company.content"></div>
                </li>
              </ul>
            </v-col>
          </v-row>
      </div> -->
    </section>
  </Layout>
</template>
<script>
import { Link, Head } from "@inertiajs/inertia-vue";
import JobPost from '../components/JobPost.vue';
import Layout from "./Layout";
export default {
  components: {
    Link,
    Layout,
     'CustomCard': JobPost,
    Head,
  },
  props: {
    errors: Object,
    success: Object,
    data: Object,
    job_posts: Array,
  },
  data: () => ({
    message: "",
     tab: null,
  }),
  methods: {
    claimProfile(id) {
      this.$inertia.get("/claim-profile/" + id);
    },
  },
};
</script>
