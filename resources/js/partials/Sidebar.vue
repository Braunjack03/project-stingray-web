<template>
    <div>
        <div class="pb-8">
            <h3 class="mb-4 text-gray-700 h3" data-aos="fade-up">Employer <br> Settings</h3>
        </div>
        <ul class="settingLinks">
            <li v-if="plan" class="text-lg text-gray-700 no-underline">
                Subscribed to the {{ plan.name }} Using {{ job_posts_count }}/{{ plan.slot }} job slots (<a class="text-purple-600 upgrade-link" href="/billing">upgrade</a
                      >)
                    </li>
                    <li>
                      <Link
                        href="/employer/profile"
                        class="text-lg no-underline"
                        :class="(currentUrl == '/employer/profile') ? 'text-purple-700' : 'text-gray-700'"
                        >Your Profile</Link
                      >
                    </li>
                    <li v-if="company_uuid">
                      <Link
                        :href="'/employer/edit-company?id=' + company_uuid"
                        class="text-lg teay-700xt-gr no-underline hover:text-purple-600"
                        :class="(currentUrl == '/employer/edit-company') ? 'text-purple-700' : 'text-gray-700'"
                        >Company Profile</Link
                      >
                      <ul class="subSideBar" v-if="(currentUrl == '/employer/edit-company' || (currentUrl == '/employer/photo-gallery'))">
                          <li>
                              <Link
                                :href="'/employer/photo-gallery?id=' + company_uuid"
                                class="text-lg text-gray-700 no-underline  hover:text-purple-600"
                                :class="(currentUrl == '/employer/photo-gallery') ? 'text-purple-700' : 'text-gray-700'"
                                >Photo Gallery</Link>
                          </li>
                        </ul>
                    </li>
                    <li v-else>
                      <Link
                        href="/employer/create-company"
                        class="text-lg text-gray-700 no-underline  hover:text-purple-600"
                        :class="(currentUrl == '/employer/create-company') ? 'text-purple-700' : 'text-gray-700'"
                        >Company Profile</Link
                      >
                    </li>
                    <li v-if="company_uuid">
                      <Link
                        :href="'/employer/jobs?c_id=' + company_uuid"
                        class="text-lg text-gray-700 no-underline  hover:text-purple-600"
                        :class="(currentUrl == '/employer/jobs') ? 'text-purple-700' : 'text-gray-700'"
                        >Job Posts</Link
                      >
                    </li>
                     <li v-else>
                      <Link
                        @click="showJobPopup()"
                        class="text-lg text-gray-700 no-underline  hover:text-purple-600"
                        >Job Posts</Link
                      >
                    </li>
                    <li>
                      <a
                        href="/billing"
                        class="text-lg text-gray-700 no-underline  hover:text-purple-600"
                        >Subscription</a
                      >
                    </li>
                </ul>
      </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue';
import Dropdown from '../utils/Dropdown.vue';

export default {
    name: 'Sidebar',
    props: {
    company_uuid: String,
    job_posts_count: Number,
    plan: Array && Object,
    user: Array && Object,
    },
    components: {
        Dropdown,
        Link,
    },
    data: function () {
      return {
          currentUrl : window.location.pathname,
          currentHref : window.location.toString(),
        };
    },
    computed: {
        isLoggedIn() {
            return this.$page.props.auth.user;
        },
    },
    methods: {
       showJobPopup(){
          this.$swal.fire({
            text: "Please complete your company profile before posting a job.",
            icon: 'warning',
          });
      }
    }
};
</script>
