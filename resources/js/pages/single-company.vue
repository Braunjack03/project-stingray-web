<template>
  <Layout>
    <section
      class="relative companyProfile--outer"
      data-app
    >
      <div class="companyPageBanner">
        <img
          src="/images/company-banner.jpg"
          alt=""
        >
        <div class="max-w-6xl px-4 mx-auto sm:px-6">
          <div class="companyDetail--title">
            <h2 class="mb-0 text-gray-700 post-title">
              {{ data.name }}
              <v-btn
                v-if="data.unclaimed == 1 && is_company_belong_to == 0"
                class="link-text"
                text
                @click="claimProfile(data.uuid)"
              >
                (Claim this Profile)
              </v-btn>
            </h2>
            <p class="mt-0 types-title">
              {{ data.industry_types }}
            </p>
          </div>
        </div>
      </div>

      <div
        v-if="$page.props.flash.message && hide == 0"
        class="verifyEmailText verifyclaimText"
      >
        <div
          class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded"
          role="alert"
        >
          <span class="block sm:inline">{{ $page.props.flash.message }}</span>
          <span
            class="absolute top-0 bottom-0 right-0 px-4 py-3"
            @click="hideMessage"
          >
            <svg
              class="w-6 h-6 text-green-500 fill-current"
              role="button"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
            ><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" /></svg>
          </span>
        </div>
      </div>

      <div class="companyDetailOuter">
        <div class="max-w-6xl px-4 mx-auto sm:px-6">
          <div class="companyDetail">
            <div class="companyLogo">
              <v-img :src="(data.logo_image_url) ? data.logo_image_url : '/images/default-company-logo.svg'" />
            </div>
            <div class="conpanymainDetail">
              <v-row class="mt-0">
                <v-col
                  cols="12"
                  sm="6"
                  md="4"
                >
                  <div class="flex flex-wrap extra-info">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-4 h-4 mr-1"
                      viewBox="0 0 20 20"
                      fill="#5d5dff"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                        clip-rule="evenodd"
                      />
                    </svg> Location
                    <span
                      v-if="data.state"
                      class="loactionCity"
                    ><strong><span v-if="data.city">{{ data.city }}, </span>{{ data.state }}</strong>
                    </span>
                  </div>
                </v-col>
                <v-col
                  cols="12"
                  sm="6"
                  md="4"
                >
                  <div class="extra-info">
                    <div class="flex flex-wrap employeesDetails">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 mr-1"
                        viewBox="0 0 20 20"
                        fill="#5d5dff"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                          clip-rule="evenodd"
                        />
                      </svg> Local Employees: <strong>{{ data.local_employees }}</strong>
                    </div>
                    <div class="flex flex-wrap employeesDetails">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="#5d5dff"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"
                        />
                      </svg> Global Employees: <strong>{{ data.global_employees }}</strong>
                    </div>
                  </div>
                </v-col>
                <v-col
                  cols="12"
                  sm="6"
                  md="4"
                >
                  <!--div class="extra-info">
                        Year Founded: <strong>{{ data.year_founded }}</strong
                        ><br />
                      </div-->

                  <a
                    :href="data.website_url"
                    target="_blank"
                    class="flex flex-wrap items-center background-transparent viewSite"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-4 h-4 mr-1"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="#5d5dff"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"
                      />
                    </svg> View website
                  </a>
                </v-col>
              </v-row>
            </div>
          </div>
        </div>
      </div>

      <div class="max-w-6xl px-4 mx-auto sm:px-6 companyAbout">
        <v-row>
          <v-col
            cols="12"
            md="6"
            class="pa-3 d-flex flex-column"
          >
            <div class="aboutImg">
              <v-img :src="(data.featured_image_url) ? data.featured_image_url : '/images/aboutImg.jpg'" />
            </div>
          </v-col>
          <v-col
            cols="12"
            md="6"
            class="pa-3 d-flex flex-column"
          >
            <div class="aboutContent">
              <h3 class="post-title">
                About {{ data.name }}
              </h3>
              <div
                class="desc"
                v-html="data.description"
              />
            </div>
          </v-col>
        </v-row>
      </div>

      <div class="companyJobList">
        <div class="max-w-6xl px-4 pt-4 mx-auto sm:px-6">
          <v-row class="items-center">
            <v-col
              cols="12"
              md="9"
              class="pa-3 d-flex flex-column"
            >
              <h3 class="post-title">
                Jobs at {{ data.name }}
              </h3>
            </v-col>
            <v-col
              cols="12"
              md="3"
              class="text-right pa-3 d-flex flex-column"
            >
              <span class="text-lg text-gray-700">{{ job_posts_count }} Positions</span>
            </v-col>
          </v-row>
          <div v-if="job_posts.data.length > 0">
            <v-row>
              <v-col
                v-for="data in job_posts.data"
                :key="data.id"
                cols="12"
                md="12"
                class="pa-3 d-flex flex-column"
              >
                <CustomCard :data="data" />
              </v-col>
            </v-row>
            <pagination
              class="mt-5"
              :links="job_posts.links"
            />
          </div>
          <div v-else>
            <v-row>
              <v-col
                cols="12"
                class="mt-5 text-lg text-center text-gray-700"
              >
                {{ data.name }} has no jobs posted
              </v-col>
            </v-row>
          </div>
        </div>
      </div>

      <div
        v-if="articles.length > 0"
        class="companyJobList"
      >
        <div class="max-w-6xl px-4 pt-4 mx-auto sm:px-6">
          <v-row>
            <v-col
              cols="12"
              md="12"
              class="pa-3 d-flex flex-column"
            >
              <h3 class="post-title">
                News Articles Mentioning {{ data.name }}
              </h3>
            </v-col>
            <Article
              v-for="data in articles"
              :key="data.id"
              :data="data"
            />

            <v-col
              cols="12"
              class="mt-5 text-center text-gray-700"
            >
              <Link
                class="text-center underline"
                href="/articles"
              >
                More Articles
              </Link>
            </v-col>
          </v-row>
        </div>
      </div>
    </section>
  </Layout>
</template>

<script>
import { Link, Head } from '@inertiajs/inertia-vue';
import JobPost from '../components/JobPost.vue';
import Article from '../components/Article.vue';
import Pagination from '../components/CompanyPagination.vue';
import Layout from './Layout.vue';

export default {
  name: "Company",
   metaInfo: {
    title: "Companies",
    titleTemplate: "Made in Tampa Companies - %s",
  },
  // child
  metaInfo() {
    return {
      meta: [
        {  
          name: 'description',
          content: this.data.description.replace(/<[^>]*>?/gm, ''),
        },
        {  
          property: 'og:title',
          content: this.data.name,
        },
        {  
          property: 'og:type',
          content: 'company',
        },
        {  
          property: 'og:image',
          content: this.data.logo_image_url,
        },
        {  
          property: 'og:url',
          content: this.base_url+'/companies/'+this.data.slug,
        },
        {  
          property: 'twitter:card',
          content: this.data.logo_image_url,
        },
        {  
          name: 'og:description',
          content: this.data.description.replace(/<[^>]*>?/gm, ''),
        },
        {  
          name: 'og:site_name',
          content: 'Made in Tampa',
        },
      ]
    }
  },
  components: {
    Link,
    Layout,
    CustomCard: JobPost,
    Article,
    Pagination,
    Head,
  },
  props: {
    errors: Object,
    success: Object,
    data: Object,
    job_posts: Object,
    articles: Array || Object,
    selected: String,
    job_posts_count: Number,
    is_company_belong_to: Number,
  },
  data: () => ({
    message: '',
    tab: null,
    page: 1,
    hide: 0,
    base_url: window.location.origin,
  }),
  mounted() {
    this.tab = this.selected;
  },
  methods: {
    claimProfile(id) {
      this.$inertia.get(`/claim-profile/${id}`);
    },
    hideMessage() {
      this.hide = 1;
    },

  },
};
</script>
