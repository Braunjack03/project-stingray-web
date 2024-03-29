<template>
    <Layout>
        <Head title="Job Posts" />
        <section class="relative">
            <div class="max-w-6xl px-4 mx-auto sm:px-6">
                <div class="pt-32 pb-12 md:pt-40 md:pb-20">
                    <v-row>
                        <v-col cols="12" md="3" sm="4" class="sm:pt-16">
                            <Sidebar :company_uuid="company_details.uuid" :plan="plan_name" :job_posts_count="job_posts_count" />
                        </v-col>
    
                        <v-col cols="12" md="9" sm="8" class="pl-3 md:pl-8">
                            <div class="pt-0 pb-5 sm:pb-10 sm:pt-11">
                                <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">Job Posts</h1>
                            </div>
                            <div class="testJobs">
                                <Link v-if="companies_count > 0 && job_posts_count < plan_name.slot" :href="'/employer/create-job?c_id=' + company_details.uuid" color="text" class="mb-3 text-lg text-white bg-purple-600 btn hover:bg-purple-700">Add New Job Post</Link>
    
                                <br /><br /><br />
                                <h3 class="text-gray-700 h3">Current Job Posts</h3>
                                <br />
    
                                <Message :message="$page.props.flash.message" v-on:hide="hideMessage" :hide="hide" :type="'success'" />
    
                                <div v-if="job_posts.length > 0">
                                    <v-row>
                                        <v-col cols="12" md="12" class="pa-3 d-flex flex-column" v-for="data in job_posts" :key="data.id">
                                            <v-card class="flex elevation-5 d-flex flex-column cardStyle">
                                                <v-card-text class="job-card-wrap">
                                                    <div class="card-text-wrap">
                                                        <v-card-title>{{data.name}}</v-card-title>
                                                        <div class="card-outter">
                                                            <div class="text-subtitle-1" v-if="data.company_name">Company Name: {{data.company_name}}</div>
                                                            <div class="description">Location: {{ data.location_id }}</div>
                                                            <div class="text-lg date">Published: {{ setDateFormat(data.created_on) }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="flex button-outter">
                                                        <Link :href="'/jobs/'+company_details.slug+'/'+data.slug" class="pt-3 pb-3 pl-2 text-lg text-white bg-purple-600 editJobsBtn hover:bg-purple-700 pr-7">View</Link>
                                                        <Link :href="'/employer/edit-job?id=' + data.uuid" class="pt-3 pb-3 pl-8 text-lg text-white bg-purple-600 editJobsBtn hover:bg-purple-700 pr-7">Edit</Link>
                                                        <v-btn class="text-lg text-white bg-purple-600 hover:bg-purple-700" v-on:click="deletejob(data.uuid)">Delete</v-btn>
                                                    </div>
                                                </v-card-text>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </div>
                                <div v-else>
                                    <v-row>
                                        <v-col cols="12" class="mt-5 text-lg text-center text-gray-700">
                                            No Job Found
                                        </v-col>
                                    </v-row>
                                </div>
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
import Sidebar from '../../partials/Sidebar.vue';

export default {
     metaInfo() {
      return {
          title: `Job Posts`,
      }
    },
    components: {
        Head,
        Layout,
        Link,
        'CustomCard': JobPost,
        Message,
        Sidebar 
    },
    props: {
        errors: Object,
        user: Object,
        success: Object,
        job_posts: Array,
        companies_count: Number,
        company_details: Object,
        plan_name: Array && Object,
        job_posts_count: Number,
    },
    data: () => ({
        message: "",
        showCreate: false,
        valid: true,
        hide:0,
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
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this job post!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgba(93, 93, 255, 1)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$swal.fire(
                        'Deleted!',
                        'Job Post Deleted successfully.',
                        'success'
                    );
                    this.$inertia.get("/employer/delete-job/?id=" + id);
                }
            })
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
        hideMessage(){
            this.hide = 1;
        }
    },
    mounted(){
    if(this.companies_count <= 0){
        this.$swal.fire({
        text: "Please complete your company profile before posting a job.",
        icon: 'warning',
        showCancelButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        allowOutsideClick: true
        });
      }
    },
};
</script>
