<template>
   <div class="404-page">
      <Layout>
         <Head title="404 - Page not found" />
               <section data-app>
                  <div class="max-w-6xl mx-auto px-4 sm:px-6 relative">
                        <div class="pt-32 pb-12 md:pt-40 md:pb-20">
                     <!-- Page header -->
                     <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                        <h1 class="h1 mb-4 text-gray-600" data-aos="fade-up">404</h1>
                        <p class="text-xl ">Oops... Page Not found.</p>
                     </div>

                  </div>
               </div>
            </section>
      </Layout> 
   </div>  
</template>

<script>
import Layout from './Layout';
import { Head,Link } from '@inertiajs/inertia-vue';
import Footer from '../partials/Footer.vue';

export default {
   components: {
      Head,
      Layout,
      Footer,
   },
}
</script>
