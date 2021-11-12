<template>
<Layout>
    <Head title="Create Job" />
    <section class="relative" data-app>
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">


            <div class="max-w-4xl mx-auto">
                  <h3 class="company-title">{{data.company_name}}</h3>   
                  <h2 class="post-title">{{data.name}}</h2>
                  <span class="location">Location : {{data.location}}</span>
                  <span class="post-date">Date Posted: {{data.created_at}}</span>

                  <div v-html="data.content" class="post-detail-wrap"></div>

                  <div class="my-4 text-subtitle-1 ml-20 text-center">
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
import {Link } from '@inertiajs/inertia-vue'
  import Layout from './Layout'
  export default {
     components: {
        Link,
        Layout,
    },
    props: {
      errors : Object,  
      success: Object,
      data : Object,
    },
     data: () => ({
        message: '',
    }),
  }

</script>
