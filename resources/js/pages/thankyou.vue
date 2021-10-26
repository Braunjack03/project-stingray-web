<template>
  <Layout>   
    <Head title="Thank you" />
     <section class="relative">
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">
              

               <!-- Page header -->
              <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h1 class="h1">Thank You</h1>
                <p class="text-xl text-gray-400 aos-init aos-animate" >Click Here to<Link href="/login" class="text-purple-600 hover:text-gray-200 transition duration-150 ease-in-out" > Login </Link></p>
                
              </div>

        <!-- Form -->
            </div>
        </div>
      </section>    
    </Layout>   
</template>   
<script>
 import Layout from './Layout'
import { Link,Head } from '@inertiajs/inertia-vue'

export default {
  components: {
    Link,
    Layout,
    Head
  }
}
</script>