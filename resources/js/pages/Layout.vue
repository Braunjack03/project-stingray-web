<template>
  <body class="font-inter antialiased text-gray-200 tracking-tight bg-white" :class="(this.$page.component == 'job_posts1') ? 'bg-white bg-gray-900' : ''">

    <div class="flex flex-col min-h-screen overflow-hidden">
    <Header/>

        <main class="flex-grow">
            <!-- Page illustration -->
            <div class="relative max-w-6xl mx-auto h-0 pointer-events-none" aria-hidden="true">
              <PageIllustration />
            </div>
                 <div class="verifyEmailText" v-if="currentHref && currentHref.includes('contact') != true  && currentHref.includes('privacy') != true  && currentHref.includes('pricing') != true && currentHref.includes('thankyou') != true  && currentHref.includes('login') != true && currentHref.includes('register') != true && currentHref.includes('companies') != true && currentHref.includes('articles') == false && currentUrl != '/' && currentHref.includes('jobs') == false">
                    <div v-if="isLoggedIn && isLoggedIn.is_email_verified == 0 && hide == 0" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline text-lg">Please verify your email address.</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="hideMessage">
                          <svg class="fill-current h-6 w-6 text-yellow -500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>
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
      success: Object,
    },
    data: function () {
      return {
          currentUrl : window.location.pathname,
          currentHref : window.location.toString(),
          hide:0,
        };
    },
     filters: {
      trim: function(string) {
        return string.trim()
      }
    },
     methods: {
      hideMessage(){
        this.hide = 1;
      },
      logout() {
        window.localStorage.removeItem("username");
        window.location.replace("/logout")      
      },
     }
  }
</script>