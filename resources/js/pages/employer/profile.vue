<template>
<Layout>
    <Head title="Employer Profile" />
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">

            <h2>Your Settings  </h2>   
            <h3>Profile</h3>
            <br/>
                <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                <v-form ref="form" v-model="valid" lazy-validations >
    
                    <label>Profile Image (Recommended 500px x 500px) </label>
                    <v-file-input v-model="user.profile_image"  ref="fileInput" @change="onFileChange" show-size counter outlined dense></v-file-input>
                    
                    <v-icon v-if="user.profile_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()"> mdi-close-circle</v-icon>
                    <v-img
                      :src="user.profile_image_src"
                      max-height="150"
                      max-width="250"
                    ></v-img>


                    
                    <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>
                     <br/><br/>   
                    <label>Name</label>
                    <v-text-field v-model="user.name" required></v-text-field>
                    <div v-if="errors.name" class="mt-2 error">{{ errors.name }}</div>

                    <label>Current Job Title</label>
                    <v-text-field v-model="user.current_job_title" required></v-text-field>
                    <div v-if="errors.current_job_title" class="mt-2 error">{{ errors.current_job_title }}</div>
                    
                    <label>Short Bio</label>
                    <v-text-field v-model="user.short_bio" required></v-text-field>
                    <div v-if="errors.short_bio" class="mt-2 error">{{ errors.short_bio }}</div>

                    <h3>Social Links</h3>  

                     <label>LinkedIn</label>
                    <v-text-field v-model="user.linkedin" required></v-text-field>
                    <div v-if="errors.linkedin" class="mt-2 error">{{ errors.linkedin }}</div>
                   
                    <v-btn color="success" class="mr-4" @click="submit()" >Save Changes</v-btn>
                </v-form>
                <br/><br/>
                 <h3>Your Companies</h3>  
                    <ul id="example-1">
                    <li v-for="company in companies" :key="company.id">
                      {{ company.name }} <v-btn :href="'/employer/edit-company?id='+company.uuid" color="text" class="mr-4" @click="edit()" >Edit</v-btn>
                    </li>
                  </ul>
                  <br/>
                  <v-btn href="/employer/create-company" color="" class="mr-4" >Create New Company Profile</v-btn>
            </v-card> 
       
        </v-container>
    </v-app>
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
        const reader = new FileReader();
         const files = this.user.profile_image
         console.log(files);
          if (files) {
            const reader = new FileReader
            reader.onload = e => {
              this.user.profile_image_src = e.target.result
            }
            reader.readAsDataURL(files)
          }
        }
    },
  }

</script>
