<template>
   <div>
         <v-app app>
            <v-container>
               <v-row>
                  <v-col v-for="data in $props.restaurants" :key="data.id">
                     <CustomCard :data="data"/>
                  </v-col>
               </v-row>
            </v-container>
        </v-app>
   </div>
</template>

<script>
import Card from '../components/Card.vue';

export default {
   components: {
      'CustomCard': Card
   },
   props: ['restaurants']
}
</script>