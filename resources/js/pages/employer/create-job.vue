<template>
  <Layout>
    <Head title="Create Job" />
    <section
      class="relative"
      data-app
    >
      <div class="max-w-6xl mx-auto px-4 sm:px-6">
           <div class="pt-32 pb-12 md:pt-40 md:pb-20">
            <v-row>
            
            <v-col cols="12" md="3" sm="4">
                <div class="pb-8">
                    <h2 class="h2 mb-4 text-gray-700" data-aos="fade-up">Made in <br> Tampa <br> Settings </h2>
                </div>
                <ul class="settingLinks">
                   <li v-if="plan_name.name" class="no-underline text-lg text-gray-700">
                        Subscribed to the {{plan_name.name}} Using {{job_posts_count}}/{{plan_name.slot}} job slots (<a class="upgrade-link text-purple-600" href="/billing">upgrade</a>)
                      </li>
                    <li>
                      <a href="/employer/profile" class="no-underline text-lg text-gray-700 hover:text-purple-600">Your Profile</a>
                    </li>
                    <li >
                      <a :href="'/employer/edit-company?id='+company_uuid" class="no-underline text-lg text-gray-700 hover:text-purple-600">Company Profile</a>
                    </li>
                    <li >
                      <a :href="'/employer/jobs?c_id='+company_uuid" class="no-underline text-lg text-purple-700">Job Posts</a>
                    </li>
                    <li>
                      <a href="/billing" class="no-underline text-lg text-gray-700 hover:text-purple-600">Subscription</a>
                    </li>
                </ul>
               </v-col>

               <v-col cols="12" md="9" sm="8" class="pl-3 md:pl-8">
                  <div class="pb-0 sm:pb-10 pt-0 sm:pt-11">
                      <h1 class="h1 mb-4 text-gray-700" data-aos="fade-up">Post a new Job </h1>
                  </div>
                    <div class="max-w-2xl">
            <Message
              :message="errors.message"
              :hide="0"
              :type="'error'"
            />
            <Message
              :message="success.message"
              :hide="0"
              :type="'success'"
            />
            <v-form ref="form">
              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block text-gray-700 text-lg font-medium mb-1">Job Title <span class="text-red-600">*</span></label>
                  <v-text-field
                    v-model="name"
                    class="form-input input-field-outer w-full text-gray-700"
                    placeholder="Job Title"
                    :class="{ 'error--text': $v.name.$error }"
                    required
                    @input="$v.name.$touch()"
                    @blur="$v.name.$touch()"
                  />
                  <div
                    v-if="$v.name.$error && !$v.name.required"
                    class="text-red-500 text-lg"
                  >
                    Job Title is required
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block text-gray-700 text-lg font-medium mb-1">Location <span class="text-red-600">*</span></label>

                  <v-row>
                    <v-col
                      class="d-flex"
                      cols="12"
                    >
                      <v-select
                        v-model="location_id"
                        item-text="name"
                        item-value="id"
                        :items="locations"
                        label="Location"
                        :class="{ 'error--text': $v.location_id.$error }"
                        class="form-input input-field-outer w-full text-gray-700"
                        dense
                        solo
                      />
                      <div
                        v-if="$v.location_id.$error && !$v.location_id.required"
                        class="text-red-500 text-lg"
                      >
                        Location is required
                      </div>
                    </v-col>
                  </v-row>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block text-gray-700 text-lg font-medium mb-1">Job Category <span class="text-red-600">*</span></label>
                  <v-row>
                    <v-col
                      class="d-flex"
                      cols="12"
                    >
                      <v-select
                        v-model="job_cat_id"
                        item-text="name"
                        item-value="id"
                        :items="job_categories"
                        label="Job Category"
                        :class="{ 'error--text': $v.job_cat_id.$error }"
                        class="form-input input-field-outer w-full text-gray-700"
                        dense
                        solo
                      />
                      <div
                        v-if="$v.job_cat_id.$error && !$v.job_cat_id.required"
                        class="text-red-500 text-lg"
                      >
                        Job Category is required
                      </div>
                    </v-col>
                  </v-row>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block text-gray-700 text-lg font-medium mb-1"> Job Application URL <span class="text-red-600">*</span></label>
                  <v-text-field
                    v-model="apply_url"
                    :class="{ 'error--text': $v.apply_url.$error }"
                    class="form-input input-field-outer w-full text-gray-700"
                    placeholder="https://example.com"
                    required
                  />
                  <div
                    v-if="$v.apply_url.$error && !$v.apply_url.required"
                    class="text-red-500 text-lg"
                  >
                    Job Application URL is required
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3 textEditor">
                <div class="w-full px-3">
                  <label class="block text-gray-700 text-lg font-medium mb-1">Job Description </label>
                  <tiptap-vuetify
                    v-model="content"
                    :extensions="extensions"
                    class="form-input input-field-outer w-full text-gray-700"
                    placeholder="Write something …"
                  />
                  <!--quill-editor
                    v-model="content"
                    :content="content"
                    :options="editorOption"
                  /-->
                </div>
              </div>

              <div class="flex flex-wrap mt-5">
                <div class="w-full px-3">
                  <v-btn
                    class="btn text-white bg-purple-600 hover:bg-purple-700 w-full"
                    @click="submit()"
                  >
                    Save Changes
                  </v-btn>
                </div>
              </div>

              <div class="flex flex-wrap mt-5 text-center">
                <div class="w-full px-3">
                  <p class="text-center text-gray-700 text-lg">
                    Please fill the required field(s)
                  </p>
                </div>
              </div>
            </v-form>
          </div>
          </v-col>
        </v-row>
        </div>
      </div>
    </section>
  </Layout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue';
import {
  TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History
} from 'tiptap-vuetify';
import { validationMixin } from 'vuelidate';
import { required } from 'vuelidate/lib/validators';
import Layout from '../Layout.vue';
import Message from '../../partials/Messages.vue';

export default {
  components: {
    Head,
    Layout,
    TiptapVuetify,
    Message,
  },
  mixins: [validationMixin],
  validations: {
    name: { required },
    location_id: { required },
    job_cat_id: { required },
    apply_url: { required },
  },
  props: {
    errors: Object,
    user: Object,
    success: Object,
    job_categories: Array,
    locations: Array,
    company_uuid: String,
    job_posts_count: Number,
    plan_name: Array && Object,
  },
  data() {
    return {
      name: this.user.name,
      apply_url: this.user.apply_url,
      job_cat_id: this.user.job_cat_id,
      location_id: this.user.location_id,
      company_uuid: this.user.company_uuid,
      extensions: [
        History,
        Blockquote,
        Link,
        Underline,
        Strike,
        Italic,
        ListItem,
        BulletList,
        OrderedList, [Heading, {
          options: {
            levels: [1, 2, 3],
          },
        }],
        Bold,
        Code,
        HorizontalRule,
        Paragraph,
        HardBreak,
      ],
      content: `
       <br/>
        <br/>
        <br/>
        `,
    };
  },
  methods: {
    submit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        const form = {
          name: this.name,
          apply_url: this.apply_url,
          job_cat_id: this.job_cat_id,
          location_id: this.location_id,
          content: this.content,
        };
        this.$inertia.post(`/employer/create-job?c_id=${this.company_uuid}`, form);
      }
    },
  },
};
</script>
