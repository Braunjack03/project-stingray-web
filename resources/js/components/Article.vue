<template>
     <v-col cols="12" md="4" sm="6" >
      <div class="postBlock">
          <div class="postBlock--img">
              <img :src="data.header_image" :alt="data.title">
          </div>
          <div class="postBlock--content">
                <button class="text-white rounded-full" :class="tag.name.toLowerCase()+'Btn'" v-for="tag in data.tags" :key="tag.id">
                  {{tag.name}}
                </button>
              <h3 class="postBlock--title"><Link :href="'/articles/'+data.slug"> {{data.title}}</Link></h3>
              <p>{{data.content.substring(0,250) | stripHTML}}</p>
              <div class="postPersonal--detail">
                <img src="/images/news-author-01.jpg" :alt="data.title">
                <p><a href="#">{{data.name}} </a> - {{new Date(data.created_at).toDateString().slice(4,10)+','+new Date(data.created_at).toDateString().slice(10)}}</p>
              </div>
          </div>
        </div>
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
