<template>
   <Layout>
      <Head title="Blog" />
              <section data-app>
               <div class="max-w-6xl mx-auto px-4 sm:px-6 relative">
                     <div class="pt-32 pb-12 md:pt-40 md:pb-20">
                  <!-- Page header -->
                  <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                     <h1 class="h1 mb-4 text-gray-600" data-aos="fade-up">Coming Soon....</h1>
                  </div>

                 </div>
            </div>
         </section>
          <Footer/>
   </Layout>   
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
