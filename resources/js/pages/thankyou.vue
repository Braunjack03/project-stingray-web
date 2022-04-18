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
                Thanks for Joining!  
              </h1>
              <p class="text-xl text-gray-500 aos-init aos-animate">
                Click Here to<Link
                  href="/login"
                  class="text-purple-600 transition duration-150 ease-in-out hover:text-gray-200"
                >
                  Login
                </Link>
              </p>
            </div>

            <!-- Form -->
          </div>
        </div>
      </section>
    </Layout>
  </div>
</template>
<script>
import { Link, Head } from '@inertiajs/inertia-vue';
import Layout from './Layout.vue';

export default {
  name: 'ThankYou',
  components: {
    Link,
    Layout,
    Head,
  },
};
</script>
