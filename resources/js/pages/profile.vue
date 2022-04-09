<template>
    <Layout>
        <Head title="Profile" />
         <v-overlay :value="overlay">
          <v-progress-circular
            indeterminate
            size="64"
          ></v-progress-circular>
        </v-overlay>
        <section class="relative">

            <div class="max-w-6xl px-4 mx-auto sm:px-6">
                <div class="pb-12 pt-36 md:pt-40 md:pb-20">
                    
                    <!-- Page header -->
                    <div class="max-w-3xl mx-auto text-center pb-9">

                        <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">Job Seeker Profile Settings</h1>
                    </div>
                    <!-- Form -->
                      <Message :message="errors.message"  v-on:hide="hideMessage" :hide="hide" :type="'error'" />
                        <Message :message="success.message"  v-on:hide="hideMessage" :hide="hide" :type="'success'" />
                    <div class="max-w-xl mx-auto">
                      
                        <v-form ref="form">
                            <!-- <div class="flex flex-wrap mb-4" v-if="user.profile_image_src">
                                <div class="w-full px-3 form-avataar">
                                    <v-icon v-if="user.profile_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()">
                                        mdi-close-circle</v-icon>
                                    <v-img :src="user.profile_image_src" max-height="150" max-width="250"></v-img>
                                </div>
                            </div> -->
    
                            <div class="flex flex-nowrap form-file-upload">
                                <div class="w-full px-3">
                                    <label class="block mb-1 text-lg font-medium text-gray-700" for="email">Profile Image (Recommended 500px x 500px)
                                    </label>
                                    <v-file-input v-model="profile_image" accept="image/*" ref="fileInput" class="w-full text-gray-700 fileUpload input-field-outer form-input" @change="onFileChange" outlined dense></v-file-input>
                                </div>
                                
                                 <div v-if="user.profile_image_src" class="w-full px-3 form-avataar">
                                    <v-icon v-if="user.profile_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()">
                                        mdi-close-circle</v-icon>
                                    <v-img :src="user.profile_image_src" max-height="150" max-width="250"></v-img>
                                </div>
                            </div>
    
    
                            <div class="flex flex-wrap mb-4">
                                <div class="w-full px-3">
                                    <label class="block mb-1 text-lg font-medium text-gray-700" for="email">Name <span class="text-red-600">*</span></label
                      >
                     
                      <v-text-field
                        v-model="name"
                        class="w-full text-gray-700 form-input input-field-outer"
                        placeholder="Name"
                        :class="{ 'error--text': $v.name.$error }"
                        @input="$v.name.$touch()" 
                        @blur="$v.name.$touch()"
                        outlined
                        required
                      ></v-text-field>
    
                      <div v-if="$v.name.$error && !$v.name.required"  class="text-lg text-red-500">Name is required</div>
                    </div>
                  </div>
    
                  <div class="flex flex-wrap mb-4">
                    <div class="w-full px-3">
                      <label
                        class="block mb-1 text-lg font-medium text-gray-700 input-field-outer"
                        for="current_job_title"
                        >Current Job Title <span class="text-red-600">*</span></label
                      >
                      <v-text-field
                        v-model="current_job_title"
                        class="w-full text-gray-700 form-input input-field-outer"
                        placeholder="Current Job Title"
                        :class="{ 'error--text': $v.current_job_title.$error }"
                        @input="$v.current_job_title.$touch()" 
                        @blur="$v.current_job_title.$touch()"
                        outlined
                        required
                      ></v-text-field>
                      <div v-if="$v.current_job_title.$error && !$v.current_job_title.required"  class="text-lg text-red-500">Current Job Title is required</div>
    
                    </div>
                  </div>
    
                  <div class="flex flex-wrap mb-4">
                    <div class="w-full px-3">
                      <label
                        class="block mb-1 text-lg font-medium text-gray-700"
                        for="current_job_title"
                        >Short Bio
                      </label>
                                    <v-text-field v-model="short_bio" class="w-full text-gray-700 form-textarea input-field-outer" placeholder="Short Bio"></v-text-field>
                                </div>
                            </div>
    
                            <h4 class="mt-2 mb-1 ml-3 text-2xl text-gray-700">Social Links</h4>
    
                            <div class="flex flex-wrap mb-4">
                                <div class="w-full px-3">
                                    <label class="block mb-1 text-lg font-medium text-gray-700" for="current_job_title">LinkedIn
                      </label>
    
                                    <v-text-field v-model="linkedin" class="w-full text-gray-700 form-input input-field-outer" placeholder="Linkedin" autocomplete></v-text-field>
                                    <div v-if="errors.short_bio" class="mt-2 error">
                                        {{ errors.linkedin }}
                                    </div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap mb-4">
                                <div class="w-full px-3">
                                    <label class="block mb-1 text-lg font-medium text-gray-700 input-field-outer" for="current_job_title">Github
                      </label>
                                    <v-text-field v-model="github" class="w-full text-gray-700 form-input input-field-outer" placeholder="Github" autocomplete></v-text-field>
                                    <div v-if="errors.github" class="mt-2 error">{{ errors.github }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap mb-4">
                                <div class="w-full px-3">
                                    <label class="block mb-1 text-lg font-medium text-gray-700 input-field-outer" for="current_job_title">Twitter
                      </label>
                                    <v-text-field v-model="twitter" class="w-full text-gray-700 form-input input-field-outer" placeholder="Twitter" autocomplete></v-text-field>
                                    <div v-if="errors.twitter" class="mt-2 error">{{ errors.twitter }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap mb-4">
                                <div class="w-full px-3 resumeUploadbtn">
                                    <v-btn v-if="user.current_resume_src" :href="user.current_resume_src" target="_blank">
                                        <v-icon color="gray darken-2">mdi-file-document</v-icon>
                                        {{ user.current_resume_name }}
                                    </v-btn>
                                    <v-icon v-if="user.current_resume_src" color="gray darken-2" class="ml-auto" @click="removeResume()">
                                        mdi-close-circle</v-icon>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap mb-4">
                                <div class="w-full px-3 form-file-upload">
                                    <label class="block mb-1 text-lg font-medium text-gray-700" for="current_job_title">Current Resume
                      </label>
                                    <v-file-input outlined dense v-model="current_resume" class="w-full text-gray-700 form-input fileUpload input-field-outer"></v-file-input>
                                    <div v-if="errors.current_resume" class="mt-2 error">
                                        {{ errors.current_resume }}
                                    </div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap mt-6">
                                <div class="w-full px-3">
                                    <v-btn @click="submit()" class="w-full text-white bg-purple-600 btn hover:bg-purple-700">
                                        Save Changes
                                    </v-btn>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap mt-6 text-center">
                                <div class="w-full px-3">
                                    <p class="text-lg text-center text-gray-700">Please fill the required field(s)</p>
                                </div>
                            </div>
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
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'
 import Message from '../partials/Messages.vue';

export default {
    mixins: [validationMixin],
    validations: {
        name: { required },
        current_job_title: { required }
    },
    components: {
        Head,
        Layout,
        Message
    },
    props: {
        errors: Object,
        user: Object,
        success: Object,
    },
    data() {
        return {
            name: this.user.name,
            profile_image:this.user.profile_image,
            current_job_title: this.user.current_job_title,
            short_bio: this.user.short_bio,
            github: this.user.github,
            linkedin: this.user.linkedin,
            twitter: this.user.twitter,
            current_resume:this.user.current_resume,
            profile_image_removed: 0,
            current_resume_removed: 0,
            hide:0, 
            overlay: false,
        }
    },

    methods: {
        validate() {
            this.$refs.form.validate();
            return true;
        },
        hideMessage() {
            this.hide = 1;
        },
        submit() {
            this.$v.$touch()
            this.overlay = false;
            if (!this.$v.$invalid) {
                console.log('submit');
                let form = {
                    profile_image: this.profile_image,
                    current_job_title: this.current_job_title,
                    name: this.name,
                    short_bio: this.short_bio,
                    github: this.github,
                    linkedin: this.linkedin,
                    twitter: this.twitter,
                    current_resume: this.current_resume,
                    profile_image_removed: this.profile_image_removed,
                    current_resume_removed: this.current_resume_removed,
                };
                console.log('form', form);
                this.hide = 0;
                this.$inertia.post("/profile", form);
                if(this.success && this.success.status == 1){
                  this.overlay = false;
                }

            }
        },
        removeImage() {
            this.user.profile_image_src = '';
            this.profile_image = '';
            this.profile_image_removed = 1;
        },
        removeResume() {
            this.user.current_resume_src = "";
            this.current_resume = '';
            this.current_resume_removed = 1;
        },
        onFileChange(e) {
            this.user.profile_image_src = URL.createObjectURL(this.profile_image);
        },
    },
};
</script>
