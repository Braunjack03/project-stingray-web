<template>
  <Layout>
    <Head title="Job Posts" />
    <section class="relative">
      <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="pt-36 pb-12 md:pt-40 md:pb-20">
          <div class="max-w-6xl mx-auto text-center pb-12 md:pb-16">
            <h1
              class="h1 mb-4 text-gray-700"
              data-aos="fade-up"
            >
              {{ company_details.name }} Job Posts
            </h1>
          </div>

          <div class="max-w-6xl mx-auto testJobs">
            <Link
              v-if="companies_count > 0 && job_posts_count < 3"
              :href="'/employer/create-job?c_id=' + company_details.uuid"
              color="text"
              class="text-lg btn text-white bg-purple-600 hover:bg-purple-700 mb-3"
            >
              Add New Job Post
            </Link>

            <br><br><br>
            <h3 class="h3 text-gray-700">
              Current Job Posts
            </h3>
            <br>

            <Message
              :message="$page.props.flash.message"
              hide="0"
              :type="'success'"
            />

            <div v-if="job_posts.length > 0">
              <v-row>
                <v-col
                  v-for="data in job_posts"
                  :key="data.id"
                  cols="12"
                  md="12"
                  class="pa-3 d-flex flex-column"
                >
                  <v-card class="elevation-5 flex d-flex flex-column cardStyle">
                    <v-card-text class="job-card-wrap">
                      <div class="card-text-wrap">
                        <v-card-title>{{ data.name }}</v-card-title>
                        <div class="card-outter">
                          <div
                            v-if="data.company_name"
                            class="text-subtitle-1"
                          >
                            Company Name: {{ data.company_name }}
                          </div>
                          <div class="description">
                            Location: {{ data.location_id }}
                          </div>
                          <div class="date text-lg">
                            Published: {{ setDateFormat(data.created_on) }}
                          </div>
                        </div>
                      </div>
                      <div class="button-outter flex">
                        <Link
                          :href="'/employer/edit-job?id=' + data.uuid"
                          class="editJobsBtn text-white bg-purple-600 hover:bg-purple-700 pl-8 pt-3 pb-3 pr-7 text-lg"
                        >
                          Edit
                        </Link>
                        <v-btn
                          class="text-white bg-purple-600 hover:bg-purple-700 text-lg"
                          @click="deletejob(data.uuid)"
                        >
                          Delete
                        </v-btn>
                      </div>
                    </v-card-text>
                  </v-card>
                </v-col>
              </v-row>
            </div>
            <div v-else>
              <v-row>
                <v-col
                  cols="12"
                  class="mt-5 text-center text-gray-700 text-lg"
                >
                  No Job Found
                </v-col>
              </v-row>
            </div>
          </div>
        </div>
      </div>
    </section>
  </Layout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue';
import Layout from '../Layout.vue';
import Message from '../../partials/Messages.vue';

export default {
  components: {
    Head,
    Layout,
    Link,
    Message,
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
    message: '',
    showCreate: false,
    valid: true,
    form: {
      profile_image: '',
      current_job_title: '',
      name: '',
      short_bio: '',
      profile_image_removed: 0,
    },
  }),
  methods: {
    validate() {
      this.$refs.form.validate();
      return true;
    },
    deletejob(id) {
      if (confirm('Do you really want to delete?')) {
        this.$inertia.get(`/employer/delete-job/?id=${id}`);
      }
      return false;
    },
    removeImage() {
      this.user.profile_image_src = '';
      this.user.profile_image_removed = 1;
    },
    showCreateForm() {
      this.showCreate = true;
    },
    setDateFormat(dateObject) {
      const d = new Date(dateObject);
      let day = d.getDate();
      let month = d.getMonth() + 1;
      const year = d.getFullYear();
      if (day < 10) {
        day = `0${day}`;
      }
      if (month < 10) {
        month = `0${month}`;
      }
      const date = `${day}/${month}/${year}`;

      return date;
    },
  },
};
</script>
