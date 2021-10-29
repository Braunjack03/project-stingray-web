<template>
<Layout>
    <Head title="Create Job" />
    <section class="relative">
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                <h1 class="h1 mb-4" data-aos="fade-up">Post a new Job</h1>
                <p>Job Information</p>
            </div>

            <div class="max-w-xl mx-auto">
                <div v-if="errors" class="mt-2 error">{{ errors.message }}</div>
                <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                <v-form ref="form" v-model="valid" validations >
    
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1">Job Title* </label>
                          <v-text-field v-model="user.name" required></v-text-field>
                          <div v-if="errors.name" class="mt-2 error">{{ errors.name }}</div>
                        </div>
                    </div>   

                    
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1">Location</label>

                     <v-row >
                      <v-col
                        class="d-flex"
                        cols="12"
                      >
                        <v-select
                          v-model='user.location_id'
                          item-text="name"
                          item-value="id"
                          :items="locations"
                          label="Location"
                        ></v-select>
                      </v-col>
                    <div v-if="errors.location_id" class="mt-2 error">{{ errors.location_id }}</div>
                    </v-row>   
                     </div>
                    </div> 

                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1">Job Category *</label>
                      <v-row >
                      <v-col
                        class="d-flex"
                        cols="12"
                      >
                        <v-select
                          v-model='user.job_cat_id'
                          item-text="name"
                          item-value="id"
                          :items="job_categories"
                          label="Job Category"
                        ></v-select>
                      </v-col>
                    <div v-if="errors.job_cat_id" class="mt-2 error">{{ errors.job_cat_id }}</div>
                    </v-row>
                     </div>
                    </div> 

                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1"> Job Application URL *</label>
                    <v-text-field v-model="user.apply_url" placeholder="https://example.com" required></v-text-field>
                    <div v-if="errors.apply_url" class="mt-2 error">{{ errors.apply_url }}</div>
                     </div>
                    </div> 

                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full px-3">
                          <label class="block text-gray-300 text-sm font-medium mb-1">Job Description *</label>
                    <tiptap-vuetify v-model="user.content" :extensions="extensions"  />

                     </div>
                    </div> 

                    <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit()" >Save Changes</v-btn>
                </v-form>
                </div>
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


  export default {
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
      company_uuid: String,
    },
     data: () => ({
        // declare extensions you want to use
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
    }),
     methods: {
      validate () {
        this.$refs.form.validate();
        return true;
      },
      submit() {
            this.$inertia.post('/employer/create-job?c_id='+this.company_uuid, this.user );
            this.$refs.form.resetValidation();
       },
    },
  }
</script>
