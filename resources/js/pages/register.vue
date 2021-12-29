<template>
    <Layout>
        <Head title="Sign Up" />
        <section class="relative">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
          <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            <!-- Page header -->
            <div class="max-w-3xl mx-auto text-center pb-9">
              <h1 class="h1 text-gray-700">Register for Made in Tampa</h1>
            </div>

             <!-- Form -->
            <div class="max-w-sm mx-auto">
              <div class="flex items-center my-6">
                <div class="border-t border-gray-700 border-dotted flex-grow mr-3" aria-hidden="true"></div>
                <div class="text-gray-700">Register with your email</div>
                <div class="border-t border-gray-700 border-dotted flex-grow ml-3" aria-hidden="true"></div>
              </div>

              <Message :message="errors.message" :hide="0" :type="'error'" />
              <Message :message="success.message" :hide="0" :type="'success'" />

              <v-form class="register-form form-outer-wrapper" @submit.prevent="submit" >
                <div class="flex flex-wrap -mx-3 mb-3">
                  <div class="w-full px-3">
                    <label class="block text-gray-700 text-lg font-medium mb-1" for="email">Work Email <span class="text-red-600">*</span></label>
                    <v-text-field v-model="email" :class="{ 'error--text': $v.email.$error }"  @input="$v.email.$touch()" @blur="$v.email.$touch()" class="form-input input-field-outer w-full text-gray-700" placeholder="you@yourcompany.com" autocomplete required ></v-text-field>

                    <div v-if="$v.email.$error && !$v.email.required"  class="text-red-500 text-lg">Email is required</div>
                    <div v-if="$v.email.$error && !$v.email.email"  class="text-red-500 text-lg">Please Enter a valid Email</div>
                  </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-3">
                  <div class="w-full px-3">
                    <label class="block text-gray-700 text-lg font-medium mb-1" for="password">Password <span class="text-red-600">*</span></label>
                    <v-text-field type="password" v-model="password" :class="{ 'error--text': $v.password.$error }" class="form-input input-field-outer w-full text-gray-700" @input="$v.password.$touch()" @blur="$v.password.$touch()" placeholder="Password (at least 8 characters)" autocomplete required ></v-text-field>
                    <div v-if="$v.password.$error && !$v.password.required" class="text-red-500 text-lg ">Password is required</div>  
                    <div v-if="$v.password.$error && !$v.password.minLength" class="text-red-500 text-lg ">The password must be at least 8 characters.</div>
                  </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-3">
                  <div class="w-full px-3 text-gray-700 radioColor">

                    <label class="block text-gray-700 text-lg font-medium mb-1" for="role">Your role: <span class="text-red-600">*</span></label>

                      <v-radio-group v-model="user_type" mandatory class="text-gray-700 text-lg">
                    <v-radio
                        label="Job Seeker"
                        value="2"
                    ></v-radio>
                    <v-radio
                        label="Employer"
                        value="1"
                    ></v-radio>
                    </v-radio-group>

                  </div>
                </div>
                 <!--div class="text-sm text-gray-700 text-center">
                  I agree to be contacted by Open PRO about this offer as per the Open PRO <a class="underline text-gray-700 hover:text-gray-600 hover:no-underline transition duration-150 ease-in-out" href="#0">Privacy Policy</a>.
                </div-->
                <div class="flex flex-wrap -mx-3 mt-5">
                  <div class="w-full px-3">
                     <v-btn class="text-lg btn text-white bg-purple-600 hover:bg-purple-700 w-full" @click="submit">
                        Sign up
                      </v-btn>
                  </div>
                </div>
              </v-form>
              <div class="text-gray-700 text-center mt-5 text-lg">
                Already Have Account? <Link href="/login" class="text-purple-600 hover:text-gray-600 transition duration-150 ease-in-out">Sign in</Link>
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
    name: 'SignUp',
    mixins: [validationMixin],
     validations: {
      email: { required, email },
      password: {required,minLength: minLength(8)}
    },
    components: {
      Link,
      Head,
      Layout,
      Message,
    },
    props: {
        success: Object,
        errors: Object,
    },
    data: () => ({
        email:'',
        password:'',
        user_type:'',
        message: '',
    }),
    methods: {
      submit() {
          this.$v.$touch()
          if(!this.$v.$invalid) {
             let form = {email:this.email,password:this.password,user_type:this.user_type};
             this.$inertia.post('/register', form);
          }
       },
    },
  }

</script>