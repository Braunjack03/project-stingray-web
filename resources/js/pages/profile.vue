<template>
<Layout>
    <Head title="Profile" />
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" max-width="800" elevation="2">

            <h2>Your Settings  </h2>   
            <h3>Profile</h3>
            <br/>
                <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                <v-form ref="form" v-model="valid" lazy-validations >

                    <label>Profile Image</label>
                    <v-file-input show-size counter outlined dense></v-file-input>

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

                     <label>Github</label>
                    <v-text-field v-model="user.github" required></v-text-field>
                    <div v-if="errors.github" class="mt-2 error">{{ errors.github }}</div>

                     <label>Twitter</label>
                    <v-text-field v-model="user.twitter" required></v-text-field>
                    <div v-if="errors.twitter" class="mt-2 error">{{ errors.twitter }}</div>
                    
                    <label>Current Resume</label>
                    <v-file-input show-size counter outlined dense v-model="user.current_resume"></v-file-input>
                    <div v-if="errors.current_resume" class="mt-2 error">{{ errors.current_resume }}</div>

                    <v-btn  color="success" class="mr-4" @click="submit()" >Save Changes</v-btn>
                </v-form>
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
    },
     data: () => ({
        message: '',
        valid: true,
        user: {
            name: '',
            email: '',
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            password: '',
            passwordRules : [
                v => !!v || 'Password is required',
            ],
            short_bio: '',
            github: '',
            twitter: '',
            current_resume: '',

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
    },
  }
</script>
