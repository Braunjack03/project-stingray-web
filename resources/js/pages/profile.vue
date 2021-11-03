<template>
  <Layout>
    <Head title="Profile" />
    <section class="relative">
      <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="pt-32 pb-12 md:pt-40 md:pb-20">
          <!-- Page header -->
          <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
            <h1 class="h1 mb-4" data-aos="fade-up">Profile Settings</h1>
          </div>
          <!-- Form -->
          <div class="max-w-xl mx-auto">
            <div v-if="errors.message" class="text-red-500 text-sm mt-2">
              {{ errors.message }}
            </div>
            <div v-if="success" class="text-green-500 text-center text-sm mt-2">
              {{ success.message }}
            </div>
            <v-form ref="form" v-model="valid">
              <div class="flex flex-wrap -mx-3 mb-4"  v-if="user.profile_image_src">
                <div class="w-full px-3 form-avataar">
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

              <div class="flex flex-wrap -mx-3 form-file-upload">
                <div class="w-full px-3">
                  <label class="block text-gray-300 text-sm font-medium mb-1" for="email"
                    >Profile Image (Recommended 500px x 500px)
                  </label>
                  <v-file-input
                    v-model="user.profile_image"
                    accept="image/*"
                    ref="fileInput"
                    class="fileUpload input-field-outer form-input w-full text-gray-300"
                    @change="onFileChange"
                    outlined
                    dense
                  ></v-file-input>
                    <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>
                </div>
              </div>


              <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                  <label class="block text-gray-300 text-sm font-medium mb-1" for="email"
                    >Name <span class="text-red-600">*</span></label
                  >
                  <v-text-field
                    v-model="user.name"
                    class="form-input w-full input-field-outer text-gray-300"
                    placeholder="Name"
                    :rules="[v => !!v || 'Name is required']"
                    outlined
                    required
                  ></v-text-field>
                  <div v-if="errors.email" class="mt-2 error">{{ errors.name }}</div>
                </div>
              </div>

              <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                  <label
                    class="block text-gray-300 input-field-outer text-sm font-medium mb-1"
                    for="current_job_title"
                    >Current Job Title <span class="text-red-600">*</span></label
                  >
                  <v-text-field
                    v-model="user.current_job_title"
                    class="form-input w-full input-field-outer text-gray-300"
                    placeholder="Current Job Title"
                    outlined
                    required
                    :rules="[v => !!v || 'Current Job Title is required']"
                  ></v-text-field>
                  <div v-if="errors.current_job_title" class="mt-2 error">
                    {{ errors.current_job_title }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                  <label
                    class="block text-gray-300 text-sm font-medium mb-1"
                    for="current_job_title"
                    >Short Bio
                  </label>
                  <v-text-field
                    v-model="user.short_bio"
                    class="form-textarea w-full input-field-outer text-gray-300"
                    placeholder="Short Bio"
                    required
                  ></v-text-field>
                  <div v-if="errors.short_bio" class="mt-2 error">
                    {{ errors.short_bio }}
                  </div>
                </div>
              </div>

              <h4 class="text-2xl mt-2 mb-1">Social Links</h4>

              <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                  <label
                    class="block text-gray-300 text-sm font-medium mb-1"
                    for="current_job_title"
                    >LinkedIn
                  </label>

                  <v-text-field
                    v-model="user.linkedin"
                    class="form-input w-full input-field-outer text-gray-300"
                    placeholder="Linkedin"
                    
                    autocomplete
                  ></v-text-field>
                  <div v-if="errors.short_bio" class="mt-2 error">
                    {{ errors.linkedin }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                  <label
                    class="block text-gray-300 input-field-outer text-sm font-medium mb-1"
                    for="current_job_title"
                    >Github
                  </label>
                  <v-text-field
                    v-model="user.twitter"
                    class="form-input input-field-outer w-full text-gray-300"
                    placeholder="Github"
                    autocomplete
                  ></v-text-field>
                  <div v-if="errors.github" class="mt-2 error">{{ errors.github }}</div>
                </div>
              </div>

              <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                  <label
                    class="block text-gray-300 input-field-outer text-sm font-medium mb-1"
                    for="current_job_title"
                    >Twitter
                  </label>
                  <v-text-field
                    v-model="user.twitter"
                    class="form-input input-field-outer w-full text-gray-300"
                    placeholder="Twitter"
                    autocomplete
                  ></v-text-field>
                  <div v-if="errors.twitter" class="mt-2 error">{{ errors.twitter }}</div>
                </div>
              </div>

              <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3">
                  <v-btn
                    v-if="user.current_resume_src"
                    :href="user.current_resume_src"
                    target="_blank"
                  >
                    <v-icon color="gray darken-2">mdi-file-document</v-icon>
                    {{ user.current_resume_name }}
                  </v-btn>
                  <v-icon
                    v-if="user.current_resume_src"
                    color="gray darken-2"
                    class="ml-auto"
                    @click="removeResume()"
                  >
                    mdi-close-circle</v-icon
                  >
                </div>
              </div>

              <div class="flex flex-wrap -mx-3 mb-4">
                <div class="w-full px-3  form-file-upload">
                  <label
                    class="block text-gray-300 text-sm font-medium mb-1"
                    for="current_job_title"
                    >Current Resume
                  </label>
                  <v-file-input
                    outlined
                    dense
                    v-model="user.current_resume"
                    class="form-input fileUpload w-full input-field-outer text-gray-300"
                  ></v-file-input>
                  <div v-if="errors.current_resume" class="mt-2 error">
                    {{ errors.current_resume }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap -mx-3 mt-6">
                <div class="w-full px-3">
                  <v-btn
                    :disabled="!valid"
                    @click="submit()"
                    class="btn text-white bg-purple-600 hover:bg-purple-700 w-full"
                  >
                    Save Changes
                  </v-btn>
                </div>
              </div>

              <div class="flex flex-wrap -mx-3 mt-6 text-center">
                  <div class="w-full px-3">
                    <p class="text-center">Please fill the required field(s)</p>                        
                  </div>
                </div> 
              <!--label><strong>Current Resume </strong></label>
                        <v-file-input outlined dense v-model="user.current_resume"></v-file-input>
                        <div v-if="errors.current_resume" class="mt-2 error">{{ errors.current_resume }}</div-->

              <!--v-btn v-if="user.current_resume_src" :href="user.current_resume_src" target="_blank">
                        <v-icon color="gray darken-2">mdi-file-document</v-icon> {{user.current_resume_name}}
                        </v-btn>
                          <v-icon v-if="user.current_resume_src" color="gray darken-2" class="ml-auto" @click="removeResume()"> mdi-close-circle</v-icon>

                      
                        <br/><br/><br/>
                        <v-btn  color="success" class="mr-4" @click="submit()" >Save Changes</v-btn-->
            </v-form>
          </div>
        </div>
      </div>
    </section>
  </Layout>
</template>
<script>
import Layout from "./Layout";
import { Head } from "@inertiajs/inertia-vue";

export default {
  components: {
    Head,
    Layout,
  },
  props: {
    errors: Object,
    user: Object,
    success: Object,
  },
  data: () => ({
    message: "",
    valid: true,
    form: {
      profile_image: "",
      current_job_title: "",
      name: "",
      short_bio: "",
      github: "",
      twitter: "",
      current_resume: "",
      profile_image_removed: 0,
      current_resume_removed: 0,
    },
  }),
  
  methods: {
    validate() {
      this.$refs.form.validate();
      return true;
    },
    submit() {
      /*this.$v.$touch();
      if(this.user.name != '' && this.user.current_job_title != '')
      {
        this.$inertia.post("/profile", this.user);
         this.$v.$reset()
      }*/
      this.$inertia.post("/profile", this.user);
    },
    removeImage() {
      this.user.profile_image_src = "";
      this.user.profile_image_removed = 1;
    },
    removeResume() {
      this.user.current_resume_src = "";
      this.user.current_resume_removed = 1;
    },
    onFileChange(e) {
      this.user.profile_image_src = URL.createObjectURL(this.user.profile_image);
    },
  },
};
</script>
