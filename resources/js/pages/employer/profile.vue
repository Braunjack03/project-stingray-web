<template>
  <Layout>
    <Head title="Employer Profile" />
    <section class="relative">
      <div class="max-w-6xl px-4 mx-auto sm:px-6">
        <div class="pb-12 pt-36 md:pt-40 md:pb-20">
          <v-row>
            <v-col cols="12" md="3" sm="4">
              <div class="pb-8">
                                      <h3 class="mb-4 text-gray-700 h3" data-aos="fade-up">Employer <br> Settings</h3>
              </div>
              <ul class="settingLinks">
                <li
                  v-if="plan_name.name"
                  class="text-lg text-gray-700 no-underline"
                >
                  Subscribed to the {{ plan_name.name }} Using
                  {{ job_posts_count }}/{{ plan_name.slot }} job slots (<a
                    class="text-purple-600 upgrade-link"
                    href="/billing"
                    >upgrade</a
                  >)
                </li>
                <li>
                  <a
                    href="/employer/profile"
                    class="text-lg text-purple-700 no-underline"
                    >Your Profile</a
                  >
                </li>
                <li v-if="user.company_profile_count == 1">
                  <a
                    :href="'/employer/edit-company?id=' + companies[0].uuid"
                    class="text-lg text-gray-700 no-underline  hover:text-purple-600"
                    >Company Profile</a
                  >
                </li>
                <li v-if="user.company_profile_count < 1">
                  <a
                    href="/employer/create-company"
                    class="text-lg text-gray-700 no-underline  hover:text-purple-600"
                    >Company Profile</a
                  >
                </li>
                <li v-if="user.company_profile_count == 1">
                  <a
                    :href="'/employer/jobs?c_id=' + companies[0].uuid"
                    class="text-lg text-gray-700 no-underline  hover:text-purple-600"
                    >Job Posts</a
                  >
                </li>
                <li>
                  <a
                    href="/billing"
                    class="text-lg text-gray-700 no-underline  hover:text-purple-600"
                    >Subscription</a
                  >
                </li>
              </ul>
            </v-col>

            <v-col cols="12" md="9" sm="8" class="pl-3 md:pl-8">
              <div class="pt-0 pb-0 sm:pb-10 sm:pt-11">
                <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">
                  Your Profile
                </h1>
              </div>
              <div class="max-w-2xl">
                <Message :message="errors.message" :hide="0" :type="'error'" />
                <Message
                  :message="success.message"
                  :hide="0"
                  :type="'success'"
                />

                <Message
                  :message="$page.props.flash.message"
                  :hide="0"
                  :type="'success'"
                />

                <v-form ref="form" lazy-validations class="form-outer-wrapper">
                  <div class="flex flex-wrap mb-3">
                    <div class="w-full form-avataar">
                      <v-icon
                        v-if="user.profile_image_src"
                        color="gray darken-2"
                        class="ml-auto"
                        @click="removeImage()"
                      >
                        mdi-close-circle</v-icon
                      >
                      <v-img
                        :src="user.profile_image_src"
                        max-height="150"
                        max-width="250"
                      ></v-img>
                    </div>
                  </div>
                  <div class="flex flex-wrap form-file-upload">
                    <div class="w-full">
                      <label
                        class="block mb-1 text-lg font-medium text-gray-700"
                        >Profile Image (Recommended 500px x 500px)
                      </label>
                      <v-file-input
                        class="w-full text-gray-700  fileUpload form-input input-field-outer"
                        accept="image/*"
                        v-model="profile_image"
                        ref="fileInput"
                        @change="onFileChange"
                        outlined
                        dense
                      ></v-file-input>
                    </div>
                  </div>

                  <div class="flex flex-wrap mb-3">
                    <div class="w-full">
                      <label
                        class="block mb-1 text-lg font-medium text-gray-700"
                        for="email"
                        >Name <span class="text-red-600">*</span></label
                      >
                      <v-text-field
                        v-model="name"
                        class="w-full text-gray-700  form-input input-field-outer"
                        placeholder="Enter Name"
                        :class="{ 'error--text': $v.name.$error }"
                        @input="$v.name.$touch()"
                        @blur="$v.name.$touch()"
                        required
                      ></v-text-field>
                      <div
                        v-if="$v.name.$error && !$v.name.required"
                        class="text-lg text-red-500"
                      >
                        Name is required
                      </div>
                    </div>
                  </div>

                  <div class="flex flex-wrap mb-3">
                    <div class="w-full">
                      <label
                        class="block mb-1 text-lg font-medium text-gray-700"
                        for="email"
                        >Current Job Title
                        <span class="text-red-600">*</span></label
                      >
                      <v-text-field
                        v-model="current_job_title"
                        class="w-full text-gray-700  form-input input-field-outer"
                        placeholder="Current Job Title"
                        :class="{ 'error--text': $v.current_job_title.$error }"
                        @input="$v.current_job_title.$touch()"
                        @blur="$v.current_job_title.$touch()"
                        required
                      ></v-text-field>
                      <div
                        v-if="
                          $v.current_job_title.$error &&
                          !$v.current_job_title.required
                        "
                        class="text-lg text-red-500"
                      >
                        Current Job Title is required
                      </div>
                    </div>
                  </div>

                  <div class="flex flex-wrap mb-3">
                    <div class="w-full">
                      <label
                        class="block mb-1 text-lg font-medium text-gray-700"
                        for="email"
                        >Short Bio
                      </label>
                      <v-text-field
                        v-model="short_bio"
                        class="w-full text-gray-700  form-input input-field-outer"
                        placeholder="Short Bio"
                        required
                      ></v-text-field>
                      <div v-if="errors.short_bio" class="mt-2 error">
                        {{ errors.short_bio }}
                      </div>
                    </div>
                  </div>

                  <h3 class="mt-2 mb-1 text-2xl text-gray-700">Social Links</h3>

                  <div class="flex flex-wrap mb-3">
                    <div class="w-full">
                      <label
                        class="block mb-1 text-lg font-medium text-gray-700"
                        for="email"
                        >LinkedIn</label
                      >
                      <v-text-field
                        v-model="linkedin"
                        class="w-full text-gray-700  form-input input-field-outer"
                        placeholder="LinkedIn"
                        required
                      ></v-text-field>
                      <div v-if="errors.linkedin" class="mt-2 error">
                        {{ errors.linkedin }}
                      </div>
                    </div>
                  </div>

                  <div class="flex flex-wrap mt-5">
                    <div class="w-full">
                      <v-btn
                        @click="submit()"
                        class="w-full text-lg text-white bg-purple-600  btn hover:bg-purple-700"
                        >Save Changes</v-btn
                      >
                    </div>
                  </div>

                  <div class="flex flex-wrap mt-5 text-center">
                    <div class="w-full">
                      <p class="text-lg text-center text-gray-700">
                        Please fill the required field(s)
                      </p>
                    </div>
                  </div>
                </v-form>

                <!-- <div class="flex flex-wrap mt-5">
                      <div class="w-full">
                        <Link v-if="(user.company_profile_count < 1)" href="/employer/create-company" color="text" class="w-full mb-3 mr-4 text-lg text-white bg-purple-600 btn hover:bg-purple-700" >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" /> </svg> Create New Company Profile</Link>
                      </div>
                    </div> -->
              </div>
            </v-col>
          </v-row>
        </div>
      </div>
    </section>
  </Layout>
</template>
<script>
import Layout from "../Layout";
import { Head, Link } from "@inertiajs/inertia-vue";
import { validationMixin } from "vuelidate";
import { required } from "vuelidate/lib/validators";
import Message from "../../partials/Messages.vue";

export default {
  mixins: [validationMixin],
  validations: {
    name: { required },
    current_job_title: { required },
  },
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
    companies: Array,
    job_posts_count: Number,
    plan_name: Array && Object,
  },
  data() {
    return {
      name: this.user ? this.user.name : "",
      profile_image: this.user.profile_image,
      current_job_title: this.user.current_job_title,
      short_bio: this.user.short_bio,
      linkedin: this.user.linkedin,
      profile_image_removed: 0,
    };
  },
  methods: {
    submit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        let form = {
          profile_image: this.profile_image,
          current_job_title: this.current_job_title,
          name: this.name,
          short_bio: this.short_bio,
          linkedin: this.linkedin,
          profile_image_removed: this.profile_image_removed,
        };
        this.$inertia.post("/employer/profile", form);
      }
    },
    removeImage() {
      this.user.profile_image_src = "";
      this.profile_image_removed = 1;
    },
    onFileChange(e) {
      this.user.profile_image_src = URL.createObjectURL(this.profile_image);
    },
  },
};
</script>
