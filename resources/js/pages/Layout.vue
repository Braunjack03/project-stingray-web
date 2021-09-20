<template>
  <v-app id="inspire">
    <v-app-bar
      app
      color="white"
      flat
    >
      <v-container class="py-0 fill-height">
        <Link href="/" text class="mr-10"> Home </Link>

        <Link v-if="!isLoggedIn" href="/register" class="mr-10">Register</Link>

        <Link v-if="isLoggedIn && isLoggedIn.role == 2" href="/dashboard" text class="mr-10"> Dashboard </Link>

        <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/dashboard" text class="mr-10"> Dashboard </Link>

        <Link v-if="isLoggedIn && isLoggedIn.role == 2" href="/profile" text class="mr-10"> Profile </Link>

        <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/profile" text class="mr-10"> Profile </Link>

        <Link v-if="isLoggedIn" v-on:click="logout" href="/logout" class="mr-10">Logout</Link>        
        
        <Link v-else href="/login" class="mr-10">Login</Link>

        <v-spacer></v-spacer>
       
      </v-container>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row>
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