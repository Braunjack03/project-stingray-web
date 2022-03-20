<template>
    <Layout>
        <section data-app class="homeBanner">
            <div class="relative max-w-6xl px-4 mx-auto sm:px-6">
                <div class="pt-32 pb-0 md:pt-50 md:pb-20">
                    <div class="max-w-3xl pb-12 mx-auto text-center md:pb-16">
                        <h1 class="mt-0 text-white h1 md:mt-20 " data-aos="fade-up">
                            Your Source for Tampa Bay For Tech Jobs and News
                        </h1>
    
                        <div class="pb-6 md:pb-12 bannerForm">
                            <div class="pt-10 pb-3 mx-auto text-center">
                                <div class="flex filter-outer">
                                    <div class="filter-opt">
                                        <span class="searchIcon"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="#666">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg></span>
                                        <!-- <input type="text" name="" value="" class="float-right form-control pl-9" placeholder="Looking for" v-model="term" /> -->
                                        <v-text-field class="float-right mt-0 form-control locationField pl-9" :class="{ 'error--text': $v.term.$error }" placeholder="Looking for a job in..." v-model="term" @keydown.enter="submit" required></v-text-field>
                                        <div v-if="$v.term.$error && !$v.term.required" class="text-sm text-red-500 errorMsg-baaner">Looking for a job is required</div>
                                        <v-select v-model="location_id" item-text="name" item-value="id" :items="locations" label="Location" solo></v-select>
                                        <!--div v-if="$v.location_id.$error && !$v.location_id.required"  class="text-sm text-red-500 errorMsg-baaner forLocation-error">Location is required</div-->
                                        <v-btn class="w-full text-white bg-purple-600  btn hover:bg-purple-700" @click="submit">
                                            Search
                                        </v-btn>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
    
        </section>
        <CompaniesHiringNow />
        <BrowseJobs :data="companytypes" />
        <LatestArticles :articles="articles" />
        <!--Newsletter /-->
    </Layout>
</template>

<script>
import Layout from "./Layout";
import { Head, Link } from "@inertiajs/inertia-vue";
import Footer from "../partials/Footer.vue";
import CompaniesHiringNow from "../partials/CompaniesHiringNow.vue";
import LatestArticles from "./../partials/LatestArticles.vue";
//import Newsletter from './../partials/Newsletter.vue'
import BrowseJobs from './../partials/BrowseJobs.vue'
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'


export default {
    name: 'Home',
    metaInfo: {
        title: 'Made in Tampa',
        titleTemplate: 'Made in Tampa',
        meta: [
            { name: 'description', content: 'Made in Tampa' },
        ]
    },
  // child
  metaInfo() {
    return {
      meta: [
        {  
          name: 'description',
          content: 'Made in Tampa',
        },
        {  
          property: 'og:title',
          content: 'Made in Tampa',
        },
        {  
          property: 'og:url',
          content: this.base_url,
        },
        {  
          property: 'og:description',
          content: 'Made in Tampa',
        },
        {  
          property: 'og:site_name',
          content: 'Made in Tampa',
        },
      ]
    }
  },
    mixins: [validationMixin],
    validations: {
        term: { required },
    },
    components: {
        Head,
        Layout,
        Footer,
        CompaniesHiringNow,
        LatestArticles,
        BrowseJobs
    },
    props: {
        locations: Array,
        companytypes: Array || Object,
        articles: Array,
    },
    data() {
        return {
            location_id: "",
            term: "",
            base_url: window.location.origin,
        };
    },
    methods: {
        submit() {
            this.$v.$touch()
            if (this.$v.$invalid) {
                console.log('error!')
            } else {
                this.$inertia.replace(
                    "/jobs?loc=" + this.location_id + "&q=" + this.term
                );
            }
        },
    },
};
</script>
