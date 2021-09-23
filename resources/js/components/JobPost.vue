<template>

    <v-card class="elevation-5 flex d-flex flex-column" max-width="600">
        <v-card-title><Link :href="'jobs/'+data.company_slug+'/'+data.job_slug" color="text" class="mr-4">{{data.name}}</Link></v-card-title>

        <v-card-text>
            <v-row align="center" class="mx-0">
            </v-row>

            <div class="my-4 text-subtitle-1">
            Company Name: <Link :href="'companies/'+data.company_slug">{{data.company_name}}</Link>
            </div>

            <div class="my-4 text-subtitle-1">
             <v-btn  :href="data.apply_url" target="_blank" text>
                Apply Now
              </v-btn>
            </div>

            <div>{{data.content.substring(0,250) | stripHTML}}</div>
            <div>{{timeDifference(new Date(data.created_at)) }} ago</div>

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
