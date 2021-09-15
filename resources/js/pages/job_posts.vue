<template>
   <div>
         <v-app app>
            <v-container>
                <h2>Project Stingray</h2>
               <v-row >
                  <v-col cols="3" v-for="data in $props.job_posts" :key="data.id">
                     <CustomCard :data="data"/>
                  </v-col>
               </v-row>
            </v-container>
        </v-app>
   </div>
</template>

<script>
//import Card from '../components/Card.vue';
import JobPost from '../components/JobPost.vue';

export default {
   components: {
      'CustomCard': JobPost
   },
   props: ['job_posts']
}
</script>
