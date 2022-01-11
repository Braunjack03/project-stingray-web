<template>
    <Layout>
        <Head title="Job Posts" />
        <section class="relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="pt-32 pb-12 md:pt-40 md:pb-20">

                    <v-row>
                       <v-col cols="12" md="3" sm="4">
                        <div class="pb-8">
                            <h2 class="h2 mb-4 text-gray-700" data-aos="fade-up">Made in <br> Tampa <br> Settings </h2>
                        </div>
                        <ul class="settingLinks">
                            <li v-if="plan_name.name" class="no-underline text-lg text-gray-700">
                              Subscribed to the {{plan_name.name}} Using {{job_posts_count}}/{{plan_name.slot}} job slots (<a class="upgrade-link text-purple-600" href="/billing">upgrade</a>)
                            </li>
                            <li>
                              <a href="/employer/profile" class="no-underline text-lg text-gray-700 hover:text-purple-600">Your Profile</a>
                            </li>
                            <li>
                              <a :href="'/employer/edit-company?id='+company_details.uuid" class="no-underline text-lg text-gray-700 hover:text-purple-600">Company Profile</a>
                            </li>
                            <li>
                              <a :href="'/employer/jobs?c_id='+company_details.uuid" class="no-underline text-lg text-purple-700">Job Posts</a>
                            </li>
                            <li>
                              <a href="/billing" class="no-underline text-lg text-gray-700 hover:text-purple-600">Subscription</a>
                            </li>
                        </ul>
                       </v-col>

                       <v-col cols="12" md="9" sm="8" class="pl-3 md:pl-8">
                            <div class="pb-5 sm:pb-10 pt-0 sm:pt-11">
                                <h1 class="h1 mb-4 text-gray-700" data-aos="fade-up">{{ company_details.name }} Job Posts</h1>
                            </div>
                            <div class="testJobs">
                                <Link v-if="companies_count > 0 && job_posts_count < plan_name.slot" :href="'/employer/create-job?c_id=' + company_details.uuid" color="text" class="text-lg btn text-white bg-purple-600 hover:bg-purple-700 mb-3">Add New Job Post</Link>
            
                                <br /><br /><br />
                                <h3 class="h3 text-gray-700">Current Job Posts</h3>
                                <br />
            
                                <Message :message="$page.props.flash.message" :hide="0" :type="'success'" />
            
                                <div v-if="job_posts.length > 0">
                                    <v-row>
                                        <v-col cols="12" md="12" class="pa-3 d-flex flex-column" v-for="data in job_posts" :key="data.id">
                                            <v-card class="elevation-5 flex d-flex flex-column cardStyle">
                                                <v-card-text class="job-card-wrap">
                                                    <div class="card-text-wrap">
                                                        <v-card-title>{{data.name}}</v-card-title>
                                                        <div class="card-outter">
                                                            <div class="text-subtitle-1" v-if="data.company_name">Company Name: {{data.company_name}}</div>
                                                            <div class="description">Location: {{ data.location_id }}</div>
                                                            <div class="date text-lg">Published: {{ setDateFormat(data.created_on) }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="button-outter flex">
                                                      <Link :href="'/employer/edit-job?id=' + data.uuid" class="editJobsBtn text-white bg-purple-600 hover:bg-purple-700 pl-8 pt-3 pb-3 pr-7 text-lg">Edit</Link>
                                                      <v-btn class="text-white bg-purple-600 hover:bg-purple-700 text-lg" v-on:click="deletejob(data.uuid)" >Delete</v-btn>
                                                    </div>
                                                </v-card-text>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </div>
                                <div v-else>
                                    <v-row>
                                        <v-col cols="12" class="mt-5 text-center text-gray-700 text-lg">
                                            No Job Found
                                        </v-col>
                                    </v-row>
                                </div>
            
                                <!--ul v-if="job_posts" id="example-1">
                                    <li v-for="company in job_posts" :key="company.id">
                                        <v-row no-gutters class="mt-5">
                                            <div class="col-sm-12 col-md-12 col-8 bg-white rounded-xl shadow-md overflow-hidden mt-5">
                                                <div class="">
                                                    <v-col cols="12">
                                                        <h3 class="uppercase tracking-wide text-xl text-indigo-500 font-semibold">
                                                            {{ company.name }}
                                                        </h3>
                                                        <p class="mt-2 text-gray-800">
                                                            Location: {{ company.location_id }}
                                                        </p>
                                                        <p class="mt-2 text-gray-800">
                                                            Published: {{ setDateFormat(company.created_on) }}
                                                        </p>
                                                    </v-col>
                                                    <v-col cols="12 flex">
                                                        <Link :href="'/employer/edit-job?id=' + company.uuid" class="mr-4 btn text-purple-600 hover:text-purple-800 custom-link">EDIT</Link>
                                                        <v-btn class="mr-4 text-purple-600 hover:text-purple-800 custom-link" v-on:click="deletejob(company.uuid)" color="#3f51b5" plain link>Delete</v-btn>
                                                    </v-col>
                                                </div>
                                            </div>
                                        </v-row>
                                    </li>
                                </ul-->
                            </div>
                        </v-col>
                    </v-row>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script>
import Layout from "../Layout";
import { Head, Link } from "@inertiajs/inertia-vue";
import JobPost from '../../components/JobPost.vue';
import Message from '../../partials/Messages.vue';

export default {
    components: {
        Head,
        Layout,
        Link,
        'CustomCard': JobPost,
        Message,
    },
    props: {
        errors: Object,
        user: Object,
        success: Object,
        job_posts: Array,
        companies_count: Number,
        company_details: Object,
        plan_name: Array,
        job_posts_count: Number,
    },
    data: () => ({
        message: "",
        showCreate: false,
        valid: true,
        form: {
            profile_image: "",
            current_job_title: "",
            name: "",
            short_bio: "",
            profile_image_removed: 0,
        },
    }),
    methods: {
        validate() {
            this.$refs.form.validate();
            return true;
        },
        deletejob(id) {
            if (confirm("Do you really want to delete?")) {
                this.$inertia.get("/employer/delete-job/?id=" + id);
            }
            return false;
        },
        removeImage() {
            this.user.profile_image_src = "";
            this.user.profile_image_removed = 1;
        },
        showCreateForm() {
            this.showCreate = true;
        },
        setDateFormat(dateObject) {
            var d = new Date(dateObject);
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;

            return date;
        },
    },
};
</script>
