<template>

    <v-card class="elevation-5 flex d-flex flex-column cardStyle">
      <v-card-text class="job-card-wrap">
        <div class="card-text-wrap">
          <v-card-title><Link :href="'/jobs/'+data.company_slug+'/'+data.job_slug" color="text" class="mr-4">{{data.name}}</Link></v-card-title>      
          <div class="card-outter">
            <div class="text-subtitle-1" v-if="data.company_name">Company Name: <Link class="jobLocationLink" :href="'companies/'+data.company_slug">{{data.company_name}}</Link>
           
            </div>

            <div class="text-subtitle-1 flex item-center" v-if="data.location">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="#5d5dff">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg> {{data.location}}
            </div>
            <div class="description">{{data.content.substring(0,250) | stripHTML}}</div>
            <div class="date">{{timeDifference(new Date(data.created_at)) }} ago</div>
          </div>
          </div>
          <div class="button-outter">
            <Link :href="'/jobs/'+data.company_slug+'/'+data.job_slug" class="text-white bg-purple-600 hover:bg-purple-700 ml-3 viewJobsBtn">VIEW JOB</Link>
             <!--v-btn  :href="data.apply_url" target="_blank" class="text-white bg-purple-600 hover:bg-purple-700">
                Apply Now
              </v-btn-->
          </div>
          <Link :href="'/jobs/'+data.company_slug+'/'+data.job_slug" class="overlayLink"></Link>
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
