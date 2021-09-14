<template>
<Layout>
    <Head title="Job Posts" />
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">
            <h2>{{company_details.name}} Job Posts</h2>
            <br/>
            <Link v-if="companies_count > 0 && job_posts_count < 3" :href="'/employer/create-job?c_id='+company_details.uuid" color="text" class="mr-4" >Add New Job Post</Link>

            <br/><br/><br/>
            <h3>Current Job Posts</h3>
            <br/>

                  <div v-if="$page.props.flash.message" class="mt-2 success">
                    {{ $page.props.flash.message }}
                  </div>  
                  
                    <ul v-if="job_posts" id="example-1">
                    <li v-for="company in job_posts" :key="company.id">

                     <v-row no-gutters class="mt-5">
                        <v-col cols="3" sm="6" md="3" >
                            <Link :href="'/employer/edit-job?id='+company.uuid" class="mr-4 btn" >EDIT</Link> | 
                            <v-btn class="mr-4" v-on:click="deletejob(company.uuid)" color="#3f51b5" plain link >Delete</v-btn>
                          
                        </v-col>
                        <v-col cols="8" sm="6" md="8" >
                              <h3>{{ company.name }}</h3>
                              Location: {{ company.location_id }} <br/>
                              Published: {{ company.created_at }}<br/>
                        </v-col>
                      </v-row>
                    </li>
                  </ul>
                  
                  <br/> 
          
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
      companies_count: Number,
      company_details: Object,
      job_posts_count: Number,
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
      deletejob(id){
          if(confirm("Do you really want to delete?")){
            this.$inertia.get('/employer/delete-job/?id='+id);
          }
          return false;
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
