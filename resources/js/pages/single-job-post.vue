<template>
<Layout>
    <Head :title="'Job List | '+ data.company_name" />
    <section class="relative singlePost--outer" data-app>
        <div class="max-w-6xl px-4 mx-auto sm:px-6">
            <div class="pb-12 pt-36 md:pt-32 md:pb-20 aboutContent">
                <v-row>
                  <v-col cols="12" sm="12" lg="8">
                    <div class="mb-5 singlePost--title">
                        <h3 class="company-title"><Link :href="`/companies/${data.company_slug}`" class="flex items-center"><span class="companyTitle--logo"><img src="/images/building_icon.svg"></span> {{data.company_name}}</Link></h3> 
                        <h2 class="post-title">{{data.name}}</h2>
                        <v-row>
                          <v-col cols="12" md="5" lg="4">
                            <span class="flex flex-wrap items-center post-date">
                              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="#5d5dff">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                              </svg> Date Posted: {{setDateFormat(data.created_at)}}
                            </span>
                          </v-col>
                          <v-col cols="12" md="7" lg="8">
                            <span class="flex flex-wrap items-center location"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="#5d5dff">
                              <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                              </svg>  Location : {{data.location}}
                            </span>
                          </v-col>
                        </v-row>                
                      </div>
                      <div v-html="data.content" class="text-gray-700 post-detail-wrap add-html-props"></div>
                    </v-col>
                    <v-col cols="12" sm="12" lg="4" v-if="is_authenticated == true">
                      <div class="text-center text-subtitle-1 xl:text-right applyBtn" :class="(scrollPosition > 100) ? 'btnSticky' : ''">
                        <v-btn  :href="data.apply_url" target="_blank" class="bg-purple-600 rounded-none newBtn hover:bg-purple-700 " >
                          Apply on Company Site 
                        </v-btn>
                      </div>
                  </v-col>
                  <v-col cols="12" sm="12" lg="4" v-else>
                      <div class="text-center text-subtitle-1 xl:text-right applyBtn" :class="(scrollPosition > 100) ? 'btnSticky' : ''">
                        <v-btn  href="/login" class="bg-purple-600 rounded-none newBtn hover:bg-purple-700 " >
                          Please Login
                        </v-btn>
                      </div>
                  </v-col>
                </v-row>  
            </div>
        </div>
    </section>
</Layout>
</template>
<script>
import {Link,Head } from '@inertiajs/inertia-vue'
  import Layout from './Layout'
  export default {

    metaInfo() {
      const data = this.data;
      return {
          title: `Job List | ${data.company_name}`
      }
    },
    components: {
        Link,
        Layout,
        Head,
    },
    props: {
      errors : Object,  
      success: Object,
      data : Object,
      is_authenticated : Boolean,
    },
    
     data: () => ({
        message: '',
        scrollPosition: null

    }),
    methods : {
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
            var date = month + "/" + day + "/" + year;

            return date;
         },
        updateScroll() {
          this.scrollPosition = window.scrollY
        }
    },
     mounted() {
      window.addEventListener('scroll', this.updateScroll);
    }
  }

</script>
