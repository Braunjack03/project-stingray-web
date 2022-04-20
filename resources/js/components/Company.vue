<template>
    <v-col cols="12" md="12" class="pa-3 d-flex flex-column">
        <v-card class="flex elevation-5 d-flex flex-column cardStyle">
            <v-card-text class="job-card-wrap company-card-wrap">   
                <div class="company-img-block">
                  <v-img
                    :src="(data.logo_image_url) ? data.logo_image_url : '/images/default-company-logo.svg'"
                  ></v-img>
                </div>
                <div class="company-text-block">
                <v-card-title class="p-0"><Link :href="'/companies/'+data.slug" color="text">{{data.name}}</Link></v-card-title> 
                <div class="text-subtitle-1" v-if="data.industry_types"><span>{{data.industry_types}}</span></div>
                <!--p class="description">{{data.description.substring(0,250) | stripHTML}}</p-->
                </div>
                <div class="company-jobs-block">
                <Link :href="'/companies/'+data.slug" color="text" class="">{{(data.job_posts_count == 0) ? 'No Jobs' : (data.job_posts_count == 1) ? 'View '+data.job_posts_count+ ' Job' : 'View '+data.job_posts_count+' Jobs' }} 
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg> -->
                </Link>
                <!--div class="company-location" v-if="data.city">
                    <p><span>{{data.city}}, {{data.state}}</span> Location</p>
                </div-->
                </div>
                <Link :href="'/companies/'+data.slug" class="overlayLink"></Link>
            </v-card-text>
        </v-card>
    </v-col>

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
