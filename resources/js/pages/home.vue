<template>
    <Layout>
        <Head>
            <title>Made in Tampa</title>
            <meta name="description" content="Made in Tampa">
        </Head>
        <section data-app class="homeBanner">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 relative">
                <div class="pt-32 pb-0 md:pt-50 md:pb-20">
                    <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                        <h1 class="h1 text-white mt-0 md:mt-20 " data-aos="fade-up">
                            Your home for Tampa Bay technology jobs and news
                        </h1>
    
                        <div class="pb-6 md:pb-12 bannerForm">
                            <div class="mx-auto text-center pt-10 pb-3">
                                <div class="flex filter-outer">
                                    <div class="filter-opt">
                                        <span class="searchIcon"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="#666">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg></span>
                                        <!-- <input type="text" name="" value="" class="form-control float-right pl-9" placeholder="Looking for" v-model="term" /> -->
                                        <v-text-field class="form-control locationField float-right pl-9 mt-0" :class="{ 'error--text': $v.term.$error }" placeholder="Looking for a job in..." v-model="term" @keydown.enter="submit" required ></v-text-field>
                                        <div v-if="$v.term.$error && !$v.term.required"  class="text-red-500 text-sm errorMsg-baaner">Looking for a job is required</div>
                                        <v-select v-model="location_id" item-text="name" item-value="id" :items="locations" label="Location" solo ></v-select>
                                        <!--div v-if="$v.location_id.$error && !$v.location_id.required"  class="text-red-500 text-sm errorMsg-baaner forLocation-error">Location is required</div-->
                                        <v-btn class="
                                            btn
                                            text-white
                                            bg-purple-600
                                            hover:bg-purple-700
                                            w-full
                                          " @click="submit">
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
        <BrowseJobs :data="companytypes"/>
        <LatestArticles :articles="articles"/>
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
import { required} from 'vuelidate/lib/validators'


export default {
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
        };
    },
    methods: {
        submit() {
            this.$v.$touch()
          if(this.$v.$invalid) {
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
