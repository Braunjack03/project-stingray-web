<template>
<Layout>
    <Head title="Job Posts" />
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">

            <h3>Job Posts</h3>
            <br/>

                  <div v-if="$page.props.flash.message" class="mt-2 success">
                    {{ $page.props.flash.message }}
                  </div>  

                  
                    <ul v-if="showCreate === false" id="example-1">
                    <li v-for="company in job_posts" :key="company.id">
                      {{ company.name }}
                    </li>
                  </ul>
                  <br/>
                    
                <Link href="/employer/create-job" color="text" class="mr-4" >Create New Job Post</Link>
          
            </v-card> 
       
        </v-container>
    </v-app>
</Layout>
</template>
<script>
  import Layout from './Layout'
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
      job_posts : Array,
    },
     data: () => ({
        message: '',
        showCreate:false,
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
      showCreateForm() {
          this.showCreate = true;
      }
    },
  }

</script>
