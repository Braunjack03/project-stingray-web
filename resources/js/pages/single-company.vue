<template>
<Home>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">
              <div v-if="$page.props.flash.message" class="mt-2 success">
            {{ $page.props.flash.message }}
          </div> 
            <v-row >
              <v-col cols="3"> 
             <v-img
                      :src="data.logo_image_url"
                      max-height="150"
                      max-width="250"
                    ></v-img>
            </v-col>        
            <v-col class="mt-12" md="4" cols="8">        
            <h2>{{data.name}} <v-btn v-if="(data.unclaimed) == 1" v-on:click="claimProfile(data.uuid)" class="claim-profile">(Claim this Profile)</v-btn> </h2>
            <p>{{data.industry_types}}</p>
               </v-col>
            </v-row>
            <v-row >
              <v-col offset-md="3" cols="3" md="2"> 
              Location : <br/><strong>{{data.location}}</strong>
                </v-col>        
              <v-col cols="3"> 
              Local Employees: <strong>{{data.local_employees}}</strong><br/>
              Global Employees: <strong>{{data.global_employees}}</strong>
              </v-col>        
              <v-col cols="3"> 
              Year Founded: <strong>{{data.year_founded}}</strong><br/>

              <v-btn icon :href="data.website_url" target="_blank" text>
                View website
              </v-btn>
              </v-col>  
            </v-row>

            <v-row >
              <v-col cols="8" md="8"> 
                <h3>About {{data.name}}</h3>
                <div v-html="data.mission"></div>
              </v-col>  
            </v-row>
             <v-row >
              <v-col cols="12" class="pa-2"> 
                <h3>Jobs at {{data.name}}</h3>
                  <ul v-if="job_posts" id="example-1">
                    <li v-for="company in job_posts" :key="company.id">
                      <v-row no-gutters class="mt-5">
                        <v-col cols="8" sm="6" md="8" >
                              <h4>{{ company.name }} ({{ company.location_id }})</h4>
                              <div v-html="company.content"></div>
                        </v-col>
                      </v-row>
                    </li>
                  </ul>
              </v-col>  
            </v-row>
            </v-card> 
        </v-container>
    </v-app>
    </Home>
</template>
<script>
  import {Link } from '@inertiajs/inertia-vue'
    export default {
         components: {
        Link,
        },
    props: {
      errors : Object,  
      success: Object,
      data : Object,
      job_posts:Array,
    },
     data: () => ({
        message: '',
    }),
    methods :{
      claimProfile(id) {
          this.$inertia.get('/claim-profile/'+id);
        }
    }
  }

</script>
