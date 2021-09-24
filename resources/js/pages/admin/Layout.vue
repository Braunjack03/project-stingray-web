<template>
  <v-app id="inspire">
    <v-app-bar
      app
      color="white"
      flat
    >
      <v-container class="py-0 fill-height">
    


        <v-spacer></v-spacer>

      </v-container>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row>
          <v-col cols="2">
            <v-sheet rounded="lg">
                
              <v-list color="transparent">
                  
                <v-list-item  link>
                  <v-list-item-content>
                    <v-list-item-title @click="dashboard()">
                         Dashboard
                    </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <v-list-item  link>
                  <v-list-item-content>
                    <v-list-item-title @click="jobs()">
                         Jobs
                    </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <v-list-item  link>
                  <v-list-item-content>
                    <v-list-item-title @click="companies()">
                         Companies
                    </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>

                <v-divider class="my-2"></v-divider>

                <v-list-item
                  link
                  color="grey lighten-4"
                >
                  <v-list-item-content>
                    <v-list-item-title @click="logout()">
                      Logout
                    </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-sheet>
          </v-col>

          <v-col>
            <v-sheet
              min-height="70vh"
              rounded="lg"
            >
            <slot />
              <!--  -->
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

  export default {
    components: {
      Link,
    },
     computed: {
      isLoggedIn() {
         return this.$page.props.auth.user

      }
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
        dashboard() {
            this.$inertia.visit('dashboard')
        },
        logout() {
            window.localStorage.removeItem("username");
            window.location.replace("/logout")      
        },
         jobs() {
            this.$inertia.visit('jobs')
      
        },
        companies() {
            this.$inertia.visit('companies')
        },
    }
  }
</script>