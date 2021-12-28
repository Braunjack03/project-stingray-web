<template>
    <Layout>   
        <Head title="Reset Password"/>
     <section class="relative">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
          <div class="pt-32 pb-12 md:pt-40 md:pb-20">

               <!-- Page header -->
                <div class="max-w-3xl mx-auto text-center pb-12 md:pb-20">
                <h1 class="h1 mb-4">Reset Password</h1>
                </div>

                <div class="max-w-sm mx-auto">
                    <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                        <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                   <form class="forgot-password">
                        <div class="flex flex-wrap -mx-3 mb-4">
                            <div class="w-full px-3">
                            <label class="block text-gray-300 text-lg font-medium mb-1" for="password">Password <span class="text-red-600">*</span></label>

                                <input id="password" type="password" v-model="form.password" :rules="form.passwordRules" class="form-input w-full text-gray-300" placeholder="Password" autocomplete required />

                                <p v-if="errors.password" class="text-red-500 text-sm mt-2">{{ errors.password }}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-4">
                            <div class="w-full px-3">
                            <label class="block text-gray-300 text-lg font-medium mb-1" for="password">Confirm Password <span class="text-red-600">*</span></label>

                                <input id="password" type="password" v-model="form.password_confirmation" :rules="form.cpasswordRules" class="form-input w-full text-gray-300" placeholder="Password" autocomplete required />

                                <p v-if="errors.password_confirmation" class="mt-2 error">{{ errors.password_confirmation }}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mt-6">
                        <div class="w-full px-3">
                            <button :disabled="!valid" type="button" @click="submit()" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full">Reset Password</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
      </section>
      </Layout>   
</template>   
<script>
  import Layout from './Layout'
  import { Head } from '@inertiajs/inertia-vue'
  export default {
      components: {
      Layout,
      Head,
    },
    props: {
        errors: Object,
        success: Object,
        user: Object
    },
    data: () => ({
        message: '',
        valid: true,
        form: {
            password: '',
            confirm_password: '',
            passwordRules : [
                v => !!v || 'Password is required',
            ],
            cpasswordRules : [
                v => !!v || 'Confirm Password is required',
            ],
        },
    }),
    methods: {
      submit() {
            this.$inertia.post('/reset-password/'+this.user.token, this.form );
       },
    },
  }

</script>