<template>
    <Layout>
        <Head title="Create Job" />
        <section class="relative" data-app>
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="pt-32 pb-12 md:pt-40 md:pb-20">
    
                    <div class="max-w-3xl text-gray-700 mx-auto text-center pb-12 md:pb-16">
                        <h1 class="h1 mb-4 " data-aos="fade-up">Post a new Job</h1>
                        <p>Job Information</p>
                    </div>
    
                    <div class="max-w-xl mx-auto">
                        <div v-if="errors.message" class="text-red-500 text-sm font-bold text-center text-sm my-3">
                            {{ errors.message }}
                        </div>
                        <div v-if="success" class="text-green-500 text-sm font-bold text-center text-sm my-3">
                            {{ success.message }}
                        </div>
                        <v-form ref="form">
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Job Title <span class="text-red-600">*</span></label>
                                    <v-text-field v-model="name" class="form-input input-field-outer w-full text-gray-700" placeholder="Job Title" :class="{ 'error--text': $v.name.$error }" @input="$v.name.$touch()" @blur="$v.name.$touch()" required></v-text-field>
                                    <div v-if="$v.name.$error && !$v.name.required" class="text-red-500 text-sm">Job Title is required</div>
    
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Location</label>
    
                                    <v-row>
                                        <v-col class="d-flex" cols="12">
                                            <v-select v-model='location_id' item-text="name" item-value="id" :items="locations" label="Location" class="form-input input-field-outer w-full text-gray-700" dense solo></v-select>
                                        </v-col>
                                        <div v-if="errors.location_id" class="mt-2 error">{{ errors.location_id }}</div>
                                    </v-row>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Job Category <span class="text-red-600">*</span></label>
                                    <v-row>
                                        <v-col class="d-flex" cols="12">
                                            <v-select v-model='job_cat_id' item-text="name" item-value="id" :items="job_categories" label="Job Category" :class="{ 'error--text': $v.job_cat_id.$error }" class="form-input input-field-outer w-full text-gray-700" dense solo></v-select>
                                            <div v-if="$v.job_cat_id.$error && !$v.job_cat_id.required" class="text-red-500 text-sm">Job Category is required</div>
    
                                        </v-col>
    
                                    </v-row>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1"> Job Application URL <span class="text-red-600">*</span></label>
                                    <v-text-field v-model="apply_url" :class="{ 'error--text': $v.apply_url.$error }" class="form-input input-field-outer w-full text-gray-700" placeholder="https://example.com" required></v-text-field>
                                    <div v-if="$v.apply_url.$error && !$v.apply_url.required" class="text-red-500 text-sm">Job Application URL is required</div>
                                </div>
                            </div>
    
                            <div class="flex flex-wrap -mx-3 mb-4">
                                <div class="w-full px-3">
                                    <label class="block text-gray-700 text-sm font-medium mb-1">Job Description </label>
                                    <tiptap-vuetify v-model="content" :extensions="extensions" class="form-input input-field-outer w-full text-gray-700" />
    
                                </div>
                            </div>
    
    
                            <div class="flex flex-wrap -mx-3 mt-6">
                                <div class="w-full px-3">
                                    <v-btn @click="submit()" class="btn text-white bg-purple-600 hover:bg-purple-700 w-full">Save Changes</v-btn>
    
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
import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'

export default {
    mixins: [validationMixin],
    validations: {
        name: { required },
        job_cat_id: { required },
        apply_url: { required },
    },
    components: {
        Head,
        Layout,
        TiptapVuetify
    },
    props: {
        errors: Object,
        user: Object,
        success: Object,
        job_categories: Array,
        locations: Array,
        company_uuid: String,
    },
    data() {
        return {
            name: this.user.name,
            apply_url: this.user.apply_url,
            job_cat_id: this.user.job_cat_id,
            location_id: this.user.location_id,
            company_uuid: this.user.company_uuid,
            content: this.user.content,
            extensions: [
                History,
                Blockquote,
                Link,
                Underline,
                Strike,
                Italic,
                ListItem,
                BulletList,
                OrderedList, [Heading, {
                    options: {
                        levels: [1, 2, 3]
                    }
                }],
                Bold,
                Code,
                HorizontalRule,
                Paragraph,
                HardBreak
            ],
        }
    },
    methods: {
        submit() {
            this.$v.$touch()
            if (!this.$v.$invalid) {
                let form = {
                    name: this.name,
                    apply_url: this.apply_url,
                    job_cat_id: this.job_cat_id,
                    location_id: this.location_id,
                    content: this.content,
                };
                console.log('form', form);
                this.$inertia.post('/employer/create-job?c_id=' + this.company_uuid, form);
            }
        },
    },
}
</script>
