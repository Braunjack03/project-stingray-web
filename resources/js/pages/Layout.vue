<template>
  <body class="font-inter antialiased text-gray-200 tracking-tight" :class="(this.$page.component == 'job_posts') ? 'bg-white' : 'bg-gray-900'">

    <div class="flex flex-col min-h-screen overflow-hidden">
    <Header/>

        <main class="flex-grow">

            <!-- Page illustration -->
            <div class="relative max-w-6xl mx-auto h-0 pointer-events-none" aria-hidden="true">
              <PageIllustration />
            </div>
          
            
              <slot />
              <!--  -->
         </main>
        
    </div>
  </body>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
import Header from '../partials/Header.vue'
import Footer from '../partials/Footer.vue'
import PageIllustration from '../partials/PageIllustration.vue'

  export default {
    components: {
      Link,
      Header,
      Footer,
      PageIllustration
    },
     computed: {
      isLoggedIn() {
         return this.$page.props.auth.user

      }
    }, 
     props: { 
      user: Object,
      auth:Object,
    },
    data: () => ({
      links: [
        'Dashboard',
        'Messages',
        'Profile',
        'Updates',
      ],
    }),
     methods: {
       
      logout() {
        window.localStorage.removeItem("username");
        window.location.replace("/logout")      
      },
     }
  }
</script>