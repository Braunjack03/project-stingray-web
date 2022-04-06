<template>
  <Layout>
    <Head title="Company Profile" />
    <section
      class="relative"
      data-app
    >
      <div class="max-w-6xl px-4 mx-auto sm:px-6">
        <div class="pt-32 pb-12 md:pt-40 md:pb-20">
          <v-row>
               <v-col cols="12" md="3" sm="4">
                 <Sidebar :company_uuid="(user) ? user.uuid : ''" :plan="plan_name" :job_posts_count="job_posts_count"/>
               </v-col>

               <v-col cols="12" md="9" sm="8" class="pl-3 md:pl-8">
                  <div class="pt-0 pb-0 sm:pb-10 sm:pt-11">
                      <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">Company Profile</h1>
                  </div>
                    <div class="max-w-2xl">

            <Message
              :message="errors.message"
              :hide="0"
              :type="'error'"
            />
            <Message
              :message="success.message"
              :hide="0"
              :type="'success'"
            />

            <Message :message="$page.props.flash.message" :hide="0" :type="'success'" />

            <v-form ref="form">
              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3 form-avataar">
                  <v-icon
                    v-if="user.logo_image_src"
                    color="gray darken-2"
                    class="ml-auto"
                    @click="removeImage()"
                  >
                    mdi-close-circle
                  </v-icon>
                  <v-img
                    :src="user.logo_image_src"
                    max-height="150"
                    max-width="250"
                  />
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3 form-file-upload">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Company Logo (Recommended 500px x 500px) </label>
                  <v-file-input
                    v-model="user.logo_image_url"
                    class="w-full text-gray-700 fileUpload form-input input-field-outer"
                    accept="image/*"
                    outlined
                    dense
                    @change="onFileChange"
                  />
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Company Name <span class="text-red-600">*</span></label>
                  <v-text-field
                    v-model="name"
                    :class="{ 'error--text': $v.name.$error }"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Company Name"
                    required
                    @input="$v.name.$touch()"
                    @blur="$v.name.$touch()"
                  />
                  <div
                    v-if="$v.name.$error && !$v.name.required"
                    class="text-lg text-red-500"
                  >
                    Company Name is required
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Number of local employees</label>
                  <v-text-field
                    v-model="local_employees"
                    :class="{ 'error--text': $v.local_employees.$error }"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Number of local employees"
                    required
                    @input="$v.local_employees.$touch()"
                    @blur="$v.local_employees.$touch()"
                  />
                  <div
                    v-if="$v.local_employees.$error && !$v.local_employees.required"
                    class="text-lg text-red-500"
                  >
                    Number of local employees
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Number of global employees</label>
                  <v-text-field
                    v-model="user.global_employees"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Number of global employees"
                    required
                  />
                  <div
                    v-if="errors.global_employees"
                    class="mt-2 error"
                  >
                    {{ errors.global_employees }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Company Website</label>
                  <v-text-field
                    v-model="user.website_url"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="https://example.com"
                    required
                  />
                  <div
                    v-if="errors.website_url"
                    class="mt-2 error"
                  >
                    {{ errors.website_url }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3 form-avataar">
                  <v-icon
                    v-if="user.featured_image_src"
                    color="gray darken-2"
                    class="ml-auto"
                    @click="removeHeaderImage()"
                  >
                    mdi-close-circle
                  </v-icon>

                  <v-img
                    :src="user.featured_image_src"
                    max-height="150"
                    max-width="250"
                  />
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3 form-file-upload">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Header Image (Recommended 500px x 500px) </label>
                  <v-file-input
                    v-model="user.featured_image_url"
                    class="w-full text-gray-700 fileUpload form-input input-field-outer"
                    accept="image/*"
                    outlined
                    dense
                    @change="onHeaderFileChange"
                  />
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Company Mission</label>
                  <v-text-field
                    v-model="user.mission"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Company Mission"
                    required
                  />
                  <div
                    v-if="errors.mission"
                    class="mt-2 error"
                  >
                    {{ errors.mission }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Company Description</label>
                  <v-textarea
                    v-model="user.description"
                    rows="4"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Company Description"
                    required
                  />
                  <div
                    v-if="errors.description"
                    class="mt-2 error"
                  >
                    {{ errors.description }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Company Industry (select up to 3)  </label>
                  <ul class="industries-list companyIndustry__list">
                    <li
                      v-for="(item, index) in industries"
                      :key="index"
                      :value="item"
                    >
                      <label>
                        <input
                          :id="'test_'+index"
                          v-model="industry"
                          type="checkbox"
                          :value="index"
                          :label="item"
                          :disabled="industry.length > 2 && industry.indexOf(index) === -1"
                        > {{ item }}
                      </label>
                    </li>
                  </ul>
                   <div
                    v-if="$v.industry.$error && !$v.industry.required"
                    class="text-lg text-red-500"
                  >
                    Please Select at least one Company Industry
                  </div>
                </div>
              </div>

              <h3 class="mt-2 mb-1 ml-3 text-2xl text-gray-700">
                Local Address
              </h3>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Address</label>
                  <v-text-field
                    v-model="user.street_addr_1"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Address"
                    required
                  />
                  <div
                    v-if="errors.street_addr_1"
                    class="mt-2 error"
                  >
                    {{ errors.street_addr_1 }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Address 2</label>
                  <v-text-field
                    v-model="user.street_addr_2"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Address 2"
                    required
                  />
                  <div
                    v-if="errors.street_addr_2"
                    class="mt-2 error"
                  >
                    {{ errors.street_addr_2 }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">City </label>
                  <v-text-field
                    v-model="user.city"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="City"
                    required
                  />
                  <div
                    v-if="errors.city"
                    class="mt-2 error"
                  >
                    {{ errors.city }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">State </label>
                  <v-row>
                    <v-col
                      class="d-flex"
                      cols="12"
                    >
                      <v-select
                        v-model="user.state_abbr"
                        :items="items"
                        label="State"
                        class="w-full text-gray-700 form-input input-field-outer"
                        dense
                        solo
                      />
                    </v-col>
                    <div
                      v-if="errors.state"
                      class="mt-2 error"
                    >
                      {{ errors.state }}
                    </div>
                  </v-row>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Zipcode </label>
                  <v-text-field
                    v-model="user.postcode"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Zipcode"
                    required
                  />
                  <div
                    v-if="errors.postcode"
                    class="mt-2 error"
                  >
                    {{ errors.postcode }}
                  </div>
                </div>
              </div>

              <h3 class="px-3 mt-2 mb-1 ml-3 text-2xl text-gray-700">
                Social
              </h3>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">LinkedIn</label>
                  <v-text-field
                    v-model="user.linkedin_user"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="LinkedIn"
                  />
                  <div
                    v-if="errors.linkedin_user"
                    class="mt-2 error"
                  >
                    {{ errors.linkedin_user }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Facebook</label>
                  <v-text-field
                    v-model="user.facebook_user"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Facebook"
                  />
                  <div
                    v-if="errors.facebook_user"
                    class="mt-2 error"
                  >
                    {{ errors.facebook_user }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Twitter</label>
                  <v-text-field
                    v-model="user.twitter_user"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Twitter"
                  />
                  <div
                    v-if="errors.twitter_user"
                    class="mt-2 error"
                  >
                    {{ errors.twitter_user }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mb-3">
                <div class="w-full px-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700">Instagram</label>
                  <v-text-field
                    v-model="user.instagram_user"
                    class="w-full text-gray-700 form-input input-field-outer"
                    placeholder="Instagram"
                  >
                    >
                  </v-text-field>
                  <div
                    v-if="errors.instagram_user"
                    class="mt-2 error"
                  >
                    {{ errors.instagram_user }}
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap mt-5">
                <div class="w-full px-3">
                  <v-btn
                    class="w-full text-white bg-purple-600 btn hover:bg-purple-700"
                    @click="submit()"
                  >
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
import { required } from 'vuelidate/lib/validators';
import Layout from '../Layout.vue';
import Message from '../../partials/Messages.vue';
import Sidebar from '../../partials/Sidebar.vue';

export default {
  components: {
    Head,
    Layout,
    Message,
    Sidebar
  },
  mixins: [validationMixin],
  validations: {
    name: { required },
    local_employees: { required },
    industry:{required}
  },
  props: {
    errors: Object,
    user: Object,
    success: Object,
    industries: Object || Array,
    industryTest: Array,
    job_posts_count: Number,
    plan_name: Array && Object,
  },
  data() {
    return {
      name: this.user.name,
      local_employees: this.user.local_employees,
      logo_image_removed: 0,
      featured_image_removed: 0,
      industry: this.industryTest.map(x => `${x}`),
      items: ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'],

    };
  },
  methods: {
    submit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        const form = {
          name: this.name,
          logo_image_url: this.user.logo_image_url,
          local_employees: this.local_employees,
          global_employees: this.user.global_employees,
          website_url: this.user.website_url,
          featured_image_url: this.user.featured_image_url,
          mission: this.user.mission,
          description: this.user.description,
          industry: this.industry,
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
        this.$inertia.post(`/employer/edit-company?id=${this.user.uuid}`, form);
      }
      // this.$inertia.post('/employer/edit-company?id=' + this.user.uuid, form);
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
      this.user.logo_image_src = URL.createObjectURL(this.user.logo_image_url);
    },
    onHeaderFileChange() {
      this.user.featured_image_src = URL.createObjectURL(this.user.featured_image_url);
    },
  },
};
</script>
