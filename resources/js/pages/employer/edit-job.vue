<template>
<Layout>
    <Head title="Edit Job" />
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">

            <h2>Update Job  </h2> 
            <h3>Job Information</h3>
            <br/>
                <div v-if="errors" class="mt-2 error">{{ errors.message }}</div>
                <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                <v-form ref="form" v-model="valid" validations >
    
                    <label>Job Title* </label>
                    <v-text-field v-model="user.name" required></v-text-field>
                    <div v-if="errors.name" class="mt-2 error">{{ errors.name }}</div>

                    <label>Location*</label>
                      <v-checkbox
                        v-model="user.remotetype_id"
                        label= "Remote"
                      ></v-checkbox> 
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
                <br/><br/>
            </v-card> 
       
        </v-container>
    </v-app>
</Layout>
</template>
<script>
  import Layout from './Layout'
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
