<template>
    <Layout>

        <section class="relative">
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">

              <!-- Page header -->
              <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h1 class="h1">Welcome back. We exist to make entrepreneurship easier.</h1>
              </div>

        <!-- Form -->
            <div class="max-w-sm mx-auto">
              <div class="flex items-center my-6">
                <div class="border-t border-gray-700 border-dotted flex-grow mr-3" aria-hidden="true"></div>
                <div class="text-gray-400">sign in with your email</div>
                <div class="border-t border-gray-700 border-dotted flex-grow ml-3" aria-hidden="true"></div>
              </div>
              <form>
                <div v-if="errors.message" class="text-red-500 text-sm mt-2">{{ errors.message }}</div>
                <div v-if="success" class="text-green-500 text-sm mt-2">{{ success.message }}</div>
                <div class="flex flex-wrap -mx-3 mb-4">
                  <div class="w-full px-3">
                    <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Email</label>
                    <input id="email" type="email" v-model="form.email" :rules="form.emailRules" class="form-input w-full text-gray-300" placeholder="you@yourcompany.com" autocomplete required />
                    <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>
                  </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-4">
                  <div class="w-full px-3">
                    <label class="block text-gray-300 text-sm font-medium mb-1" for="password">Password</label>

                    <input id="password" v-model="form.password" :rules="form.passwordRules" type="password" class="form-input w-full text-gray-300" placeholder="Password" autocomplete required />
                    
                    <div v-if="errors.password" class="mt-2 error">{{ errors.password }}</div>
                  </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-4">
                  <div class="w-full px-3">
                    <div class="flex justify-between">
                      <label class="flex items-center">
                        <!--input type="checkbox" class="form-checkbox" />
                        <span class="text-gray-400 ml-2">Keep me signed in</span-->
                      </label>
                      <Link href="/forgot-password" class="text-purple-600 hover:text-gray-200 transition duration-150 ease-in-out">Forgot Password?</Link>
                    </div>
                  </div>
                </div>
                <div class="flex flex-wrap -mx-3 mt-6">
                  <div class="w-full px-3">
                    <button :disabled="form.processing" type="button" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full" @click="submit()">Sign in</button>
                  </div>
                </div>
              </form>
              <div class="text-gray-400 text-center mt-6">
                Don’t you have an account? <Link href="/register" class="text-purple-600 hover:text-gray-200 transition duration-150 ease-in-out">Sign up</Link>
              </div>
            </div>

            </div>
        </div>
      </section>
    </Layout>
</template>   
<script>
import { Link } from '@inertiajs/inertia-vue'
import Layout from './Layout'


  export default {
    components: {
      Link,
      Layout,
    },
     props: {
        errors: Object,
        success: Object,
    },
  data() {
    return {
      form: this.$inertia.form({
        email: null,
        password: null,
          emailRules: [
              v => !!v || 'E-mail is required',
              v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
          ],
          passwordRules : [
              v => !!v || 'Password is required',
           ],
      }),
    }
  },
  methods :{
      submit() {
          let test = this.$inertia.post('/login', this.form );
          console.log('test',test);
          if(this.form.email){ 
              window.localStorage.setItem("username",this.form.email); 
          }
          //this.$refs.form.resetValidation();
        }
    }
}
</script>