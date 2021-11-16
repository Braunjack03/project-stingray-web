<template>
    <Layout>
        <Head title="Edit Company" />
        <section class="relative" data-app>
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="pt-32 pb-12 md:pt-40 md:pb-20">
    
                    <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                        <h1 class="h1 mb-4 text-gray-700" data-aos="fade-up">Company Profile</h1>
                    </div>
    
                    <div class="max-w-xl mx-auto">
    
                        <div v-if="errors.message" class="text-red-500 text-sm mt-2">{{ errors.message }}</div>
                        <div v-if="success" class="text-green-500 text-sm mt-2">{{ success.message }}</div>
    
                        <v-form ref="form" >
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3 form-avataar">
                                    <v-icon v-if="user.logo_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()"> mdi-close-circle</v-icon>
                                    <v-img :src="user.logo_image_src" max-height="150" max-width="250"></v-img>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3 form-file-upload">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Company Logo (Recommended 500px x 500px) </label>
                                    <v-file-input class="fileUpload form-input input-field-outer w-full text-gray-700" v-model="user.logo_image_url" accept="image/*" @change="onFileChange" outlined dense></v-file-input>
    
                                </div>
                            </div>
    
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Company Name <span class="text-red-600">*</span></label>
                                    <v-text-field v-model="name" :class="{ 'error--text': $v.name.$error }"  @input="$v.name.$touch()" 
                              @blur="$v.name.$touch()"  class="form-input input-field-outer w-full text-gray-700" placeholder="Company Name" required></v-text-field>
                                    <div v-if="$v.name.$error && !$v.name.required"  class="text-red-500 text-sm">Company Name is required</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Number of local employees</label>
                                    <v-text-field v-model="local_employees"  @input="$v.local_employees.$touch()" 
                              @blur="$v.local_employees.$touch()"  :class="{ 'error--text': $v.local_employees.$error }" class="form-input input-field-outer w-full text-gray-700" placeholder="Number of local employees" required></v-text-field>
                                    <div v-if="$v.local_employees.$error && !$v.local_employees.required"  class="text-red-500 text-sm">Number of local employees</div>

                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Number of global employees</label>
                                    <v-text-field v-model="user.global_employees" class="form-input input-field-outer w-full text-gray-700" placeholder="Number of global employees" required></v-text-field>
                                    <div v-if="errors.global_employees" class="mt-2 error">{{ errors.global_employees }}</div>
                                </div>
                            </div>
    
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Company Website</label>
                                    <v-text-field v-model="user.website_url" class="form-input input-field-outer w-full text-gray-700" placeholder="https://example.com" required></v-text-field>
                                    <div v-if="errors.website_url" class="mt-2 error">{{ errors.website_url }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Company Mission</label>
                                    <v-text-field v-model="user.mission" class="form-input input-field-outer w-full text-gray-700" placeholder="Company Mission" required></v-text-field>
                                    <div v-if="errors.mission" class="mt-2 error">{{ errors.mission }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Company Industry (select up to 3)  </label>
                                    <ul class="industries-list">
                                        <li v-for="(item, index) in industries" :key="index">
                                            <label>
                              <input
                                type="checkbox"
                                v-model="user.industry_ids"
                                :value="index"
                                :disabled="user.industry_ids.length > 2 && user.industry_ids.indexOf(index) === -1" 
                                number> {{ item }} 
                            </label>
                                        </li>
                                    </ul>
                                    <div v-if="errors.industry" class="mt-2 error">{{ errors.industry }}</div>
                                </div>
                            </div>
    
                            <h3 class="text-gray-700">Local Address</h3>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Address</label>
                                    <v-text-field v-model="user.street_addr_1" class="form-input input-field-outer w-full text-gray-700" placeholder="Address" required></v-text-field>
                                    <div v-if="errors.street_addr_1" class="mt-2 error">{{ errors.street_addr_1 }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Address 2</label>
                                    <v-text-field v-model="user.street_addr_2" class="form-input input-field-outer w-full text-gray-700" placeholder="Address 2" required></v-text-field>
                                    <div v-if="errors.street_addr_2" class="mt-2 error">{{ errors.street_addr_2 }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">City </label>
                                    <v-text-field v-model="user.city" class="form-input input-field-outer w-full text-gray-700" placeholder="City" required></v-text-field>
                                    <div v-if="errors.city" class="mt-2 error">{{ errors.city }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">State </label>
                                    <v-row>
                                        <v-col class="d-flex" cols="12">
                                            <v-select v-model="user.state_abbr" :items="items" label="State" class="form-input input-field-outer w-full text-gray-700" dense solo></v-select>
                                        </v-col>
                                        <div v-if="errors.state" class="mt-2 error">{{ errors.state }}</div>
                                    </v-row>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Zipcode </label>
                                    <v-text-field v-model="user.postcode" class="form-input input-field-outer w-full text-gray-700" placeholder="Zipcode" required></v-text-field>
                                    <div v-if="errors.postcode" class="mt-2 error">{{ errors.postcode }}</div>
                                </div>
                            </div>
    
                            <h3 class="text-gray-700">Social</h3>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">LinkedIn</label>
                                    <v-text-field v-model="user.linkedin_user" class="form-input input-field-outer w-full text-gray-700" placeholder="LinkedIn"></v-text-field>
                                    <div v-if="errors.linkedin_user" class="mt-2 error">{{ errors.linkedin_user }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Facebook</label>
                                    <v-text-field v-model="user.facebook_user" class="form-input input-field-outer w-full text-gray-700" placeholder="Facebook"></v-text-field>
                                    <div v-if="errors.facebook_user" class="mt-2 error">{{ errors.facebook_user }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Twitter</label>
                                    <v-text-field v-model="user.twitter_user" class="form-input input-field-outer w-full text-gray-700" placeholder="Twitter"></v-text-field>
                                    <div v-if="errors.twitter_user" class="mt-2 error">{{ errors.twitter_user }}</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Instagram</label>
                                    <v-text-field v-model="user.instagram_user" class="form-input input-field-outer w-full text-gray-700" placeholder="Instagram">></v-text-field>
                                    <div v-if="errors.instagram_user" class="mt-2 error">{{ errors.instagram_user }}</div>
                                </div>
                            </div>
    
    
                            <div class="flex flex-wrap -mx-3 mt-6">
                                <div class="w-full px-3">
                                    <v-btn @click="submit()"  class="btn text-white bg-purple-600 hover:bg-purple-700 w-full">Update Changes</v-btn>
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mt-6 text-center">
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
import { validationMixin } from 'vuelidate'
import { required} from 'vuelidate/lib/validators'
export default {
     mixins: [validationMixin],
     validations: {
      name: { required},
      local_employees: {required},
    },
    components: {
        Head,
        Layout,
    },
    props: {
        errors: Object,
        user: Object,
        success: Object,
        industries: Object,
    },
    data (){
     return {
        name: this.user.name,
        local_employees: this.user.local_employees,
        logo_image_removed: 0,
        industry:[],
        items: ['Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming'],

     }
  },
    /*data: () => ({
        industry: [],
        items: ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'],
        valid:true,
        form: {
            logo_image_url: '',
            name: '',
            logo_image_removed: 0,
            state_abbr: '',
        },
    }),*/
    methods: {
        submit() {
            this.$v.$touch()
            if(!this.$v.$invalid) {
              let form = {
                  name: this.name,
                  logo_image_url: this.user.logo_image_url,
                  local_employees: this.local_employees,
                  global_employees: this.user.global_employees,
                  website_url: this.user.website_url,
                  mission: this.user.mission,
                  industry_ids: this.user.industry_ids,
                  street_addr_1: this.user.street_addr_1,
                  street_addr_2: this.user.street_addr_2,
                  city: this.user.city,
                  postcode: this.user.postcode,
                  state_abbr: this.user.state_abbr,
                  linkedin_user: this.user.linkedin_user,
                  facebook_user: this.user.facebook_user,
                  twitter_user: this.user.twitter_user,
                  instagram_user: this.user.instagram_user,
                  logo_image_removed: this.logo_image_removed,
                };
              this.$inertia.post('/employer/edit-company?id=' + this.user.uuid, form);
          }
            //this.$inertia.post('/employer/edit-company?id=' + this.user.uuid, form);
        },
        removeImage() {
            this.user.logo_image_src = '';
            this.user.logo_image_removed = 1;
        },
        onFileChange(e) {
            this.user.logo_image_src = URL.createObjectURL(this.user.logo_image_url);
        }
    },
}
</script>
