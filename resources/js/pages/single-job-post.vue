<template>
  <Home>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">
             <h3>{{data.company_name}}</h3>   
            <h2>{{data.name}}</h2>
            <br/>
            Location : {{data.location}}<br/>
            Date Posted: {{data.created_at}}<br/>

            <div v-html="data.content"></div>

            <div class="my-4 text-subtitle-1 ml-20">
              <v-btn  :href="data.apply_url" target="_blank" text>
                Apply on Company Website
              </v-btn>
            </div>
            </v-card> 
        </v-container>
    </v-app>
  </Home>  
</template>
<script>
import {Link } from '@inertiajs/inertia-vue'
  import Home from './Home'
  export default {
     components: {
        Link,
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
