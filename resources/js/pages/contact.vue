<template>
  <Layout>
     <Head title="Contact Us" />
        <section class="relative contactUs--outer" data-app>
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="pt-32 pb-12 md:pt-40 md:pb-20">
                
  
                    <!-- Page header -->
                <div class="max-w-2xl mx-auto text-center pb-10">
                    <h1 class="h1 mb-4 text-gray-700" data-aos="fade-up">How can we help you?</h1>
                    <p class="text-lg textColor pt-2">We have custom plans to power your business. Tell us your needs, and we’ll contact you shortly.</p>
                </div>
            <!-- Form -->
                <div class="max-w-xl mx-auto">
                    <!--div v-if="success" class="text-green-500 text-center text-lg mt-2">
                        {{ success.message }}
                    </div-->

                    <div v-if="success.message  && hide == 0" class="verifyEmailText" >
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{success.message}}</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="hideMessage">
                            <svg class="fill-current h-6 w-6 text-green -500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                            </span>
                        </div>
                    </div>
                    <v-form ref="form" @submit.prevent="submit">

                        <div class="flex flex-wrap">
                            <div class="w-full mb-3">
                            <label class="block text-gray-700 text-lg font-medium mb-1">Subject <span class="text-red-600">*</span></label>
                                <v-row >
                                <v-col
                                class="d-flex"
                                cols="12"
                                >
                                <v-select
                                    v-model='subject'
                                    :items="items"
                                    label="Subject"
                                    class="form-input input-field-outer w-full text-gray-700"
                                    dense
                                    solo
                                    :class="{ 'error--text': $v.subject.$error }" 
                                ></v-select>
                                <div v-if="$v.subject.$error && !$v.subject.required"  class="text-red-500 text-lg">Subject is required</div>
                                </v-col>
                            </v-row>
                        </div>
                        </div> 
                        
                         <div class="flex flex-wrap">
                            <div class="w-full mb-3">
                                <label class="block text-gray-700 text-lg font-medium mb-1" for="email">Name <span class="text-red-600">*</span></label>
                                <v-text-field v-model="name" :class="{ 'error--text': $v.name.$error }"  @input="$v.name.$touch()" @blur="$v.name.$touch()" class="form-input input-field-outer w-full text-gray-300" placeholder="Name" autocomplete required ></v-text-field>

                                <div v-if="$v.name.$error && !$v.name.required"  class="text-red-500 text-lg">Name is required</div>
                            </div>
                        </div>

                        <div class="flex flex-wrap">
                            <div class="w-full mb-3">
                                <label class="block text-gray-700 text-lg font-medium mb-1" for="email">Email <span class="text-red-600">*</span></label>
                                <v-text-field v-model="email" :class="{ 'error--text': $v.email.$error }"  @input="$v.email.$touch()" @blur="$v.email.$touch()" class="form-input input-field-outer w-full text-gray-300" placeholder="you@yourcompany.com" autocomplete required ></v-text-field>

                                <div v-if="$v.email.$error && !$v.email.required"  class="text-red-500 text-lg">Email is required</div>
                                <div v-if="$v.email.$error && !$v.email.email"  class="text-red-500 text-lg">Please Enter a valid Email</div>
                            </div>
                        </div>

                        <div class="flex flex-wrap">
                            <div class="w-full mb-3">
                                <label class="block text-gray-700 text-lg font-medium mb-1" for="email">Message <span class="text-red-600">*</span></label>
                                <v-textarea v-model="message" :class="{ 'error--text': $v.message.$error }"  @input="$v.message.$touch()" @blur="$v.message.$touch()" class="form-input input-field-outer w-full text-gray-300" placeholder="Message" autocomplete required ></v-textarea>

                                <div v-if="$v.message.$error && !$v.message.required"  class="text-red-500 text-lg">Message is required</div>
                            </div>
                        </div>
                        <div class="flex flex-wrap mt-2">
                            <div class="w-full mb-3">
                                <v-btn class="btn text-white bg-purple-600 hover:bg-purple-700 w-full" @click="submit">Send</v-btn>
                            </div>
                        </div>
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
      name: {required},
      message: {required},
      subject: {required}
    },
    components: {
      Head,
      Layout,
    },
    props: {
      success: Object,
    },
    data: function () {
      return {
           subject: '',
            name:'',
            email:'',
            message:'',
            items: ['Feedback', 'Question', 'Report a Bug', 'Claim Profile'],
            hide:0,
        };
    },
    methods: {
        hideMessage(){
            console.log('here');
        this.hide = 1;
      },
      submit() {
          this.$v.$touch()
          if(!this.$v.$invalid) {
             let form = {email:this.email,message:this.message,name:this.name,subject:this.subject};
             this.$inertia.post('/contact', form);
             this.subject = '';
             this.email = '';
             this.message = '';
             this.name = '';
             this.$v.$reset()
          }
       },
    },
  }
</script>