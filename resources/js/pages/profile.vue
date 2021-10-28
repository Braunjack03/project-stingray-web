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
                  <div v-if="errors.message" class="text-red-500 text-sm mt-2">{{ errors.message }}</div>
                  <div v-if="success" class="text-green-500 text-sm mt-2">{{ success.message }}</div>
                    <form class="login-form">


                        <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Profile Image (Recommended 500px x 500px) </label>

                          <input type="file" name="profile_image"  accept="image/*" @change="onFileChange" class="form-input w-full text-gray-300" />

                        </div>
                      </div>

                        <!--v-file-input v-model="user.profile_image" accept="image/*" ref="fileInput" @change="onFileChange" outlined dense></v-file-input>
                        
                        <v-icon v-if="user.profile_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()"> mdi-close-circle</v-icon>
                        <v-img
                          :src="user.profile_image_src"
                          max-height="150"
                          max-width="250"
                        ></v-img-->

                        
                        <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>
                        
                      <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Name <span class="text-red-600">*</span></label>
                        <input id="name" type="text" v-model="user.name" class="form-input w-full text-gray-300" placeholder="Name" autocomplete required />
                          <div v-if="errors.email" class="mt-2 error">{{ errors.name }}</div>
                        </div>
                      </div>


                      <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="current_job_title">Current Job Title <span class="text-red-600">*</span></label>
                          <input type="text" v-model="user.current_job_title" class="form-input w-full text-gray-300" placeholder="Current Job Title" autocomplete required />
                          <div v-if="errors.current_job_title" class="mt-2 error">{{ errors.current_job_title }}</div>
                        </div>
                      </div>

                      <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="current_job_title">Short Bio </label>
                          <textarea id="message" rows="4" class="form-textarea w-full text-gray-300" placeholder="Short Bio"></textarea>
                          <div v-if="errors.short_bio" class="mt-2 error">{{ errors.short_bio }}</div>
                        </div>
                      </div>
                        
          
                        <h4 class="h4">Social Links</h4>  

                      <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="current_job_title">LinkedIn </label>
                        <input type="text" v-model="user.linkedin" class="form-input w-full text-gray-300" placeholder="Linkedin" autocomplete />
                          <div v-if="errors.short_bio" class="mt-2 error">{{ errors.linkedin }}</div>
                        </div>
                      </div>

                      <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="current_job_title">Github </label>
                        <input type="text" v-model="user.linkedin" class="form-input w-full text-gray-300" placeholder="Github" autocomplete />
                          <div v-if="errors.github" class="mt-2 error">{{ errors.github }}</div>
                        </div>
                      </div>

                      <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="current_job_title">Twitter </label>
                          <input type="text" v-model="user.twitter" class="form-input w-full text-gray-300" placeholder="Twitter" autocomplete />
                          <div v-if="errors.twitter" class="mt-2 error">{{ errors.twitter }}</div>
                        </div>
                      </div>
                        

                      <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="current_job_title">Current Resume </label>
                          <input type="file" name="current_resume" class="form-input w-full text-gray-300" />
                          <div v-if="errors.current_resume" class="mt-2 error">{{ errors.current_resume }}</div>
                        </div>
                      </div> 

                      <div class="flex flex-wrap -mx-3 mt-6">
                        <div class="w-full px-3">
                          <button type="button" @click="submit()" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full">Save Changes</button>
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
                    </form>
                </div>
            </div>
        </div>
      </section>
</Layout>
</template>
<script>
  import Layout from './Layout'
  import { Head } from '@inertiajs/inertia-vue'
  export default {
    components: {
      Head,
      Layout,
    },
    props: {
      errors : Object,  
      user: Object,
      success: Object,
    },
     data: () => ({
        message: '',
        valid: true,
        form: {
            profile_image: '',
            current_job_title: '',
            name: '',
            short_bio: '',
            github: '',
            twitter: '',
            current_resume: '',
            profile_image_removed: 0,
            current_resume_removed: 0,
        },
    }),
     methods: {
      validate () {
        this.$refs.form.validate();
        return true;
      },
      submit() {
            this.$inertia.post('/profile', this.user );
       },
      removeImage(){
          this.user.profile_image_src = '';
          this.user.profile_image_removed = 1;
      }, 
      removeResume(){
          this.user.current_resume_src = '';
          this.user.current_resume_removed = 1;
      }, 
      onFileChange(e) {
        this.user.profile_image_src = URL.createObjectURL(this.user.profile_image);
        }
    },
  }
</script>
