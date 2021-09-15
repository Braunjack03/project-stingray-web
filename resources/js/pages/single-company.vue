<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">
            
             <v-img
                      :src="data.logo_image_url"
                      max-height="150"
                      max-width="250"
                    ></v-img>
            <h2>{{data.name}}</h2>
            <p>{{industries}}</p>
            <br/>

            Location : {{data.location}}<br/>
            Date Posted: {{data.created_at}}<br/>

            Local Employees: {{data.local_employees}}<br/>
            Global Employees: {{data.global_employees}}<br/>

            Year Founded: {{data.year_founded}}<br/>
            <Link :href="data.website_url">View website</Link><br/><br/>

            <h3>About {{data.name}}</h3>
            <div v-html="data.mission"></div>
            
            <br/><br/>
            <h3>Jobs at {{data.name}}</h3>
              <ul v-if="job_posts" id="example-1">
                <li v-for="company in job_posts" :key="company.id">
                  <v-row no-gutters class="mt-5">
                    <v-col cols="8" sm="6" md="8" >
                          <h3>{{ company.name }} ({{ company.location_id }})</h3>
                          <div v-html="company.content"></div>
                    </v-col>
                  </v-row>
                </li>
              </ul>
            </v-card> 
        </v-container>
    </v-app>
</template>
<script>
  import {Link } from '@inertiajs/inertia-vue'
    export default {
         components: {
        Link
        },
    props: {
      errors : Object,  
      success: Object,
      data : Object,
      job_posts:Array,
      industries:String,
    },
     data: () => ({
        message: '',
    }),
  }

</script>
