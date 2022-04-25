<template>
  <Layout>
    <Head title="Contact Us" />
    <section class="relative contactUs--outer" data-app>
      <div class="max-w-6xl px-4 mx-auto sm:px-6">
        <div class="pb-12 pt-36 md:pt-40 md:pb-20">
          <!-- Page header -->
          <div class="max-w-2xl pb-10 mx-auto text-center">
            <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">
              How can we help you?
            </h1>
            <p class="pt-2 text-lg textColor">
              We have custom plans to power your business. Tell us your needs,
              and we’ll contact you shortly.
            </p>
          </div>
          <!-- Form -->
          <div class="max-w-xl mx-auto">
            <Message :message="errors.message" :hide="hide" v-on:hide="hideMessage" :type="'error'" />
            <Message :message="success.message" :hide="hide" v-on:hide="hideMessage" :type="'success'" />
            <v-form ref="form" @submit.prevent="submit">
              <div class="flex flex-wrap">
                <div class="w-full mb-3">
                  <label class="block mb-1 text-lg font-medium text-gray-700"
                    >Subject <span class="text-red-600">*</span></label
                  >
                  <v-row>
                    <v-col class="d-flex" cols="12">
                      <v-select
                        v-model="subject"
                        :items="items"
                        label="Subject"
                        class="w-full text-gray-700  form-input input-field-outer"
                        dense
                        solo
                        :class="{ 'error--text': $v.subject.$error }"
                      ></v-select>
                      <div
                        v-if="$v.subject.$error && !$v.subject.required"
                        class="text-lg text-red-500"
                      >
                        Subject is required
                      </div>
                    </v-col>
                  </v-row>
                </div>
              </div>

              <div class="flex flex-wrap">
                <div class="w-full mb-3">
                  <label
                    class="block mb-1 text-lg font-medium text-gray-700"
                    for="email"
                    >Name <span class="text-red-600">*</span></label
                  >
                  <v-text-field
                    v-model="name"
                    :class="{ 'error--text': $v.name.$error }"
                    @input="$v.name.$touch()"
                    @blur="$v.name.$touch()"
                    class="w-full text-gray-300 form-input input-field-outer"
                    placeholder="Name"
                    autocomplete
                    required
                  ></v-text-field>

                  <div
                    v-if="$v.name.$error && !$v.name.required"
                    class="text-lg text-red-500"
                  >
                    Name is required
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap">
                <div class="w-full mb-3">
                  <label
                    class="block mb-1 text-lg font-medium text-gray-700"
                    for="email"
                    >Email <span class="text-red-600">*</span></label
                  >
                  <v-text-field
                    v-model="email"
                    :class="{ 'error--text': $v.email.$error }"
                    @input="$v.email.$touch()"
                    @blur="$v.email.$touch()"
                    class="w-full text-gray-300 form-input input-field-outer"
                    placeholder="you@yourcompany.com"
                    autocomplete
                    required
                  ></v-text-field>

                  <div
                    v-if="$v.email.$error && !$v.email.required"
                    class="text-lg text-red-500"
                  >
                    Email is required
                  </div>
                  <div
                    v-if="$v.email.$error && !$v.email.email"
                    class="text-lg text-red-500"
                  >
                    Please Enter a valid Email
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap">
                <div class="w-full mb-3">
                  <label
                    class="block mb-1 text-lg font-medium text-gray-700"
                    for="email"
                    >Message <span class="text-red-600">*</span></label
                  >
                  <v-textarea
                    v-model="message"
                    :class="{ 'error--text': $v.message.$error }"
                    @input="$v.message.$touch()"
                    @blur="$v.message.$touch()"
                    class="w-full text-gray-300 form-input input-field-outer"
                    placeholder="Message"
                    autocomplete
                    required
                  ></v-textarea>

                  <div
                    v-if="$v.message.$error && !$v.message.required"
                    class="text-lg text-red-500"
                  >
                    Message is required
                  </div>
                </div>
              </div>
              <div class="flex flex-wrap mt-2">
                <div class="w-full mb-3">
                  <v-btn
                    class="w-full text-white bg-purple-600  btn hover:bg-purple-700"
                    @click="submit"
                    >Send</v-btn
                  >
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
import Layout from "./Layout";
import { Head } from "@inertiajs/inertia-vue";
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";
import Message from "../partials/Messages.vue";

export default {
  metaInfo: {
    title: "Contact Us",
    titleTemplate: "%s - Made in Tampa",
    meta: [
      { name: "description", content: "Companies Hiring in the Tampa Bay" },
    ],
  },

  mixins: [validationMixin],
  validations: {
    email: { required, email },
    name: { required },
    message: { required },
    subject: { required },
  },
  components: {
    Head,
    Layout,
    Message,
  },
  props: {
    success: Object,
    errors: Object,
  },
  data: function () {
    return {
      subject: "",
      name: "",
      email: "",
      message: "",
      items: ["Feedback", "Question", "Report a Bug", "Claim Profile"],
      hide: 0,
    };
  },
  methods: {
    hideMessage() {
      this.hide = 1;
    },
    submit() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        let form = {
          email: this.email,
          message: this.message,
          name: this.name,
          subject: this.subject,
        };
        this.$inertia.post("/contact", form);
        this.subject = "";
        this.email = "";
        this.message = "";
        this.name = "";
        this.$v.$reset();
      }
    },
  },
};
</script>