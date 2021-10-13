<template>
<Layout>
    <Head title="Job Posts" />
    <v-app app>
        <v-container>
          <h3>Job Posts</h3>
             <div v-if="$page.props.flash.message" class="mt-2 success">
                    {{ $page.props.flash.message }}
                  </div>
             <v-data-table
              :headers="headers"
              :items="job_posts.data"
              :items-per-page="10"
              class="elevation-1"
            ></v-data-table>
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
      job_posts : Object,
    },
     data: (job_posts) => {
       return {
        headers: [
          { text: 'Id', value: 'job_id' },
          {
            text: 'Name',
            align: 'start',
            sortable: false,
            value: 'name',
          },
            { text: 'Company Name', value: 'company_name' },
             { text: 'Created On', value: 'created_at' },
        ],
      }
    },
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
    },
  }

</script>
