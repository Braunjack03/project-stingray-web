<template>
  <Layout>
    <Head :title="'Companies | ' + (data.name) ? data.name : ''" />
    <section class="relative" data-app>
      <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="pt-32 pb-12 md:pt-40 md:pb-20">
          <div v-if="$page.props.flash.message" class="mt-2 success">
            {{ $page.props.flash.message }}
          </div>
          <v-row>
            <v-col lg="3" md="4" sm="5" cols="12">
              <v-img
                :src="data.logo_image_url"
                max-height="150"
                max-width="250"
              ></v-img>
            </v-col>
            <v-col lg="9" md="8" sm="7" cols="12">
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
              <p class="types-title mt-0 text-gray-500">{{ data.industry_types }}</p>
              <v-row class="mt-0 ">
                <v-col cols="12" sm="6" md="4">
                  <div class="extra-info text-gray-500">
                    Location :
                    <span
                      ><strong>{{ data.location }}</strong></span
                    >
                  </div>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <div class="extra-info text-gray-500">
                    Local Employees: <strong>{{ data.local_employees }}</strong
                    ><br />
                    Global Employees:
                    <strong>{{ data.global_employees }}</strong>
                  </div>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <!--div class="extra-info">
                    Year Founded: <strong>{{ data.year_founded }}</strong
                    ><br />
                  </div-->

                  <v-btn
                    :href="data.website_url"
                    target="_blank"
                    class="bg-purple-600 hover:bg-purple-700 "
                  >
                    View website
                  </v-btn>
                </v-col>
              </v-row>
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" md="12">
              <h3 class="post-title text-gray-700">About {{ data.name }}</h3>
              <div class="desc text-gray-500" v-html="data.mission"></div>
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
        </div>
      </div>
    </section>
  </Layout>
</template>
<script>
import { Link, Head } from "@inertiajs/inertia-vue";
import Layout from "./Layout";
export default {
  components: {
    Link,
    Layout,
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
  }),
  methods: {
    claimProfile(id) {
      this.$inertia.get("/claim-profile/" + id);
    },
  },
};
</script>
