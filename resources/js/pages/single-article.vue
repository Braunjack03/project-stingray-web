<template>
  <Layout>
    <Head :title="'Articles'" />
    <section class="relative singleArticles--outer" data-app>
      <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 md:py-20 relative">
        <v-row class="blogPost--block singlePage--articles justify-center mt-8">
           <v-col cols="12" md="9">
              <div class="postBlock">
                 <div class="postBlock--content">
                     <h3 class="postBlock--title text-center lg:text-left"><a href="#">Designing a functional workflow at home.</a></h3>
                     <p class="text-center lg:text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                     <div class="postPersonal--detail justify-between mobileJustify">
                      <div class="flex items-center">
                        <img src="http://192.168.0.55:8000/images/news-author-01.jpg" alt="post-images">
                        <p><a href="#">Anastasia Dan </a> - Jan 17, 2020</p>
                      </div>
                      <div class="mt-4 lg:mt-0">
                        <button class="text-white rounded-full">
                         Product
                       </button>
                       <button class="text-white rounded-full engineeringBtn">
                         Engineering
                       </button>
                      </div>
                     </div>
                 </div>
              </div>
           </v-col>
           <v-col cols="12" md="12">
              <div class="postBlock">
                 <div class="postBlock--img">
                     <img src="http://192.168.0.55:8000/images/blog-post-01.jpg" alt="post-images">
                 </div>
              </div>
           </v-col>
        </v-row>

        <v-row class="blogPost--block mb-0 md:mb-6 singlePage--content justify-center">
           <v-col cols="12" md="9">
              <div class="postBlock--content">
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis enim lobortis scelerisque fermentum. Neque sodales ut etiam sit amet. Ligula ullamcorper malesuada proin libero nunc consequat interdum varius. Quam pellentesque nec nam aliquam sem et tortor consequat. Pellentesque <a href="#">adipiscing</a> commodo elit at imperdiet. Semper auctor neque vitae tempus quam pellentesque nec. Amet dictum sit amet justo donec enim diam. Varius sit amet mattis vulputate enim nulla aliquet porttitor. Odio pellentesque diam volutpat commodo sed. Elit sed vulputate mi sit amet mauris commodo quis imperdiet.</p>
                  <p class="px-3 mx-8 border-l-2"><em>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis enim lobortis scelerisque fermentum. Neque sodales ut etiam sit amet. Ligula ullamcorper malesuada proin</em></p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis enim lobortis scelerisque fermentum. Neque sodales ut etiam sit amet. Ligula ullamcorper malesuada proin</p>
                  <img class="mb-2" src="http://192.168.0.55:8000/images/news-inner-image01.jpg" alt="post-images">
                  <p class="text-center"><small>Photo by Helena Lopes on Unsplash</small></p>

                  <h3 class="h3 text-gray-700 mb-4">Challenges of designing for masses</h3>
                  <p>Aenean sed adipiscing diam donec adipiscing tristique risus nec feugiat. Auctor urna nunc id cursus metus aliquam eleifend. Arcu dictum varius duis at consectetur lorem donec massa sapien. Sed risus ultricies tristique nulla aliquet. Morbi tristique senectus et netus et, nibh nisl condimentum id venenatis a condimentum vitae sapien.</p>

                  <h5 class="h5 text-gray-700 mb-4">Here’s what we discovered:</h5>

                  <ul>
                    <li>Aenean sed adipiscing diam donec adipiscing tristique.</li>
                    <li>Urna nunc id cursus metus aliquam eleifend.</li>
                    <li>Arcu dictum varius duis at consectetur lorem donec massa sapien.</li>
                    <li>Sed risus ultricies tristique nulla aliquet.</li>
                  </ul>

                  <p>Non nisi est sit amet facilisis magna etiam, aliquet porttitor lacus luctus accumsan tortor posuere. Habitasse platea dictumst quisque sagittis purus sit amet volutpat consequat. Id velit ut tortor pretium viverra.</p>
                  <p>Tempor commodo ullamcorper a lacus vestibulum sed arcu non odio tristique senectus et netus et. Nibh nisl condimentum id venenatis:</p>

                  <h4 class="h4 text-gray-700 mb-4">1. The quick brown fox jumped over the lazy dog</h4>

                  <p>Sed risus ultricies tristique nulla aliquet morbi tristique senectus et netus et. Nibh nisl condimentum, id venenatis a condimentum vitae sapien.</p>

                  <h4 class="h4 text-gray-700 mb-4">2. The quick brown fox jumped over the lazy dog.</h4>
                  <p>Non nisi est sit amet facilisis magna etiam, aliquet porttitor lacus luctus accumsan tortor posuere. Habitasse platea dictumst quisque sagittis purus sit amet volutpat consequat. Id velit ut tortor pretium viverra. Tempor commodo ullamcorper a lacus vestibulum sed arcu non odio tristique senectus et netus et. Nibh nisl condimentum id venenatis:</p>
                  <p>Sed risus ultricies tristique nulla aliquet morbi tristique senectus et netus et. Nibh nisl condimentum, id venenatis a condimentum vitae sapien.</p>
                  <h3 class="h3 text-gray-700 mb-4">Conclusions</h3>
                  <p>Non nisi est sit amet facilisis magna etiam, aliquet porttitor lacus luctus accumsan tortor posuere. Habitasse platea dictumst quisque sagittis purus sit amet volutpat consequat. Id velit ut tortor pretium viverra. Tempor commodo ullamcorper a lacus vestibulum sed arcu non odio tristique senectus et netus et. Nibh nisl condimentum id venenatis Sed risus ultricies tristique nulla aliquet morbi tristique senectus et netus et. Nibh nisl condimentum, id venenatis a condimentum vitae sapien.</p>

                  <p class="flex justify-between mobileJustify"><span>Originally published at <a href="">https://cruip.com/.</a></span>
                    <ul class="flex postSocialLink lg:justify-end justify-center mt-4 lg:mt-0">
                      <li>
                        <Link href="#" class="flex justify-center items-center text-purple-600 footerIcon--bg hover:text-gray-100 hover:bg-purple-600 rounded-full transition duration-150 ease-in-out" aria-label="Twitter">
                          <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 11.5c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.7 0-3.2 1.5-3.2 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4 0 1.6 1.1 2.9 2.6 3.2-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H8c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4c.7-.5 1.3-1.1 1.7-1.8z" />
                          </svg>
                        </Link>
                      </li>
                      <li class="ml-4">
                        <Link href="#" class="flex justify-center items-center text-purple-600 footerIcon--bg hover:text-gray-100 hover:bg-purple-600 rounded-full transition duration-150 ease-in-out" aria-label="Facebook">
                          <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.023 24L14 17h-3v-3h3v-2c0-2.7 1.672-4 4.08-4 1.153 0 2.144.086 2.433.124v2.821h-1.67c-1.31 0-1.563.623-1.563 1.536V14H21l-1 3h-2.72v7h-3.257z" />
                          </svg>
                        </Link>
                      </li>
                      <li class="ml-4">
                        <Link href="#" class="flex justify-center items-center text-purple-600 footerIcon--bg hover:text-gray-100 hover:bg-purple-600 rounded-full transition duration-150 ease-in-out" aria-label="Linkedin">
                          <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.3 8H8.7c-.4 0-.7.3-.7.7v14.7c0 .3.3.6.7.6h14.7c.4 0 .7-.3.7-.7V8.7c-.1-.4-.4-.7-.8-.7zM12.7 21.6h-2.3V14h2.4v7.6h-.1zM11.6 13c-.8 0-1.4-.7-1.4-1.4 0-.8.6-1.4 1.4-1.4.8 0 1.4.6 1.4 1.4-.1.7-.7 1.4-1.4 1.4zm10 8.6h-2.4v-3.7c0-.9 0-2-1.2-2s-1.4 1-1.4 2v3.8h-2.4V14h2.3v1c.3-.6 1.1-1.2 2.2-1.2 2.4 0 2.8 1.6 2.8 3.6v4.2h.1z" />
                          </svg>
                        </Link>
                      </li>
                    </ul>
                  </p>
              </div>
           </v-col>
        </v-row>

        <v-row class="blogPost--block">
         <v-col cols="12">
            <h2 class="articlesTitle">More from Open PRO</h2>
         </v-col>
         <v-col cols="12" md="4" sm="6">
            <div class="postBlock">
               <div class="postBlock--img">
                   <img src="http://192.168.0.55:8000/images/news-01.jpg" alt="post-images">
               </div>
               <div class="postBlock--content">
                   <button class="text-white rounded-full">
                     Product
                   </button>
                   <button class="text-white rounded-full engineeringBtn">
                     Engineering
                   </button>
                   <h3 class="postBlock--title"><a href="#">The quick brown fox jumped over the lazy dog.</a></h3>
                   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                   <div class="postPersonal--detail">
                      <img src="http://192.168.0.55:8000/images/news-author-01.jpg" alt="post-images">
                      <p><a href="#">Anastasia Dan </a> - Jan 17, 2020</p>
                   </div>
               </div>
              </div>
          </v-col>
          <v-col cols="12" md="4" sm="6">
            <div class="postBlock">
               <div class="postBlock--img">
                   <img src="http://192.168.0.55:8000/images/news-01.jpg" alt="post-images">
               </div>
               <div class="postBlock--content">
                   <button class="text-white rounded-full">
                     Product
                   </button>
                   <button class="text-white rounded-full desingBtn">
                     Desing
                   </button>
                   <h3 class="postBlock--title"><a href="#">The quick brown fox jumped over the lazy dog.</a></h3>
                   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                   <div class="postPersonal--detail">
                      <img src="http://192.168.0.55:8000/images/news-author-01.jpg" alt="post-images">
                      <p><a href="#">Anastasia Dan </a> - Jan 17, 2020</p>
                   </div>
               </div>
              </div>
          </v-col>
          <v-col cols="12" md="4" sm="6">
            <div class="postBlock">
               <div class="postBlock--img">
                   <img src="http://192.168.0.55:8000/images/news-01.jpg" alt="post-images">
               </div>
               <div class="postBlock--content">
                   <button class="text-white rounded-full">
                     Product
                   </button>
                   <button class="text-white rounded-full tutorialsBtn">
                     Tutorials and articles
                   </button>
                   <h3 class="postBlock--title"><a href="#">The quick brown fox jumped over the lazy dog.</a></h3>
                   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                   <div class="postPersonal--detail">
                      <img src="http://192.168.0.55:8000/images/news-author-01.jpg" alt="post-images">
                      <p><a href="#">Anastasia Dan </a> - Jan 17, 2020</p>
                   </div>
               </div>
              </div>
          </v-col>
        </v-row>
      </div>

    </section>
  </Layout>
</template>
<script>
import { Link, Head } from "@inertiajs/inertia-vue";
import CompanyJobPost from '../components/CompanyJobPost.vue';
import Pagination from '../components/CompanyPagination.vue';
import Layout from "./Layout";
export default {
  components: {
    Link,
    Layout,
     'CustomCard': CompanyJobPost,
    Pagination,
    Head,
  },
  props: {
    errors: Object,
    success: Object,
    data: Object,
    job_posts: Object,
    selected : String,
    job_posts_count:Number,
  },
   mounted() {
      this.tab = this.selected
  },  
  data: () => ({
    message: "",
     tab: null,
     page:1,
  }),
  methods: {
    claimProfile(id) {
      this.$inertia.get("/claim-profile/" + id);
    },
    handleButton(page) {

      console.log('here',page);
            //if(!this.moreMsgFetched){
                var newdata = this.$inertia.get(this.data.slug+'?page=2')
                console.log('testing', newdata);
                /*.then((response) => {
                    this.moreMessages = response.data;
                    this.messages = this.moreMessages.splice(0, 10);
                    this.moreMsgFetched = true;
                });*/
                this.page += 1;
            //}
             //if you want to replace the messages array every time with 10 more messages
            //this.messages = nextMsgs
            //if you wnt to add 10 more messages to messages array
            //this.messages.push(nextMsgs);
        }

  },
};
</script>
