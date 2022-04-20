<template>
  <div>
    <Layout>
      <Head title="Thank you" />
      <section class="relative">
        <div class="max-w-6xl px-4 mx-auto sm:px-6">
          <div class="pb-12 pt-36 md:pt-40 md:pb-20">
            <!-- Page header -->
            <div class="max-w-3xl pb-12 mx-auto text-center md:pb-20">
              <h1 class="text-gray-700 h1">
                Check Your Inbox 
              </h1>
              <p class="py-10 text-xl text-gray-700">
                  A verification email is on the way. Confirm your email to start using Made in Tampa.
              </p>
  <v-btn href="/login" class="text-white bg-purple-600 w-50 btn hover:bg-purple-700" pt-5> Do This Later
   </v-btn>



            </div>

            <!-- Form -->
          </div>
        </div>
      </section>
    </Layout>
  </div>
</template>
<script>
import { Link, Head } from "@inertiajs/inertia-vue";
import Layout from "./Layout.vue";

export default {
  name: "ThankYou",
  components: {
    Link,
    Layout,
    Head,
  },
};
</script>
