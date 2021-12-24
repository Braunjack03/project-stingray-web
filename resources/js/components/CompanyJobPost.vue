<template>

    <v-card class="elevation-5 flex d-flex flex-column cardStyle">
      <v-card-text class="job-card-wrap companyCard">
        <div class="card-text-wrap">
          <v-card-title><Link :href="'/jobs/'+data.company_slug+'/'+data.job_slug" color="text" class="mr-4">{{data.name}}</Link></v-card-title>      
          <div class="card-outter">
            <div class="cardTags" v-if="data.company_name">{{data.company_name}} | {{data.location}} | Posted {{timeDifference(new Date(data.created_at)) }} ago</div>

            <div class="description">{{data.content.substring(0,250) | stripHTML}}</div>
          </div>
          </div>
          <div class="button-outter">
            <Link :href="'/jobs/'+data.company_slug+'/'+data.slug" class="text-white bg-purple-600 hover:bg-purple-700 ml-3 viewJobsBtn">View Job</Link>
             <!--v-btn  :href="data.apply_url" target="_blank" class="text-white bg-purple-600 hover:bg-purple-700">
                Apply Now
              </v-btn-->
          </div>
          <Link :href="'/jobs/'+data.company_slug+'/'+data.slug" class="overlayLink"></Link>
        </v-card-text>

    </v-card>

</template>

<script>
  import {Link } from '@inertiajs/inertia-vue'
    export default {
         components: {
        Link
        },
        props: ['data'],
          methods: {
         diff_weeks(dt2, dt1) 
          {

            var diff =(dt2.getTime() - dt1.getTime()) / 1000;
            diff /= (60 * 60 * 24 * 7);
            return Math.abs(Math.round(diff));
           },
        timeDifference(date){
            var seconds = Math.floor((new Date() - date) / 1000);

            var interval = seconds / 31536000;

            if (interval > 1) {
              return Math.floor(interval) + " years";
            }
            interval = seconds / 2592000;
            if (interval > 1) {
              return Math.floor(interval) + (Math.floor(interval) > 1 ? " months" : " month");

            }
            interval = seconds / 604800;
            if (interval > 1) {
              return Math.floor(interval) + (Math.floor(interval) > 1 ? " weeks" : " week");
            }
            interval = seconds / 86400;
            if (interval > 1) {
              return Math.floor(interval) + (Math.floor(interval) > 1 ? " days" : " day");

            }
            interval = seconds / 3600;
            if (interval > 1) {
              return Math.floor(interval) + (Math.floor(interval) > 1 ? " hours" : " hour");

            }
            interval = seconds / 60;
            if (interval > 1) {
              return Math.floor(interval) + (Math.floor(interval) > 1 ? " minutes" : " minute");

            }
            return Math.floor(seconds) + " seconds";
        }   
    }
  }
</script>
