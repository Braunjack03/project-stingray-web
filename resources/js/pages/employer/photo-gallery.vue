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
                                <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">Upload Company Photos</h1>
                            </div>
                            <div class="max-w-2xl">
    
                                <Message :message="errors.message" :hide="hide" v-on:hide="hideMessage" :type="'error'" />
                                <Message :message="success.message" v-on:hide="hideMessage" :hide="hide" :type="'success'" />
    
                                <Message :message="$page.props.flash.message" v-on:hide="hideMessage" :hide="hide" :type="'success'" />
    
                                <v-form ref="form">
                                    <div class="flex flex-nowrap mb-3">
                                        <div class="w-full px-3">
                                            <label class="block mb-1 text-lg font-medium text-gray-700">Up to 4 photos can be uploaded!</label>
                                            <div class="galleryUpload" @dragover="dragover" @dragleave="dragleave" @drop="drop">
                                                <input type="file" multiple name="fields[assetsFieldHandle][]" id="assetsFieldHandle" class="w-px h-px opacity-0 overflow-hidden absolute" @change="onChange" ref="file" accept=".gif,.jpg,.jpeg,.png"
                                                />
                                                <label for="assetsFieldHandle" class="block cursor-pointer">
                                                    Drag Files Here to upload <br>
                                                    <span class="browseBtn">Browse</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap mb-3 px-3 gallerUploadedImg">
                                        <label class="gallerUploadedTitle">Drag to reorder</label>
                                        <draggable v-model="fileUrls" group="gallery" @start="drag=true" @end="drag=false" :move="checkMove">
                                            
                                            <div class="gallerUploadeBlock" v-for="(file,i) in this.fileUrls" :key="i">
                                                <span class="handle"><v-img :src="'/images/gallery-handle.svg'" width="40px" /></span>
                                                <v-icon color="gray darken-2" class="ml-auto" @click="remove(i)">
                                                    mdi-close-circle
                                                </v-icon>
                                                <v-img class="galleryImg" :src="file.image" max-height="150" max-width="250" />
                                            </div>
                                        </draggable>
                                    </div>
                                   
                                    <div class="flex flex-wrap mt-5">
                                        <div class="w-full px-3">
                                            <v-btn class="w-full text-white bg-purple-600 btn hover:bg-purple-700" @click="submit()">
                                                Update Gallery
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
import draggable from 'vuedraggable'


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
        Sidebar,
        draggable
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
        fileUrls: Array || Object,
    },
    data() {
        return {
            name: this.user.name,
            logo_image_url: [],
            featured_image_url: [],
            multi_image_url: [],
            logo_image_removed: 0,
            hide: 0,
            filelist: [],
            fileUrls: (this.fileUrls.length) ? this.fileUrls : [],
        };
    },
    methods: {
        submit() {
            //this.$v.$touch();
            //if (!this.$v.$invalid) {
                const form = {};

                form.multi_image_url = this.filelist;
                form.multi_image_data = this.fileUrls;
                this.hide = 0;
                this.$inertia.post(`/employer/photo-gallery?id=${this.user.uuid}`, form);
            //}
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
            if (this.filelist.length >= 5) {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Up to 4 photos can be uploaded!',
                });

                return false;
            }else {
                this.fileUrls = [];
                this.filelist.forEach((value, index) => {
                    this.fileUrls.push({'sort': index, 'image': URL.createObjectURL(value)});
                });
            }
        },
        remove(i) {
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this image?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgba(93, 93, 255, 1)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.filelist.splice(i, 1);
                    this.fileUrls.splice(i, 1);
                }

            })
            return false;

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
        },
        checkMove: function(evt) {
            console.log('Here', evt.draggedContext.element.name);
            //return (evt.draggedContext.element.name!=='apple');
        }

    },
};
</script>

<style scoped>
[v-cloak] {
    display: none;
}
</style>