<template>
  <Layout>
    <section data-app>
      <div class="relative max-w-6xl px-4 py-10 mx-auto sm:px-6 md:py-20">
        <div class="pt-16 pb-6 md:pb-12 company-page-title">
          <h1 class="text-center text-gray-700 h1">
            Companies Hiring in the Tampa Bay
          </h1>
        </div>
        <div v-if="data.data.length > 0">
          <v-row v-for="data in data.data" :key="data.id">
            <CustomCard :data="data" />
          </v-row>
          <pagination class="mt-5" :links="data.links" />
        </div>
        <div v-else>
          <v-row>
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
import CompanyList from "../components/Company.vue";
import Layout from "./Layout";
import { Link } from "@inertiajs/inertia-vue";
import Pagination from "../components/CompanyPagination.vue";
import Footer from "../partials/Footer.vue";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";

export default {
  name: "Companies",
   metaInfo: {
      title: "Companies",
      titleTemplate: "%s - Made in Tampa",
      meta: [
         { name: 'description', content: 'Companies Hiring in the Tampa Bay' },
      ]
   },
  mixins: [validationMixin],
  validations: {
    term: { required },
  },
  components: {
    Layout,
    CustomCard: CompanyList,
    Pagination,
    Footer,
  },
  props: {
    data: Object,
    members: Object,
    filters: Object,
    term: String,
    locations: Array,
    job_posts_count: Number,
  },
  data() {
    return {
      location_id: "",
      base_url: window.location.origin,
    };
  },
};
</script>
