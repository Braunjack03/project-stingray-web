<template>
<Layout>
    <Head :title="'Job List | '+ data.company_name" />
    <section class="relative" data-app>
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">
            <div class="max-w-4xl mx-auto">
                  <h3 class="company-title">{{data.company_name}}</h3>   
                  <h2 class="post-title">{{data.name}}</h2>
                  <span class="location">Location : {{data.location}}</span>
                  <span class="post-date">Date Posted: {{setDateFormat(data.created_at)}}</span>

                  <div v-html="data.content" class="post-detail-wrap"></div>

                  <div class="my-4 text-subtitle-1 text-center">
                    <v-btn  :href="data.apply_url" target="_blank" class="bg-purple-600 hover:bg-purple-700">
                      Apply on Company Website
                    </v-btn>
                  </div>
              </div>
             </div>
            </div>
    </section>
</Layout>
</template>
<script>
import {Link,Head } from '@inertiajs/inertia-vue'
  import Layout from './Layout'
  export default {
     components: {
        Link,
        Layout,
        Head,
    },
    props: {
      errors : Object,  
      success: Object,
      data : Object,
    },
     data: () => ({
        message: '',
    }),
    methods : {
         setDateFormat(dateObject) {
            var d = new Date(dateObject);
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
            day = "0" + day;
            }
            if (month < 10) {
            month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;

            return date;
         },
    }
  }

</script>
