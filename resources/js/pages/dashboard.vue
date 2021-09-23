<template>
  <Layout>
    <Head title="Welcome" />
    <v-app app>
        <v-container>
             <p v-if="(user.is_email_verified === 0)" class="error">Your email is not verified yet. Please verify.</p>  
            <H1>Welcome</H1>
            <p>Hello {{ user.name }}, welcome to your first Inertia app!</p>

        </v-container>
    </v-app>
  </Layout>
</template>

<script>
  import Layout from './Layout'
  import { Head } from '@inertiajs/inertia-vue'
  export default {
    components: {
      Head,
      Layout,
    },
    computed: {
      
    },
    props: {
      user: Object,
      auth: Object, 
    },
    methods : {
      isLoggedIn(user) {    
        return window.localStorage.setItem("user",'ddd');      
      }
    },
    mounted(){
      console.log('heree') 
      console.log('ddddd',auth.user);  

        isLoggedIn(user)
    },
  }
</script>
