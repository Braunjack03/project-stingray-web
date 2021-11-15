<template>
  <Layout>
     <Head title="Employer Dashboard" />
   <section class="relative">
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">
              

                 <!-- Page header -->
            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                <h1 class="h1 mb-4 text-gray-700" data-aos="fade-up">Dashboard</h1>
            </div>
        <!-- Form -->
            <div class="max-w-xl mx-auto  text-gray-500">
            <div v-if="$page.props.flash.message" class="mt-2 success">
            {{ $page.props.flash.message }}
          </div>  
        <p v-if="(user.is_email_verified === 0)" class="error">Your email is not verified yet. Please verify.</p>  
            <H1>Welcome</H1>
            <p>Hello {{ user.name }}, welcome to your first Inertia app!</p>
        </div>
            </div>
        </div>
      </section>
  </Layout>
</template>

<script>
  import Layout from '../Layout'
  import { Head } from '@inertiajs/inertia-vue'
  
  export default {
    components: {
      Head,
      Layout,
    },
    props: {
      user: Object,
    },
  }
</script>
