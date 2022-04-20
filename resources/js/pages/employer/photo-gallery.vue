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
                                            <div class="galleryUpload" @dragover="dragover1" @dragleave="dragleave1" @drop="drop1">
                                                <input type="file" multiple name="fields[assetsFieldHandle][]" id="assetsFieldHandle" class="w-px h-px opacity-0 overflow-hidden absolute" @change="onGalleryImageChange" ref="file" accept=".gif,.jpg,.jpeg,.png"
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
                                        <draggable :list="fileUrls" group="gallery" @start="drag=true" @end="drag=false" :move="checkMove">
                                            
                                            <div class="gallerUploadeBlock" v-for="(file,i) in this.fileUrls" :key="i">
                                                <span class="handle"><v-img :src="'/images/gallery-handle.svg'" width="40px" /></span>
                                                <v-icon color="gray darken-2" class="ml-auto" @click="removeGalleryImage(i,file.id)">
                                                    mdi-close-circle
                                                </v-icon>
                                                <v-img class="galleryImg" :src="file.image" max-height="150" max-width="250" />
                                            </div>
                                        </draggable>
                                    </div>
                                    <!--div class="flex flex-wrap mt-5">
                                        <div class="w-full px-3">
                                            <v-btn class="w-full text-white bg-purple-600 btn hover:bg-purple-700" @click="submit()">
                                                Update Gallery
                                            </v-btn>
                                        </div>
                                    </div-->
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
        fields: { required },
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
        fileUrls : {
            type :Array,
            default:[]
        }
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
            newlist : [],
            fileUrlsList: (this.fileUrls.length) ? this.fileUrls : [],
        };
    },
    methods: {
        submit() {
            //this.$v.$touch();
            //if (!this.$v.$invalid) {
                const form = {};
                
                form.multi_image_url = this.newlist;
                form.multi_image_data = this.fileUrls;
                this.hide = 0;
                this.$inertia.post(`/employer/photo-gallery?id=${this.user.uuid}`, form);
                this.newlist = [];
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
        onGalleryImageChange(e) {
            this.filelist = [];
            console.log('here new',this.$refs.file.files);
            //this.filelist = [...this.$refs.file.files];
            //this.newlist.push(...this.$refs.file.files)
            this.filelist = e.target.files || e.dataTransfer.files;

            console.log('filelist',this.filelist);
            console.log('fileUrls',this.fileUrls.length);
            let max_images = this.fileUrls.length + this.filelist.length;
            //console.log('max',max_images);
            if (this.fileUrls.length >= 4 || max_images >= 5) {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Up to 4 photos can be uploaded!',
                });

                return false;
            }

            //console.log('else',this.test.length);
            this.fileUrls = [];
           /* if(this.filelist.length > 0)
            {
                this.newlist.forEach((value, index) => {
                    this.fileUrls.push({'id':index,'sort': this.fileUrls.length, 'image': URL.createObjectURL(value)});
                });
            }else{*/
                //const uniqueObjects = [...new Map(this.filelist.map(item => [item.id, item])).values()]
            this.filelist.forEach((value, index) => {
                this.fileUrls.push({'id':index,'sort': this.fileUrls.length, 'image': URL.createObjectURL(value)});
            });
           // }
            console.log('final',this.fileUrls);
            const form = {};
            form.multi_image_url = this.filelist;
            form.multi_image_data = this.fileUrls;
            this.hide = 0;
            this.$inertia.post(`/employer/photo-gallery?id=${this.user.uuid}`, form);

        },
        removeGalleryImage(i,id) {
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
                    this.$inertia.get(`/employer/delete-gallery-photo/?id=${this.user.uuid}&p_id=` + id);
                }

            })
            return false;

        },
        dragover1(event) {
            event.preventDefault();
            // Add some visual fluff to show the user can drop its files
            if (!event.currentTarget.classList.contains('bg-green-300')) {
                event.currentTarget.classList.remove('bg-gray-100');
                event.currentTarget.classList.add('bg-green-300');
            }
        },
        dragleave1(event) {
            // Clean up
            event.currentTarget.classList.add('bg-gray-100');
            event.currentTarget.classList.remove('bg-green-300');
        },
        drop1(event) {
            event.preventDefault();
            this.$refs.file.files = event.dataTransfer.files;
           this.onGalleryImageChange(event);
            // Clean up
            event.currentTarget.classList.add('bg-gray-100');
            event.currentTarget.classList.remove('bg-green-300');
        },
        checkMove: function(evt){
            console.log(evt.draggedContext);
            console.log('final drag',this.fileUrls);
            const form = {};
            form.multi_image_sort = this.fileUrls;
              setTimeout(() => 
                 this.$inertia.post(`/employer/photo-gallery-order?id=${this.user.uuid}`, form) , 1500);
           
            //return (evt.draggedContext.element.name!=='apple');
        },
       

    },
};
</script>

<style scoped>
[v-cloak] {
    display: none;
}
</style>