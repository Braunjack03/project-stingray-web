<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">
             <h3>{{data.company_name}}</h3>   
            <h2>{{data.name}}</h2>
            <br/>
            Location : {{data.location}}<br/>
            Date Posted: {{data.created_at}}<br/>

            <div v-html="data.content"></div>
          
            </v-card> 
        </v-container>
    </v-app>
</template>
<script>
  export default {
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
