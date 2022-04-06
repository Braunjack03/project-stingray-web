<template>
  <Layout>
    <Head title="Create Job" />
    <section
      class="relative"
      data-app
    >
      <div class="max-w-6xl px-4 mx-auto sm:px-6">
           <div class="pt-32 pb-12 md:pt-40 md:pb-20">
            <v-row>
            
            <v-col cols="12" md="3" sm="4">
                <Sidebar :companies="company_uuid" :plan="plan_name" :job_posts_count="job_posts_count"/>
               </v-col>

               <v-col cols="12" md="9" sm="8" class="pl-3 md:pl-8">
                  <div class="pt-0 pb-0 sm:pb-10 sm:pt-11">
                      <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">Post a new Job </h1>
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
                  <label class="block mb-1 text-lg font-medium text-gray-700">Job Title <span class="text-red-600">*</span></label>
                  <v-text-field
                    v-model="name"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Job Title"
                    :class="{ 'error--text': $v.name.$error }"
                    required
                    @input="$v.name.$touch()"
                    @blur="$v.name.$touch()"
                  />
                  <div
                    v-if="$v.name.$error && !$v.name.required"
                    class="text-lg text-red-500"
                  >
                    Job Title is required
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Location <span class="text-red-600">*</span></label>

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
                        class="w-full text-gray-700 form-input input-field-outer"
                        dense
                        solo
                      />
                      <div
                        v-if="$v.location_id.$error && !$v.location_id.required"
                        class="text-lg text-red-500"
                      >
                        Location is required
                      </div>
                    </v-col>
                  </v-row>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Job Category <span class="text-red-600">*</span></label>
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
                        class="w-full text-gray-700 form-input input-field-outer"
                        dense
                        solo
                      />
                      <div
                        v-if="$v.job_cat_id.$error && !$v.job_cat_id.required"
                        class="text-lg text-red-500"
                      >
                        Job Category is required
                      </div>
                    </v-col>
                  </v-row>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700"> Job Application URL <span class="text-red-600">*</span></label>
                  <v-text-field
                    v-model="apply_url"
                    :class="{ 'error--text': $v.apply_url.$error }"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="https://example.com"
                    required
                  />
                  <div
                    v-if="$v.apply_url.$error && !$v.apply_url.required"
                    class="text-lg text-red-500"
                  >
                    Job Application URL is required
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3 textEditor">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Job Description </label>
                  <tiptap-vuetify
                    v-model="content"
                    :extensions="extensions"
                    class="w-full text-gray-700 form-input input-field-outer"
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
                    class="w-full text-white bg-purple-600 btn hover:bg-purple-700"
                    @click="submit()"
                  >
                    Save Changes
                  </v-btn>
                </div>
              </div>

              <div class="flex flex-wrap mt-5 text-center">
                <div class="w-full px-3">
                  <p class="text-lg text-center text-gray-700">
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
import Sidebar from '../../partials/Sidebar.vue';

export default {
  components: {
    Head,
    Layout,
    TiptapVuetify,
    Message,
    Sidebar,
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
