<template>
  <v-app id="inspire">
    <v-app-bar
      app
      color="white"
      flat
    >
      <v-container class="py-0 fill-height">
        <Link href="/" text class="mr-10"> Home </Link>

        <Link href="/dashboard" text class="mr-10"> Dashboard </Link>

        <Link href="/profile" text class="mr-10"> Profile </Link>

        <Link href="/logout" text class="mr-10"> Logout </Link>
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
     props: { 
      user: Object,
    },
    data: () => ({
      links: [
        'Dashboard',
        'Messages',
        'Profile',
        'Updates',
      ],
    }),
  }
</script>