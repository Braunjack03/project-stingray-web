<template>
    <Layout>
        <Head title="Home" />
    
        <section data-app class="homeBanner">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 relative">
                <div class="pt-32 pb-12 md:pt-40 md:pb-20">
                    <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                        <h1 class="h1 text-white" data-aos="fade-up">
                            Exciting Career Oppurtunities {{ count_job_posts }} Open Jobs
                        </h1>
    
                        <div class="pb-12 bannerForm">
                            <div class="mx-auto text-center pt-10 pb-3">
                                <h3 class="quickSearch mb-6">Qiuck Search</h3>
                                <div class="flex filter-outer">
                                    <div class="filter-opt">
                                        <!-- <v-select v-model="location_id" item-text="name" item-value="id" :items="locations" label="Location" solo></v-select> -->
                                        <input type="text" name="" value="" class="form-control float-right" placeholder="Looking for" v-model="term" />
                                        <input type="text" name="" value="" class="form-control float-right" placeholder="Location" v-model="term" />
    
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
        <Process />
         <BrowseJobs/>
        <Target />
        <Newsletter />
        <!--section data-app>
                   <div class="max-w-6xl mx-auto px-4 sm:px-6 relative">
                         <div class="pt-32 pb-12 md:pt-40 md:pb-20">
                      
                      <div class="max-w-3xl mx-auto text-center pb-12 md:pb-16">
                         <h1 class="h1 mb-4 text-gray-600" data-aos="fade-up">Exciting Career Oppurtunities {{count_job_posts}} Open Jobs</h1>
    
                      <div class="pt-10 pb-12">
    
                         <div class="mx-auto text-center pt-10 pb-3">
                            <div class="flex filter-outer">
                               <div class="filter-opt">
                               <v-select
                               v-model='location_id'
                               item-text="name"
                               item-value="id"
                               :items="locations"
                               label="Location"
                               solo
                               ></v-select>
                               <input type="text" name="table_search" value= '' class="form-control float-right" placeholder="Search" v-model="term" >
    
                                  <v-btn class="btn text-white bg-purple-600 hover:bg-purple-700 w-full" @click="submit">
                                     Search
                                  </v-btn>
                               </div>
                            </div>
                         </div>
    
                            
                        </div>
                      </div-->
    
        <!--div class="max-w-3xl mx-auto text-center pb-12 md:pb-16 features section">
                                     <h2 class="h2">Get an exclusive look inside hundreds of companies hiring now</h2>
                            </div>   
                      </div>
    
    
                     </div-->
        <!--/section-->
    </Layout>
</template>

<script>
import Layout from "./Layout";
import { Head, Link } from "@inertiajs/inertia-vue";
import Footer from "../partials/Footer.vue";
import HeroHome from "../partials/HeroHome.vue";
import Process from "./../partials/Process.vue";
import Target from "./../partials/Target.vue";
import Newsletter from './../partials/Newsletter.vue'
import BrowseJobs from './../partials/BrowseJobs.vue'



export default {
    components: {
        Head,
        Layout,
        Footer,
        HeroHome,
        Process,
        Target,
        Newsletter,
        BrowseJobs
    },
    props: {
        count_job_posts: Number,
        locations: Array,
    },
    data() {
        return {
            location_id: "",
            term: "",
        };
    },
    methods: {
        submit() {
            this.$inertia.replace(
                "/jobs?loc=" + this.location_id + "&q=" + this.term
            );
        },
    },
};
</script>
