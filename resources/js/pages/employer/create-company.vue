<template>
<Layout>
    <Head title="Employer Profile" />
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-12 py-8" elevation="2">

            <h2>Company Profile  </h2> 
            <br/>
                <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                <v-form ref="form" v-model="valid" validations >
    
                    <label>Company Logo (Recommended 500px x 500px) </label>
                    <v-file-input v-model="user.logo_image_url" accept="image/*" @change="onFileChange" show-size counter outlined dense></v-file-input>
                    
                    <v-icon v-if="user.logo_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()"> mdi-close-circle</v-icon>
                    
                    <v-img
                      :src="user.logo_image_src"
                      max-height="150"
                      max-width="250"
                    ></v-img>
                    
                     <br/><br/>   
                    <label>Company Name *</label>
                    <v-text-field v-model="user.name" required></v-text-field>
                    <div v-if="errors.name" class="mt-2 error">{{ errors.name }}</div>

                    <label>Number of local employees *</label>
                    <v-text-field v-model="user.local_employees" required></v-text-field>
                    <div v-if="errors.local_employees" class="mt-2 error">{{ errors.local_employees }}</div>
                    
                    <label>Number of global employees *</label>
                    <v-text-field v-model="user.global_employees" required></v-text-field>
                    <div v-if="errors.global_employees" class="mt-2 error">{{ errors.global_employees }}</div>

                    <label>Company Website *</label>
                    <v-text-field v-model="user.website_url" required></v-text-field>
                    <div v-if="errors.website_url" class="mt-2 error">{{ errors.website_url }}</div>

                    <label>Company Mission *</label>
                    <v-textarea v-model="user.mission" rows="2" required></v-textarea>
                    <div v-if="errors.mission" class="mt-2 error">{{ errors.mission }}</div>
                    
                    <label>Company Industry (select up to 3) * </label>
                    <ul class="industries-list">
                      <li v-for="(item, index) in industries" :key="index">
                        <label>
                          <input
                            type="checkbox"
                            v-model="industry"
                            :value="index"
                            :disabled="industry.length > 2 && industry.indexOf(index) === -1" 
                            number> {{ item }} 
                        </label>
                      </li>
                    </ul>
                    <div v-if="errors.industry" class="mt-2 error">{{ errors.industry }}</div>

                    <h3>Local Address</h3>  

                    <label>Address *</label>
                    <v-text-field v-model="user.street_addr_1"  required></v-text-field>
                    <div v-if="errors.street_addr_1" class="mt-2 error">{{ errors.street_addr_1 }}</div>

                    <label>Address 2*</label>
                    <v-text-field v-model="user.street_addr_2"  required></v-text-field>
                    <div v-if="errors.street_addr_2" class="mt-2 error">{{ errors.street_addr_2 }}</div>

                    <label>City *</label>
                    <v-text-field v-model="user.city" required></v-text-field>
                    <div v-if="errors.city" class="mt-2 error">{{ errors.city }}</div>

                    <label>State *</label>
                      <v-row >
                      <v-col
                        class="d-flex"
                        cols="12"
                      >
                        <v-select
                          v-model='user.state_abbr'
                          :items="items"
                          label="State"
                        ></v-select>
                      </v-col>
                    <div v-if="errors.state_abbr" class="mt-2 error">{{ errors.state }}</div>
                    </v-row>
                    <label>Zipcode *</label>
                    <v-text-field v-model="user.postcode" required></v-text-field>
                    <div v-if="errors.postcode" class="mt-2 error">{{ errors.postcode }}</div>

                    <h3>Social</h3>  

                     <label>LinkedIn</label>
                    <v-text-field v-model="user.linkedin_user"></v-text-field>
                    <div v-if="errors.linkedin_user" class="mt-2 error">{{ errors.linkedin_user }}</div>

                     <label>Facebook</label>
                    <v-text-field v-model="user.github_user"></v-text-field>
                    <div v-if="errors.github_user" class="mt-2 error">{{ errors.facebook_user }}</div>

                     <label>Twitter</label>
                    <v-text-field v-model="user.twitter_user"></v-text-field>
                    <div v-if="errors.twitter_user" class="mt-2 error">{{ errors.twitter_user }}</div>

                    <label>Instagram</label>
                    <v-text-field v-model="user.instagram_user"></v-text-field>
                    <div v-if="errors.instagram_user" class="mt-2 error">{{ errors.instagram_user }}</div>
                   
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
  export default {
    components: {
      Head,
      Layout,
    },
    props: {
      errors : Object,  
      user: Object,
      success: Object,
      industries: Object
    },
     data: () => ({
        industry:[],
        items: ['Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming'],
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
            this.user.industry = this.industry;
            this.$inertia.post('/employer/create-company', this.user );
            this.$refs.form.resetValidation();
       },
      removeImage(){
          this.user.logo_image_src = '';
          this.user.logo_image_url = '';
          this.user.logo_image_removed = 1;
      }, 
      onFileChange() {
        this.user.logo_image_src = URL.createObjectURL(this.user.logo_image_url)
      },  
    },
  }
</script>
