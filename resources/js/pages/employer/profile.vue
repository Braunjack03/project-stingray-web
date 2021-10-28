<template>
<Layout>
    <Head title="Employer Profile" />
    <section class="relative">
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                <h1 class="h1 mb-4" data-aos="fade-up">Profile Settings</h1>
            </div>
           
                <div v-if="$page.props.flash.message" class="mt-2 success">
                {{ $page.props.flash.message }}
              </div>
              <div class="max-w-xl mx-auto">
                  <div v-if="errors.message" class="text-red-500 text-sm mt-2">{{ errors.message }}</div>
                  <div v-if="success" class="text-green-500 text-sm mt-2">{{ success.message }}</div>
                <v-form ref="form" v-model="valid" lazy-validations >
    
          
                    <label>Profile Image (Recommended 500px x 500px) </label>
                    <v-file-input class="fileUpload" accept="image/*" v-model="user.profile_image"  ref="fileInput" @change="onFileChange" outlined dense></v-file-input>
                    
                    <v-icon v-if="user.profile_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()"> mdi-close-circle</v-icon>
                    <v-img
                      :src="user.profile_image_src"
                      max-height="150"
                      max-width="250"
                    ></v-img>


                    
                    <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>

                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Name <span class="text-red-600">*</span></label>
                           <v-text-field v-model="user.name" class="form-input w-full text-gray-300" required></v-text-field>
                          <div v-if="errors.email" class="mt-2 error">{{ errors.name }}</div>
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Current Job Title </label>
                           <v-text-field v-model="user.current_job_title" class="form-input w-full text-gray-300" required></v-text-field>
                          <div v-if="errors.current_job_title" class="mt-2 error">{{ errors.current_job_title }}</div>
                        </div>
                    </div>
                    
                     <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                            <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Short Bio </label>
                            <v-text-field v-model="user.short_bio" class="form-input w-full text-gray-300" required></v-text-field>
                            <div v-if="errors.short_bio" class="mt-2 error">{{ errors.short_bio }}</div>
                      </div>
                    </div>

                    <h3>Social Links</h3>  

                    <div class="flex flex-wrap -mx-3 mb-4">
                      <div class="w-full px-3">
                            <label class="block text-gray-300 text-sm font-medium mb-1" for="email">LinkedIn</label>
                            <v-text-field v-model="user.linkedin" class="form-input w-full text-gray-300"  required></v-text-field>
                            <div v-if="errors.linkedin" class="mt-2 error">{{ errors.linkedin }}</div>
                      </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mt-6">
                        <div class="w-full px-3">
                          <v-btn @click="submit()" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full">Save Changes</v-btn>
                        </div>
                      </div> 

                </v-form>
                <br/><br/>
                 <h3>Your Companies</h3>  
                    <ul id="example-1">
                     
                    <li v-for="company in companies" :key="company.id">
                     
                      {{ company.name }} <br/><Link :href="'/employer/edit-company?id='+company.uuid" color="text" class="mr-4" @click="edit()" >Manage Profile</Link>
                      <br/>
                      <Link :href="'/employer/jobs?c_id='+company.uuid" color="text" class="mr-4" >Manage Jobs</Link>
                      <br/><br/>
                    </li>
                  </ul>
                  <br/>

                  <Link v-if="(user.company_profile_count < 3)" href="/employer/create-company" color="text" class="mr-4" >Create New Company Profile</Link>
             </div>
            </div>
        </div>
    </section>
</Layout>
</template>
<script>
  import Layout from '../Layout'
  import { Head,Link } from '@inertiajs/inertia-vue'
  export default {
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
     data: () => ({
        message: '',
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
      validate () {
        this.$refs.form.validate();
        return true;
      },
      submit() {
            this.$inertia.post('/employer/profile', this.user );
       },
      removeImage(){
          this.user.profile_image_src = '';
          this.user.profile_image_removed = 1;
      }, 
      onFileChange(e) {
          this.user.profile_image_src = URL.createObjectURL(this.user.profile_image);
        }
    },
  }

</script>
