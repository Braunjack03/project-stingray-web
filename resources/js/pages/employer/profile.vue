<template>
<Layout>
    <Head title="Employer Profile" />
    <section class="relative">
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                <h1 class="h1 mb-4" data-aos="fade-up">Profile Settings </h1>
            </div>
           
              <div class="max-w-xl mx-auto">

                  <div v-if="errors.message" class="text-red-500 text-center text-sm mb-4">{{ errors.message }}</div>
                  <div v-if="success" class="text-green-500 text-center text-sm mb-4">{{ success.message }}</div>

                  <div v-if="$page.props.flash.message" class="text-green-500 text-center text-sm mb-4">
                  {{ $page.props.flash.message }}
                </div>
                <v-form ref="form" v-model="valid" lazy-validations class="form-outer-wrapper max-w-xl">
    
                    
                    <div class="flex flex-wrap -mx-3 mb-4">
                      <div class="w-full px-3 form-avataar">
                          <v-icon v-if="user.profile_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()"> mdi-close-circle</v-icon>
                          <v-img
                            :src="user.profile_image_src"
                            max-height="150"
                            max-width="250"></v-img>
                      </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 form-file-upload">
                      <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1">Profile Image (Recommended 500px x 500px) </label>
                          <v-file-input class="fileUpload form-input input-field-outer w-full text-gray-300" accept="image/*" v-model="profile_image"  ref="fileInput" @change="onFileChange" outlined dense></v-file-input>
                      </div>
                    </div>

                    
                    <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>

                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Name <span class="text-red-600">*</span></label>
                           <v-text-field v-model="name" class="form-input input-field-outer w-full text-gray-300" placeholder="Enter Name" :class="{ 'error--text': $v.name.$error }"
                              @input="$v.name.$touch()" 
                              @blur="$v.name.$touch()" required></v-text-field>
                            <div v-if="$v.name.$error && !$v.name.required"  class="text-red-500 text-sm">Name is required</div>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Current Job Title <span class="text-red-600">*</span></label>
                           <v-text-field v-model="current_job_title" class="form-input input-field-outer w-full text-gray-300" placeholder="Current Job Title" 
                            :class="{ 'error--text': $v.current_job_title.$error }"
                            @input="$v.current_job_title.$touch()" 
                            @blur="$v.current_job_title.$touch()"
                           required></v-text-field>
                          <div v-if="$v.current_job_title.$error && !$v.current_job_title.required"  class="text-red-500 text-sm">Current Job Title is required</div>

                        </div>
                    </div>
                    
                     <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                            <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Short Bio </label>
                            <v-text-field v-model="short_bio" class="form-input input-field-outer w-full text-gray-300" placeholder="Short Bio" required></v-text-field>
                            <div v-if="errors.short_bio" class="mt-2 error">{{ errors.short_bio }}</div>
                      </div>
                    </div>

                    <h3 class="text-2xl mt-2 mb-1">Social Links</h3>  

                    <div class="flex flex-wrap -mx-3 mb-4">
                      <div class="w-full px-3">
                            <label class="block text-gray-300 text-sm font-medium mb-1" for="email">LinkedIn</label>
                            <v-text-field v-model="linkedin" class="form-input input-field-outer w-full text-gray-300" placeholder="LinkedIn" required></v-text-field>
                            <div v-if="errors.linkedin" class="mt-2 error">{{ errors.linkedin }}</div>
                      </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mt-6">
                        <div class="w-full px-3">
                          <v-btn @click="submit()" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full">Save Changes</v-btn>
                        </div>
                      </div> 
                      
                    <div class="flex flex-wrap -mx-3 mt-6 text-center">
                        <div class="w-full px-3">
                          <p class="text-center">Please fill the required field(s)</p>                        
                        </div>
                      </div> 
                </v-form>
                <div class="flex flex-wrap -mx-3 mt-6">
                        <div class="w-full px-3">
                 <h3 class="text-2xl mb-3">Your Companies</h3>  
                  <ul id="example-1">                     
                    <li v-for="company in companies" :key="company.id" class="flex flex-wrap justify-between">                     
                      <span class="w-full text-sm mb-2">{{ company.name }}</span>
                      <Link :href="'/employer/edit-company?id='+company.uuid" color="text" class="btn text-white bg-purple-600 hover:bg-purple-700 mb-3" @click="edit()" > 
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor"> <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" /> </svg> Manage Profile</Link>
                      <Link :href="'/employer/jobs?c_id='+company.uuid" color="text" class="btn text-white bg-purple-600 hover:bg-purple-700 mb-3" > 
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor"> <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" /> </svg> Manage Jobs</Link>
                    </li>
                  </ul>
                </div>
              </div>
                  
              <div class="flex flex-wrap -mx-3 mt-6">
                <div class="w-full px-3">
                  <Link v-if="(user.company_profile_count < 3)" href="/employer/create-company" color="text" class="btn text-white bg-purple-600 hover:bg-purple-700 mb-3 mr-4 w-full" >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor"> <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" /> </svg> Create New Company Profile</Link>
                </div>
              </div>
             </div>
            </div>
        </div>
    </section>
</Layout>
</template>
<script>
  import Layout from '../Layout'
  import { Head,Link } from '@inertiajs/inertia-vue'
  import { validationMixin } from 'vuelidate'
import { required} from 'vuelidate/lib/validators'

  export default {
      mixins: [validationMixin],
     validations: {
      name: { required},
      current_job_title: {required}
    },
    components: {
      Head,
      Layout,
      Link
    },
    props: {
      errors : Object,  
      user: Object,
      success: Object,
      companies : Array,
    },
    data (){
     return {
        name: this.user.name,
        profile_image: this.user.profile_image,
        current_job_title: this.user.current_job_title,
        short_bio: this.user.short_bio,
        linkedin: this.user.linkedin,
        profile_image_removed:0,
     }
  },
     methods: {
      submit() {
         this.$v.$touch()
          if(!this.$v.$invalid) {
              let form = {
                  profile_image: this.profile_image,
                  current_job_title: this.current_job_title,
                  name: this.name,
                  short_bio: this.short_bio,
                  linkedin: this.linkedin,
                  profile_image_removed: this.profile_image_removed,
                };
                console.log('form',form);
              this.$inertia.post("/employer/profile", form);
          }
       },
      removeImage(){
          this.user.profile_image_src = '';
          this.profile_image_removed = 1;
      }, 
      onFileChange(e) {
          this.user.profile_image_src = URL.createObjectURL(this.profile_image);
        }
    },
  }

</script>
