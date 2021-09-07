<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">
               <h2>Thank You</h2>   

                <Link href="/login" text >Click Here to Login </Link>
            </v-card>          
        </v-container>
    </v-app>
</template>   
<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  components: {
    Link,
  }
}
</script>