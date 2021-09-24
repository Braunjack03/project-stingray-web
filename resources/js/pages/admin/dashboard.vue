<template>
  <Layout>
    <Head title="Admin Dashboard" />
    <v-app app>
        <v-container>
            <div v-if="$page.props.flash.message" class="mt-2 success">
            {{ $page.props.flash.message }}
          </div>  
        <p v-if="(user.is_email_verified === 0)" class="error">Your email is not verified yet. Please verify.</p>  
            <H1>Welcome</H1>
            <p>Hello {{ user.name }}, welcome to Admin Panel!</p>
           <v-row dense>
              <v-col>
            <v-card
            max-width="100%"
            outlined
          >
            <v-list-item >
              <v-list-item-content>
                <v-list-item-title class="text-h5 mb-1">
                  Jobs
                </v-list-item-title>
                <v-list-item-subtitle>{{user.jobs_count}}</v-list-item-subtitle>
              </v-list-item-content>

            </v-list-item>

            <v-card-actions>
              <v-btn
                text
                color="teal accent-4"
                @click="jobs()"
              >
                View More
              </v-btn>
            </v-card-actions>
          </v-card>
         </v-col> 
         <v-col> 
          <v-card
            max-width="100%"
            outlined
          >
            <v-list-item >
              <v-list-item-content>
                <v-list-item-title class="text-h5 mb-1">
                  Companies
                </v-list-item-title>
                <v-list-item-subtitle>{{user.companies_count}}</v-list-item-subtitle>
              </v-list-item-content>

            </v-list-item>

            <v-card-actions>
              <v-btn
                text
                color="teal accent-4"
                @click="companies()"
              >
                View More
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col> 
           </v-row>  
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
    methods: {
         jobs() {
            this.$inertia.visit('jobs')
        },
        companies() {
            this.$inertia.visit('companies')
        },
    }
  }
</script>
