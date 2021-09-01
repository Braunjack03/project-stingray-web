<template>
  <Layout>
    <Head title="Welcome" />
    <v-app app>
        <v-container>
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
