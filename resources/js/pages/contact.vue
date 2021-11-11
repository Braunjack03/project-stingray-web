<template>
  <Layout>
     <Head title="Contact Us" />
        <section class="relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="pt-32 pb-12 md:pt-40 md:pb-20">
                

                    <!-- Page header -->
                <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                    <h1 class="h1 mb-4" data-aos="fade-up">Contact Us</h1>
                </div>
            <!-- Form -->
                <div class="max-w-xl mx-auto">
                    <div v-if="success" class="text-green-500 text-center text-sm mt-2">
                        {{ success.message }}
                    </div>
                    <v-form ref="form" @submit.prevent="submit">

                        <div class="flex flex-wrap -mx-3 mb-4">
                            <div class="w-full px-3">
                                <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Email <span class="text-red-600">*</span></label>
                                <v-text-field v-model="email" :class="{ 'error--text': $v.email.$error }"  @input="$v.email.$touch()" @blur="$v.email.$touch()" class="form-input input-field-outer w-full text-gray-300" placeholder="you@yourcompany.com" autocomplete required ></v-text-field>

                                <div v-if="$v.email.$error && !$v.email.required"  class="text-red-500 text-sm">Email is required</div>
                                <div v-if="$v.email.$error && !$v.email.email"  class="text-red-500 text-sm">Please Enter a valid Email</div>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-4">
                            <div class="w-full px-3">
                                <label class="block text-gray-300 text-sm font-medium mb-1" for="email">Message <span class="text-red-600">*</span></label>
                                <v-textarea v-model="message" :class="{ 'error--text': $v.message.$error }"  @input="$v.message.$touch()" @blur="$v.message.$touch()" class="form-input input-field-outer w-full text-gray-300" placeholder="Message" autocomplete required ></v-textarea>

                                <div v-if="$v.message.$error && !$v.message.required"  class="text-red-500 text-sm">Message is required</div>
                            </div>
                        </div>
                        <v-btn class="btn text-white bg-purple-600 hover:bg-purple-700 w-full" @click="submit">Submit</v-btn>
                    </v-form>
                </div>
            </div>
        </div>    
    </section>
  </Layout>
</template>

<script>
    import Layout from './Layout'
    import { Head } from '@inertiajs/inertia-vue'
    import { validationMixin } from 'vuelidate'
    import { required, email, minLength } from 'vuelidate/lib/validators'
  
  export default {
    mixins: [validationMixin],
     validations: {
      email: { required, email },
      message: {required}
    },
    components: {
      Head,
      Layout,
    },
    props: {
      success: Object,
    },
    data: () => ({
        email:'',
        message:'',
    }),
    methods: {
      submit() {
          this.$v.$touch()
          if(!this.$v.$invalid) {
             let form = {email:this.email,message:this.message};
             this.$inertia.post('/contact', form);
             this.$v.$reset()
          }
       },
    },
  }
</script>