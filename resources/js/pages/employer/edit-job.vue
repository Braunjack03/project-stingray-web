<template>
<Layout>
    <Head title="Create Job" />
    <section class="relative">
          <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="pt-32 pb-12 md:pt-40 md:pb-20">

            <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                <h1 class="h1 mb-4" data-aos="fade-up">Update Job </h1>
                <p>Job Information</p>
            </div>

            <div class="max-w-xl mx-auto">
                <div v-if="errors" class="mt-2 error">{{ errors.message }}</div>
                <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                <v-form ref="form" v-model="valid" validations >
    
                    <label>Job Title* </label>
                    <v-text-field v-model="user.name" required></v-text-field>
                    <div v-if="errors.name" class="mt-2 error">{{ errors.name }}</div>

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
                    <label>Job Category *</label>
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

                    <label>Job Application URL *</label>
                    <v-text-field v-model="user.apply_url" placeholder="https://example.com" required></v-text-field>
                    <div v-if="errors.apply_url" class="mt-2 error">{{ errors.apply_url }}</div>

                    <label>Job Description *</label>
                    <tiptap-vuetify v-model="user.content" :extensions="extensions"  />
                    <br/>
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
    },
     data: (user) => ({
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
    }),
     methods: {
      validate () {
        this.$refs.form.validate();
        return true;
      },
      submit() {
            this.$inertia.post('/employer/edit-job?id='+this.user.uuid, this.user );
            this.$refs.form.resetValidation();
       },
    },
  }
</script>
