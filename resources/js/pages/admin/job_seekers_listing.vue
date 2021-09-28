<template>
<Layout>
    <Head title="Job Seekers Listing" />
    <v-app app>
        <v-container>
             <div v-if="$page.props.flash.message" class="mt-2 success">
                    {{ $page.props.flash.message }}
                  </div>
            <v-card>
              <v-card-title>
                Job Seekers
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
              </v-card-title>
              <v-data-table
                :headers="headers"
                :items="job_seekers.data"
                :items-per-page="10"
                class="elevation-1"
                :search="search"
              ></v-data-table>
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
      job_seekers : Object,
    },
     data: () => {
       return {
          search: '',
        headers: [
          { text: 'Id', value: 'id' },
          {
            text: 'Current Job Title',
            align: 'start',
            sortable: false,
            value: 'current_job_title',
          },
            { text: 'Job Seeker Name', value: 'name' },
            { text: 'Job Seeker Email', value: 'email' },
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
