<template>
  <body class="font-inter antialiased text-gray-200 tracking-tight bg-white" :class="(this.$page.component == 'job_posts1') ? 'bg-white bg-gray-900' : ''">

    <div class="flex flex-col min-h-screen overflow-hidden">
    <Header/>

        <main class="flex-grow">
            <!-- Page illustration -->
            <div class="relative max-w-6xl mx-auto h-0 pointer-events-none" aria-hidden="true">
              <PageIllustration />
            </div>
                <div class="verifyEmailText" v-if="currentHref.indexOf('companies') != 25 && currentUrl != '/' && currentHref.indexOf('jobs') != 25">
                  <p v-if="isLoggedIn && isLoggedIn.is_email_verified == 0">Your email is not verified yet. Please verify.</p>
                </div>
              <slot />
              <!--  -->
         </main>
    <Footer/>     
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
    data: function () {
      return {
          currentUrl : window.location.pathname,
          currentHref : window.location.href,
        };
    },
     filters: {
      trim: function(string) {
        return string.trim()
      }
    },
     methods: {
       
      logout() {
        window.localStorage.removeItem("username");
        window.location.replace("/logout")      
      },
     }
  }
</script>