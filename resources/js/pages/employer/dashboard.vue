<template>
  <Layout>
    <Head title="Employer Dashboard" />
    <v-app app>
        <v-container>
            <div v-if="$page.props.flash.message" class="mt-2 success">
            {{ $page.props.flash.message }}
          </div>  
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
    props: {
      user: Object,
    },
  }
</script>
