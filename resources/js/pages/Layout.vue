<template>
  <main>
    <v-container>
        <header>
          <Link href="/">Home</Link>
          <Link href="/about">About</Link>
          <Link href="/contact">Contact</Link>
          <Link href="/profile">Profile</Link>
          <Link href="/logout">Logout</Link>
        </header>
        <article>
          <slot />
        </article>
      </v-container>
   <v-footer padless>
    <v-col
      class="text-center"
      cols="12"
    >
      {{ new Date().getFullYear() }} — <strong>Stingray</strong>
    </v-col>
  </v-footer>
  </main>
  
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  components: {
    Link,
  }
}
</script>