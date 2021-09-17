<template>
  <v-app id="inspire">
    <v-app-bar
      app
      color="white"
      flat
    >
      <v-container class="py-0 fill-height">

        <Link href="/" class="mr-10">Home</Link>

        <Link href="/register" class="mr-10">Register</Link>

        <Link href="/login" class="mr-10">Login</Link>
        <v-spacer></v-spacer>
       
      </v-container>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <div v-if="$page.props.flash.message" class="mt-2 success">
            {{ $page.props.flash.message }}
          </div>  
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
  }
</script>