<template>
<Layout>
    <Head title="Edit Job" />
    <section class="relative" data-app> 
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            <div class="max-w-3xl text-gray-700 mx-auto text-center pb-10">
                <h1 class="h1 mb-4" data-aos="fade-up">Update Job </h1>
                <p>Job Information</p>
            </div>

            <div class="max-w-xl mx-auto">
                 <div v-if="errors.message" class="text-red-500 text-sm font-bold text-center text-sm my-3">
                  {{ errors.message }}
                </div>
                <div v-if="success" class="text-green-500 text-sm font-bold text-center text-sm my-3">
                  {{ success.message }}
                </div>
                <v-form ref="form"  >
                    
                    <div class="flex flex-wrap mb-3">
                        <div class="w-full px-3">
                          <label class="block text-gray-700 text-sm font-medium mb-1">Job Title <span class="text-red-600">*</span></label>
                          <v-text-field v-model="name" class="form-input input-field-outer w-full text-gray-700" placeholder="Job Title" :class="{ 'error--text': $v.name.$error }"
                              @input="$v.name.$touch()" 
                              @blur="$v.name.$touch()" required ></v-text-field>
                          <div v-if="$v.name.$error && !$v.name.required"  class="text-red-500 text-sm">Job Title is required</div>
                        </div>
                    </div>   

                    <div class="flex flex-wrap mb-3">
                        <div class="w-full px-3">
                          <label class="block text-gray-700 text-sm font-medium mb-1">Location</label>

                     <v-row >
                      <v-col
                        class="d-flex"
                        cols="12"
                      >
                        <v-select
                          v-model='location_id'
                          item-text="name"
                          item-value="id"
                          :items="locations"
                          label="Location"
                          class="form-input input-field-outer w-full text-gray-700"
                          dense
                          solo
                        ></v-select>
                      </v-col>
                    <div v-if="errors.location_id" class="mt-2 error">{{ errors.location_id }}</div>
                    </v-row>   
                     </div>
                    </div> 

                    <div class="flex flex-wrap mb-3">
                        <div class="w-full px-3">
                          <label class="block text-gray-700 text-sm font-medium mb-1">Job Category <span class="text-red-600">*</span></label>
                      <v-row >
                      <v-col
                        class="d-flex"
                        cols="12"
                      >
                        <v-select
                          v-model='job_cat_id'
                          item-text="name"
                          item-value="id"
                          :items="job_categories"
                          label="Job Category"
                          class="form-input input-field-outer w-full text-gray-700"
                          :class="{ 'error--text': $v.job_cat_id.$error }"
                          dense
                          solo
                        ></v-select>
                         <div v-if="$v.job_cat_id.$error && !$v.job_cat_id.required"  class="text-red-500 text-sm">Job Category is required</div>
                      </v-col>
                    
                    </v-row>
                     </div>
                    </div> 

                    <div class="flex flex-wrap mb-3">
                        <div class="w-full px-3">
                          <label class="block text-gray-700 text-sm font-medium mb-1"> Job Application URL <span class="text-red-600">*</span></label>
                    <v-text-field v-model="apply_url" :class="{ 'error--text': $v.apply_url.$error }" class="form-input input-field-outer w-full text-gray-700" placeholder="https://example.com" required></v-text-field>
                    <div v-if="$v.apply_url.$error && !$v.apply_url.required"  class="text-red-500 text-sm">Job Application URL is required</div>
                     </div>
                    </div> 

                    <div class="flex flex-wrap mb-43">
                        <div class="w-full px-3">
                          <label class="block text-gray-700 text-sm font-medium mb-1">Job Description </label>
                      <tiptap-vuetify v-model="content" :extensions="extensions" class="form-input input-field-outer w-full text-gray-700" />

                     </div>
                    </div> 


                     <div class="flex flex-wrap mt-5">
                        <div class="w-full px-3">
                          <v-btn  @click="submit()" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full">Update Changes</v-btn>
                        </div>
                      </div>

                      <div class="flex flex-wrap mt-5 text-center">
                        <div class="w-full px-3">
                          <p class="text-center text-gray-700">Please fill the required field(s)</p>                        
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
  import Layout from '../Layout'
  import { Head } from '@inertiajs/inertia-vue'
  import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'
   import { validationMixin } from 'vuelidate'
import { required} from 'vuelidate/lib/validators'

  export default {
     mixins: [validationMixin],
     validations: {
      name: { required},
      job_cat_id: {required},
      apply_url: {required},
      content: {required}
    },
    components: {
      Head,
      Layout,
      TiptapVuetify
    },
    props: {
      errors : Object,  
      user: Object,
      success: Object,
      job_categories: Array,
      locations : Array,
    },
     data (){
     return {
        name: this.user.name,
        apply_url: this.user.apply_url,
        job_cat_id: this.user.job_cat_id,
        location_id: this.user.location_id,
        remotetype_id: (this.user.remotetype_id ? true : false),
        content: this.user.content,
        extensions: [
          History,
          Blockquote,
          Link,
          Underline,
          Strike,
          Italic,
          ListItem,
          BulletList,
          OrderedList,
          [Heading, {
            options: {
              levels: [1, 2, 3]
            }
          }],
          Bold,
          Code,
          HorizontalRule,
          Paragraph,
          HardBreak
        ],
     }
  },
     /*data: (user) => ({
        // declare extensions you want to use
        remotetype_id: (user.remotetype_id ? true : false),
        extensions: [
          History,
          Blockquote,
          Link,
          Underline,
          Strike,
          Italic,
          ListItem,
          BulletList,
          OrderedList,
          [Heading, {
            options: {
              levels: [1, 2, 3]
            }
          }],
          Bold,
          Code,
          HorizontalRule,
          Paragraph,
          HardBreak
        ],
        // starting editor's content
        content: ``,
        message: '',
        valid: true,
        form: {
            profile_image: '',
            name: '',
            logo_image_removed: 0,
            logo_image_src: '',
        },
    }),*/
     methods: {
      submit() {
          this.$v.$touch();
          if(!this.$v.$invalid) {
              let form = {
                  name: this.name,
                  apply_url: this.apply_url,
                  job_cat_id: this.job_cat_id,
                  location_id: this.location_id,
                  content:this.content,
                  remotetype_id: this.remotetype_id,
                };

              console.log('test',form);
              this.$inertia.post('/employer/edit-job?id='+this.user.uuid, form );
          }
       },
    },
  }
</script>
