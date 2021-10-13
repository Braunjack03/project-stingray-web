<template>
<Layout>
    <Head title="Employers Listing" />
    <v-app app>
        <v-container>
          <h3>Employers</h3>
             <div v-if="$page.props.flash.message" class="mt-2 success">
                    {{ $page.props.flash.message }}
                  </div>
             <v-data-table
              :headers="headers"
              :items="employers.data"
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
      employers : Object,
    },
     data: () => {
       return {
        headers: [
          { text: 'Id', value: 'id' },
          {
            text: 'Current Job Title',
            align: 'start',
            sortable: false,
            value: 'current_job_title',
          },
            { text: 'Employer Name', value: 'name' },
            { text: 'Employer Email', value: 'email' },
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
