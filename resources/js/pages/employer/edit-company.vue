<template>
    <Layout>
        <Head title="Company Profile" />
        <section class="relative" data-app>
            <div class="max-w-6xl px-4 mx-auto sm:px-6">
                <div class="pt-32 pb-12 md:pt-40 md:pb-20">
                    <v-row>
                        <v-col cols="12" md="3" sm="4" class="sm:pt-16">
                            <Sidebar :company_uuid="(user) ? user.uuid : ''" :plan="plan_name" :job_posts_count="job_posts_count" />
                        </v-col>
    
                        <v-col cols="12" md="9" sm="8" class="pl-3 md:pl-8">
                            <div class="pt-0 pb-0 sm:pb-10 sm:pt-11">
                                <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">Company Profile</h1>
                                <a style="color:#000;" class='text-lg teay-700xt-gr no-underline hover:text-purple-600' :href="'/companies/' + user.slug"> View Profile</a>
                            </div>
                            <div class="max-w-2xl">
    
                                <Message :message="errors.message" :hide="hide" v-on:hide="hideMessage" :type="'error'" />
                                <Message :message="success.message" v-on:hide="hideMessage" :hide="hide" :type="'success'" />
    
                                <Message :message="$page.props.flash.message" v-on:hide="hideMessage" :hide="hide" :type="'success'" />
    
                                <v-form ref="form">
                                    <!-- <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3 form-avataar">
                                            <v-icon v-if="user.logo_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()">
                                                mdi-close-circle
                                            </v-icon>
                                            <v-img :src="user.logo_image_src" max-height="150" max-width="250" />
                                        </div>
                                    </div> -->
    
                                    <div class="flex flex-nowrap mb-3">
                                        <div class="w-full px-3 form-file-upload">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Company Logo (Recommended 500px x 500px) </label>
                                            <v-file-input v-model="logo_image_url" class="w-full text-gray-700 fileUpload form-input input-field-outer" accept="image/*" outlined dense @change="onFileChange" />
                                        </div>
                                        <div v-if="user.logo_image_src" class="w-full px-3 form-avataar">
                                            <v-icon v-if="user.logo_image_src" color="gray darken-2" class="ml-auto" @click="removeImage()">
                                                mdi-close-circle
                                            </v-icon>
                                            <v-img :src="user.logo_image_src" max-height="150" max-width="250" />
                                        </div>
                                    </div>


                                    <!-- <div class="flex flex-nowrap mb-3">
                                        <div class="w-full px-3 form-file-upload">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Gallary Pics </label>
                                            <div class="p-12 bg-gray-100 border border-gray-300" @dragover="dragover" @dragleave="dragleave" @drop="drop">
                                                <v-file-input v-model="multi_image_url" multiple  class="w-full text-gray-700 fileUpload form-input input-field-outer" accept="image/*" outlined dense @change="onHeaderFileChange" />
                                            </div>
                                        </div>
                                        
                                        <div v-if="user.multi_image_url" class="w-full px-3 form-avataar">
                                            <v-icon v-if="user.multi_image_url" color="gray darken-2" class="ml-auto" @click="removeImage()">
                                                mdi-close-circle
                                            </v-icon>
                                            <v-img :src="user.multi_image_url" max-height="150" max-width="250" />
                                        </div>
                                    </div> -->
                    

                                       <div class="flex flex-nowrap mb-3">
                                           <div class="w-full px-3">
                                        <div class="galleryUpload" @dragover="dragover" @dragleave="dragleave" @drop="drop">
                                            <input type="file" multiple name="fields[assetsFieldHandle][]" :disabled="filelist.length > 1" id="assetsFieldHandle" 
                                            class="w-px h-px opacity-0 overflow-hidden absolute" @change="onChange" ref="file" accept=".gif,.jpg,.jpeg,.png" />
                                        
                                            <label for="assetsFieldHandle" class="block cursor-pointer">
                                            <div>
                                               Drag Files Here to upload
                                                 <span class="underline">Browse</span>
                                            </div>
                                            </label>
                                            
                                        </div>
                                           </div>
                                       </div>
                                       

                                        
                                            <div class="todo" v-for="file in this.fileUrls" :key="file">
                                                <v-icon color="gray darken-2" class="ml-auto" @click="remove(filelist.indexOf(file))">
                                                    mdi-close-circle
                                                </v-icon>
                                                <v-img :src="file" max-height="150" max-width="250" />
                                            </div>
                                         

    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Company Name <span class="text-red-600">*</span></label>
                                            <v-text-field v-model="name" :class="{ 'error--text': $v.name.$error }" class="w-full text-gray-700 form-input input-field-outer" placeholder="Company Name" required @input="$v.name.$touch()" @blur="$v.name.$touch()" />
                                            <div v-if="$v.name.$error && !$v.name.required" class="text-lg text-red-500">
                                                Company Name is required
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Number of local employees <span class="text-red-600">*</span></label>
                                            <v-text-field v-model="local_employees" :class="{ 'error--text': $v.local_employees.$error }" class="w-full text-gray-700 form-input input-field-outer" placeholder="Number of local employees" required @input="$v.local_employees.$touch()" @blur="$v.local_employees.$touch()"
                                            />
                                            <div v-if="$v.local_employees.$error && !$v.local_employees.required" class="text-lg text-red-500">
                                                Number of local employees is required
                                            </div>
                                            <div v-if="$v.local_employees.$error && !$v.local_employees.numeric" class="text-lg text-red-500">
                                                Number of local employees should be numeric
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Number of global employees</label>
                                            <v-text-field v-model="user.global_employees" class="w-full text-gray-700 form-input input-field-outer" placeholder="Number of global employees" required />
                                            <div v-if="errors.global_employees" class="mt-2 error">
                                                {{ errors.global_employees }}
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Company Website</label>
                                            <v-text-field v-model="user.website_url" class="w-full text-gray-700 form-input input-field-outer" placeholder="https://example.com" required />
                                        </div>
                                    </div>
    
                                    <!-- <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3 form-avataar">
                                            <v-icon v-if="user.featured_image_src" color="gray darken-2" class="ml-auto" @click="removeHeaderImage()">
                                                mdi-close-circle
                                            </v-icon>
    
                                            <v-img :src="user.featured_image_src" max-height="150" max-width="250" />
                                        </div>
                                    </div> -->
    
                                    <!-- <div class="flex flex-nowrap mb-3">
                                        <div class="w-full px-3 form-file-upload">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Header Image (Recommended 500px x 500px) </label>
                                            <v-file-input v-model="featured_image_url" class="w-full text-gray-700 fileUpload form-input input-field-outer" accept="image/*" outlined dense @change="onHeaderFileChange" />
                                        </div>
                                        <div v-if="user.featured_image_src" class="w-full px-3 form-avataar">
                                            <v-icon v-if="user.featured_image_src" color="gray darken-2" class="ml-auto" @click="removeHeaderImage()">
                                                mdi-close-circle
                                            </v-icon>
    
                                            <v-img :src="user.featured_image_src" max-height="150" max-width="250" />
                                        </div>
                                    </div> -->
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Company Mission</label>
                                            <v-text-field v-model="user.mission" class="w-full text-gray-700 form-input input-field-outer" placeholder="Company Mission" requiredAerospace />
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Company Description<span class="text-red-600">*</span></label>
                                            <v-textarea v-model="description" rows="4" class="w-full text-gray-700 form-input input-field-outer" placeholder="Company Description" />
                                            <div v-if="$v.description.$error && !$v.description.required" class="text-lg text-red-500">
                                                Company Description is required
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Company Industry (select up to 3) <span class="text-red-600">*</span></label>
                                            <ul class="industries-list companyIndustry__list">
                                                <li v-for="(item, index) in industries" :key="index">
                                                    <label>
                                                      <input
                                                        v-model="industry"
                                                        type="checkbox"
                                                        :value="index"
                                                        :disabled="industry.length > 2 && industry.indexOf(index) === -1"
                                                        number
                                                      > {{ item }}
                                                    </label>
                                                </li>
                                            </ul>
                                            <div v-if="$v.industry.$error && !$v.industry.required" class="text-lg text-red-500">
                                                Please Select at least one Company Industry
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Company Benefit (select up to 10)</label>
                                            <ul class="industries-list companyIndustry__list">
                                                <li v-for="(benefitItem, benefitItemIndex) in benefitCats" :key="benefitItemIndex">
                                                    <label>
                                                      <input
                                                        v-model="benefit"
                                                        type="checkbox"
                                                        :value="benefitItemIndex"
                                                       :disabled="benefit.length > 9 && benefit.indexOf(benefitItemIndex) === -1"
                                                       number
                                                      > {{ benefitItem }}
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
    
                                    <h3 class="mt-2 mb-1 ml-3 text-2xl text-gray-700">
                                        Local Address
                                    </h3>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Address</label>
                                            <v-text-field v-model="user.street_addr_1" class="w-full text-gray-700 form-input input-field-outer" placeholder="Address" required />
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Address 2</label>
                                            <v-text-field v-model="user.street_addr_2" class="w-full text-gray-700 form-input input-field-outer" placeholder="Address 2" required />
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">City </label>
                                            <v-text-field v-model="user.city" class="w-full text-gray-700 form-input input-field-outer" placeholder="City" required />
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">State </label>
                                            <v-row>
                                                <v-col class="d-flex" cols="12">
                                                    <v-select v-model="user.state_abbr" :items="items" label="State" class="w-full text-gray-700 form-input input-field-outer" dense solo />
                                                </v-col>
                                            </v-row>
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Zipcode </label>
                                            <v-text-field v-model="user.postcode" class="w-full text-gray-700 form-input input-field-outer" placeholder="Zipcode" required />
                                        </div>
                                    </div>
    
                                    <h3 class="px-3 mt-2 mb-1 ml-3 text-2xl text-gray-700">
                                        Social
                                    </h3>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">LinkedIn</label>
                                            <v-text-field v-model="user.linkedin_user" class="w-full text-gray-700 form-input input-field-outer" placeholder="LinkedIn" />
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Facebook</label>
                                            <v-text-field v-model="user.facebook_user" class="w-full text-gray-700 form-input input-field-outer" placeholder="Facebook" />
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Twitter</label>
                                            <v-text-field v-model="user.twitter_user" class="w-full text-gray-700 form-input input-field-outer" placeholder="Twitter" />
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Instagram</label>
                                            <v-text-field v-model="user.instagram_user" class="w-full text-gray-700 form-input input-field-outer" placeholder="Instagram">
                                                >
                                            </v-text-field>
                                        </div>
                                    </div>
    
                                    <div class="flex flex-wrap mt-5">
                                        <div class="w-full px-3">
                                            <v-btn class="w-full text-white bg-purple-600 btn hover:bg-purple-700" @click="submit()">
                                                Update Changes
                                            </v-btn>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap mt-5 text-center">
                                        <div class="w-full px-3">
                                            <p class="text-lg text-center text-gray-700">
                                                Please fill the required field(s)
                                            </p>
                                        </div>
                                    </div>
                                </v-form>
    
                            </div>
                        </v-col>
                    </v-row>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue';
import { validationMixin } from 'vuelidate';
import { required, numeric } from 'vuelidate/lib/validators';
import Layout from '../Layout.vue';
import Message from '../../partials/Messages.vue';
import Sidebar from '../../partials/Sidebar.vue';

export default {
    metaInfo() {
      return {
          title: `Company Profile`,
      }
    },
    delimiters: ['${', '}'],
    components: {
        Head,
        Layout,
        Message,
        Sidebar
    },
    mixins: [validationMixin],
    validations: {
        name: { required },
        local_employees: { required, numeric },
        industry: { required },
        description: { required },
    },
    props: {
        errors: Object,
        user: Object,
        success: Object,
        industries: Object || Array,
        industryTest: Array,
        companyProfileBenefitTag: Array,
        companyBenefit: Array,
        job_posts_count: Number,
        plan_name: Array && Object,
        benefitCats: Array && Object,
    },
    data() {
        return {
            name: this.user.name,
            local_employees: this.user.local_employees,
            description: this.user.description,
            logo_image_url: [],
            featured_image_url:[],
            multi_image_url:[],
            logo_image_removed: 0,
            // featured_image_removed: 0,
            hide: 0,
            industry: this.industryTest.map(x => `${x}`),
            benefit: this.companyProfileBenefitTag.map(x => `${x}`),
            items: ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'],
            filelist: [],
            fileUrls: [],
        };
    },
    methods: {
        submit() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                const form = {
                    name: this.name,
                    logo_image_url: this.logo_image_url,
                    local_employees: this.local_employees,
                    global_employees: this.user.global_employees,
                    website_url: this.user.website_url,
                    multi_image_url: this.multi_image_url,
                    mission: this.user.mission,
                    description: this.description,
                    industry: this.industry,
                    benefit: this.benefit,
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

                form.multi_image_url = this.filelist;
                this.hide = 0;
                this.$inertia.post(`/employer/edit-company?id=${this.user.uuid}`, form);
            }
            // this.$inertia.post('/employer/edit-company?id=' + this.user.uuid, form);
        },
        hideMessage() {
            this.hide = 1;
        },
        removeImage() {
            this.user.logo_image_src = '';
            this.user.logo_image_removed = 1;
        },
        removeHeaderImage() {
            this.user.featured_image_src = '';
            this.user.featured_image_removed = 1;
        },
        onFileChange() {
            this.user.logo_image_src = URL.createObjectURL(this.logo_image_url);
        },
        onHeaderFileChange() {
            this.user.multi_image_url = URL.createObjectURL(this.multi_image_url);
        },
        onChange() {
            this.fileUrls = [];
            this.filelist = [...this.$refs.file.files];
            if(this.filelist.length > 0){
                this.fileUrls = [];
                this.filelist.forEach((value, index) => {
                this.fileUrls.push(URL.createObjectURL(value));
                });
            }
            },
        remove(i) {
            this.filelist.splice(i, 1);
            this.fileUrls.splice(i, 1);
        },
        dragover(event) {
            event.preventDefault();
            // Add some visual fluff to show the user can drop its files
            if (!event.currentTarget.classList.contains('bg-green-300')) {
                event.currentTarget.classList.remove('bg-gray-100');
                event.currentTarget.classList.add('bg-green-300');
            }
        },
        dragleave(event) {
            // Clean up
            event.currentTarget.classList.add('bg-gray-100');
            event.currentTarget.classList.remove('bg-green-300');
        },
        drop(event) {
            event.preventDefault();
            this.$refs.file.files = event.dataTransfer.files;
            this.onChange(); // Trigger the onChange event manually
            // Clean up
            event.currentTarget.classList.add('bg-gray-100');
            event.currentTarget.classList.remove('bg-green-300');
        }
    },
};
</script>
<style scoped>
[v-cloak] {
  display: none;
}
</style>