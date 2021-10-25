<template>
    <Layout>

        <section class="relative">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
          <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            <!-- Page header -->
            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
              <h1 class="h1">Welcome. We exist to make entrepreneurship easier.</h1>
            </div>

             <!-- Form -->
            <div class="max-w-sm mx-auto">
              <div class="flex items-center my-6">
                <div class="border-t border-gray-700 border-dotted flex-grow mr-3" aria-hidden="true"></div>
                <div class="text-gray-400">Register with your email</div>
                <div class="border-t border-gray-700 border-dotted flex-grow ml-3" aria-hidden="true"></div>
              </div>
                    <div v-if="errors.message" class="text-red-500 text-sm mt-2">{{ errors.message }}</div>

              <form class="register-form">
                <div class="flex flex-wrap -mx-3 mb-4">
                  <div class="w-full px-3">
                    <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Email <span class="text-red-600">*</span></label>
                    <input id="email" type="email" v-model="form.email" class="form-input w-full text-gray-300" placeholder="you@yourcompany.com" :rules="form.emailRules" required />
                    <p v-if="errors.email" class="text-red-500 text-sm mt-2">{{ errors.email }}</p>
                  </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-4">
                  <div class="w-full px-3">
                    <label class="block text-gray-300 text-sm font-medium mb-1" for="password">Password <span class="text-red-600">*</span></label>

                    <input id="password" type="password" v-model="form.password" :rules="form.passwordRules" class="form-input w-full text-gray-300" placeholder="Password " autocomplete required />

                    <p v-if="errors.password" class="text-red-500 text-sm mt-2">{{ errors.password }}</p>
                  </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-4">
                  <div class="w-full px-3 text-gray-400">

                    <label class="block text-gray-300 text-sm font-medium mb-1" for="role">Your role: <span class="text-red-600">*</span></label>

                      <v-radio-group
                        v-model="form.user_type" :rules="form.userTypeRules"
                        required
                        >
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
                <div class="flex flex-wrap -mx-3 mt-6">
                  <div class="w-full px-3">
                    <button :disabled="!valid" type="button" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full" @click="submit()">Sign up</button>
                  </div>
                </div>
              </form>
              <div class="text-gray-400 text-center mt-6">
                Already Have Account? <Link href="/login" class="text-purple-600 hover:text-gray-200 transition duration-150 ease-in-out">Sign in</Link>
              </div>
            </div>

          </div>
        </div>
      </section>


    <!--v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

            <h2  >Create an Account (it's free)  </h2>   
            <br/>
                <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                <v-form ref="form" v-model="valid" lazy-validations >
                    <label>Email address</label>
                    <v-text-field v-model="form.email" :rules="form.emailRules" required></v-text-field>
                    <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>
                    <label>Password</label>
                    <v-text-field v-model="form.password" :rules="form.passwordRules" type="password" required></v-text-field>
                    <div v-if="errors.password" class="mt-2 error">{{ errors.password }}</div>
                    <label>Your role:</label>
                    <v-radio-group
                        v-model="form.user_type" :rules="form.userTypeRules"
                        required
                        >
                    <v-radio
                        label="Job Seeker"
                        value="2"
                    ></v-radio>
                    <v-radio
                        label="Employer"
                        value="1"
                    ></v-radio>
                    </v-radio-group>
                    <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit()" >Create Acount</v-btn>
                </v-form>
                <br/>
                 <Link href="/login" text >Already Have Account? Login </Link>
            </v-card> 
       
        </v-container>
    </v-app-->
    </Layout>    
</template>   
<script>
import { Link } from '@inertiajs/inertia-vue'
import Layout from './Layout'
  export default {
    components: {
      Link,
      Layout
    },
    props: {
        errors: Object,
    },
    data: () => ({
        message: '',
        valid: true,
        form: {
            email: '',
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            password: '',
            passwordRules : [
                v => !!v || 'Password is required',
            ],
            user_type: '',
            userTypeRules : [
                v => !!v || 'Your role is required',
            ]
        },
    }),
    methods: {
      validate () {
        this.$refs.form.validate();
        return true;
      },
      submit() {
            this.$inertia.post('/register', this.form );
       },
    },
  }

</script>