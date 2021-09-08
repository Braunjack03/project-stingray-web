<template>
<Layout>
    <Head title="Create Job" />
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">

            <h2>Post a new Job  </h2> 
            <h3>Job Information</h3>
            <br/>
                <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                <v-form ref="form" v-model="valid" validations >
    
                    <label>Job Title* </label>
                    <v-text-field v-model="user.name" required></v-text-field>
                    <div v-if="errors.name" class="mt-2 error">{{ errors.name }}</div>

                    <label>Location*</label>
                     <v-row >
                      <v-col
                        class="d-flex"
                        cols="12"
                      >
                        <v-select
                          v-model='user.location'
                          item-text="name"
                          item-value="id"
                          :items="locations"
                          label="Location"
                        ></v-select>
                      </v-col>
                    <div v-if="errors.state_abbr" class="mt-2 error">{{ errors.state }}</div>
                    </v-row>                   
                    <label>Job Category *</label>
                      <v-row >
                      <v-col
                        class="d-flex"
                        cols="12"
                      >
                        <v-select
                          v-model='user.jobcategory'
                          item-text="name"
                          item-value="id"
                          :items="job_categories"
                          label="Job Category"
                        ></v-select>
                      </v-col>
                    <div v-if="errors.state_abbr" class="mt-2 error">{{ errors.state }}</div>
                    </v-row>

                    <label>Job Application URL *</label>
                    <v-text-field v-model="user.postcode" required></v-text-field>
                    <div v-if="errors.postcode" class="mt-2 error">{{ errors.postcode }}</div>

                    <label>Job Description *</label>
                    <v-text-field v-model="user.linkedin_user"></v-text-field>
                    <div v-if="errors.linkedin_user" class="mt-2 error">{{ errors.linkedin_user }}</div>

                    <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit()" >Save Changes</v-btn>
                </v-form>
                <br/><br/>
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
      job_categories: Array,
      locations : Array,
    },
     data: () => ({
        industry:[],
        message: '',
        valid: true,
        form: {
            profile_image: '',
            name: '',
            logo_image_removed: 0,
            logo_image_src: '',
        },
    }),
     methods: {
      validate () {
        this.$refs.form.validate();
        return true;
      },
      submit() {
            this.user.industry = this.industry;
            this.$inertia.post('/employer/create-job', this.user );
            this.$refs.form.resetValidation();
       },
      removeImage(){
          this.user.logo_image_src = '';
          this.user.logo_image_url = '';
          this.user.logo_image_removed = 1;
      }, 
    },
  }
</script>
