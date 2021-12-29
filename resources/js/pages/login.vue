<template>
    <Layout>
        <Head title="Sign In" />
        <section class="relative">
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">

              <!-- Page header -->
              <div class="max-w-3xl mx-auto text-center pb-9">
                <h1 class="h1 text-gray-700">Welcome back!</h1>
              </div> 

        <!-- Form -->
            <div class="max-w-sm mx-auto">
              <div class="flex items-center my-6">
                <div class="border-t border-gray-700 border-dotted flex-grow mr-3" aria-hidden="true"></div>
                <div class="text-gray-700">Sign in with your email</div>
                <div class="border-t border-gray-700 border-dotted flex-grow ml-3" aria-hidden="true"></div>
              </div>
              <v-form class="login-form form-outer-wrapper" @submit.prevent="submit" >
                <!--div v-if="errors.message" class="text-red-500 text-sm font-bold text-center text-sm my-3">{{ errors.message }}</div>
                <div v-if="success" class="text-green-500 text-sm font-bold text-center text-sm my-3">{{ success.message }}</div-->
                
                <Message :message="errors.message" :hide="0" :type="'error'" />
                <Message :message="success.message" :hide="0" :type="'success'" />

                <div class="flex flex-wrap -mx-3 mb-3">
                  <div class="w-full px-3">
                    <label class="block text-gray-700 text-lg font-medium mb-1" for="email">Email</label>
                    <v-text-field v-model="email" :class="{ 'error--text': $v.email.$error }"  @input="$v.email.$touch()" @blur="$v.email.$touch()" class="form-input input-field-outer w-full text-gray-700" placeholder="you@yourcompany.com" autocomplete required ></v-text-field>

                    <div v-if="$v.email.$error && !$v.email.required"  class="text-red-500 text-lg">Email is required</div>
                    <div v-if="email.trim().length > 0 && $v.email.$error && !$v.email.email"  class="text-red-500 text-lg">Please Enter a valid Email</div>
                  </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-3">
                  <div class="w-full px-3">
                    <label class="block text-gray-700 text-lg font-medium mb-1" for="password">Password</label>
                    <v-text-field type="password" v-model="password" :class="{ 'error--text': $v.password.$error }" class="form-input input-field-outer w-full text-gray-700" @input="$v.password.$touch()" @blur="$v.password.$touch()" placeholder="Password (at least 8 characters)" autocomplete required ></v-text-field>
                    <div v-if="$v.password.$error && !$v.password.required" class="text-red-500 text-lg ">Password is required</div>  
                    <div v-if="password.trim().length > 0 && $v.password.$error && !$v.password.minLength" class="text-red-500 text-lg ">The password must be at least 8 characters.</div>
                  
                  </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-3">
                  <div class="w-full px-3">
                    <div class="flex justify-between">
                      <Link href="/forgot-password" class="text-lg text-purple-600 hover:text-purple-600 transition duration-150 ease-in-out">Forgot Password?</Link>
                    </div>
                  </div>
                </div>
                <div class="flex flex-wrap -mx-3 mt-5">
                  <div class="w-full px-3">
                      <v-btn class="btn text-white bg-purple-600 hover:bg-purple-700 w-full text-lg" @click="submit">
                        Sign in
                      </v-btn>
                    <!--button  type="button" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full" >Sign in</button-->
                  </div>
                </div>
              </v-form>
              <div class="text-gray-700 text-center text-lg mt-5">
                Don’t you have an account? <Link href="/register" class="text-purple-600 hover:text-purple-600 transition duration-150 ease-in-out">Sign up</Link>
              </div>
            </div>

            </div>
        </div>
      </section>
    </Layout>
</template>   
<script>
import { Head,Link } from '@inertiajs/inertia-vue'
import Layout from './Layout'
import { validationMixin } from 'vuelidate'
import { required, email, minLength } from 'vuelidate/lib/validators'
import Message from '../partials/Messages.vue';


  export default {
    mixins: [validationMixin],
     validations: {
      email: { required, email },
      password: {required,minLength: minLength(8)}
    },
    computed: {
      isLoggedIn() {
        return this.$page.props.auth.user;
      },
    },
    components: {
      Link,
      Head,
      Layout,
      Message,
    },
     props: {
        errors: Object,
        success: Object,
    },
  data() {
    return {
      email:'',
      password:'',
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
          this.$v.$touch()
          if(this.$v.$invalid) {
            console.log('error!')
          } else {
             let form = {email:this.email,password:this.password};
             this.$inertia.post('/login', form);
            if(this.form.email){ 
              Inertia.reload()

                window.localStorage.setItem("username",this.form.email); 
            }
          }

          /*let test = this.$inertia.post('/login', this.form );
          console.log('test',test);
          if(this.form.email){ 
              window.localStorage.setItem("username",this.form.email); 
          }*/
          //this.$refs.form.resetValidation();
        }
    }
}
</script>