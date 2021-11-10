<template>
  <Layout>
    <Head title="Job Posts" />
    <section class="relative">
      <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="pt-32 pb-12 md:pt-40 md:pb-20">
          <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
            <h1 class="h1 mb-4" data-aos="fade-up">
              {{ company_details.name }} Job Posts
            </h1>
          </div>

          <div class="max-w-xl mx-auto">
            <Link
              v-if="companies_count > 0 && job_posts_count < 3"
              :href="'/employer/create-job?c_id=' + company_details.uuid"
              color="text"
              class="btn text-white bg-purple-600 hover:bg-purple-700 mb-3"
              >Add New Job Post</Link
            >

            <br /><br /><br />
            <h3 class="h3">Current Job Posts</h3>
            <br />

            <div
              v-if="$page.props.flash.message"
              class="text-green-500 text-center text-sm mb-4"
            >
              {{ $page.props.flash.message }}
            </div>

            <ul v-if="job_posts" id="example-1">
              <li v-for="company in job_posts" :key="company.id">
                <v-row no-gutters class="mt-5">
                  <div
                    class="col-sm-12 col-md-12 col-8 bg-white rounded-xl shadow-md overflow-hidden mt-5"
                  >
                    <div class="">
                      <v-col cols="12">
                        <h3
                          class="uppercase tracking-wide text-xl text-indigo-500 font-semibold"
                        >
                          {{ company.name }}
                        </h3>
                        <p class="mt-2 text-gray-800">
                          Location: {{ company.location_id }}
                        </p>
                        <p class="mt-2 text-gray-800">
                          Published: {{ setDateFormat(company.created_on) }}
                        </p>
                      </v-col>
                      <v-col cols="12 flex">
                        <Link
                          :href="'/employer/edit-job?id=' + company.uuid"
                          class="mr-4 btn text-purple-800 custom-link"
                          >EDIT</Link
                        >
                        <v-btn
                          class="mr-4 text-purple-800 custom-link"
                          v-on:click="deletejob(company.uuid)"
                          color="#3f51b5"
                          plain
                          link
                          >Delete</v-btn
                        >
                      </v-col>
                    </div>
                  </div>
                </v-row>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </Layout>
</template>
<script>
import Layout from "../Layout";
import { Head, Link } from "@inertiajs/inertia-vue";
export default {
  components: {
    Head,
    Layout,
    Link,
  },
  props: {
    errors: Object,
    user: Object,
    success: Object,
    job_posts: Array,
    companies_count: Number,
    company_details: Object,
    job_posts_count: Number,
  },
  data: () => ({
    message: "",
    showCreate: false,
    valid: true,
    form: {
      profile_image: "",
      current_job_title: "",
      name: "",
      short_bio: "",
      profile_image_removed: 0,
    },
  }),
  methods: {
    validate() {
      this.$refs.form.validate();
      return true;
    },
    deletejob(id) {
      if (confirm("Do you really want to delete?")) {
        this.$inertia.get("/employer/delete-job/?id=" + id);
      }
      return false;
    },
    removeImage() {
      this.user.profile_image_src = "";
      this.user.profile_image_removed = 1;
    },
    showCreateForm() {
      this.showCreate = true;
    },
    setDateFormat(dateObject) {
      var d = new Date(dateObject);
      var day = d.getDate();
      var month = d.getMonth() + 1;
      var year = d.getFullYear();
      if (day < 10) {
        day = "0" + day;
      }
      if (month < 10) {
        month = "0" + month;
      }
      var date = day + "/" + month + "/" + year;

      return date;
    },
  },
};
</script>
