<template>
    <header class="absolute w-full z-30" :class="(currentUrl == '/') ? 'homePage' : '' ">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
      <div class="flex items-center justify-between h-20">
           <!-- Site branding -->
            <div class="flex-shrink-0 mr-4">
                <!-- Logo -->
                <Link class="block" href="/" aria-label="Cruip">
                    <img src="/images/made_in_tampa_logo.png" width="200">
                </Link>
            </div>
      
      
             <!-- Desktop navigation -->
        <nav class="hidden lg:flex lg:flex-grow">

          <!-- Desktop menu links -->
          <!-- <ul class="flex flex-grow justify-end flex-wrap items-center">
            <li>
              <Link href="#"  class="btn-sm text-white bg-purple-600 hover:bg-purple-700 ml-3">Post a Job</Link>
            </li>
          </ul> -->  

          <!-- Desktop sign in links -->
          <ul class="flex flex-grow justify-end flex-wrap items-center" >
            <li>
              <Link href="/jobs"  class="font-bold text-gray-300 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Jobs</Link>
            </li>
            <li>
              <Link href="/companies" class="font-bold text-gray-300 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Companies</Link>
            </li>
            <li> 
              <Link href="/articles" class="font-bold text-gray-300 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">News</Link>
            </li> 
            <li>
              <Link href="#"  class="btn-sm text-gray-300 bg-purple-600 hover:bg-purple-700 mx-4">Employers</Link>
            </li>
            <li v-if="!isLoggedIn">
              <Link href="/register"  class="font-bold text-gray-300 hover:text-purple-600 px-4 py-3 flex items-center transition duration-150 ease-in-out">Join</Link>
            </li>
            <li v-if="!isLoggedIn">
              <Link href="/login" class="font-bold text-gray-300 hover:text-purple-600 pl-4 py-3 flex items-center transition duration-150 ease-in-out">Sign In</Link>
            </li>
            <li v-if="isLoggedIn">
            <Dropdown :title="getUserEmail()" >
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 2" href="/profile" class="text-gray-700 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Profile</Link>
              </li>
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/profile" class="text-gray-700 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Profile</Link>
              </li>
              <li class="">
                <Link v-on:click="logout" href="/logout" class="text-gray-700 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Sign Out</Link>
              </li>
            </Dropdown>
              </li>
          </ul> 

          <!-- <ul class="flex flex-grow justify-end flex-wrap items-center text-gray-500 dropMain" v-if="isLoggedIn">
             <Dropdown :title="getUserEmail()" >
              li>
              <Link v-if="isLoggedIn && isLoggedIn.role == 2" href="/dashboard" class="text-gray-700 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Dashboard</Link>
              </li>
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/dashboard" class="text-gray-700 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Dashboard</Link>
              </li
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 2" href="/profile" class="text-gray-700 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Profile</Link>
              </li>
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/profile" class="text-gray-700 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Profile</Link>
              </li>
              <li class="">
                <Link v-on:click="logout" href="/logout" class="text-gray-700 hover:text-purple-600 px-4 py-2 flex items-center transition duration-150 ease-in-out">Sign Out</Link>
              </li>
            </Dropdown>
          </ul> -->
        </nav>

        <!-- Mobile menu -->
        <div class="lg:hidden">

          <!-- Hamburger button -->
          <button class="hamburger" ref="hamburger" :class="{ active: mobileNavOpen }" aria-controls="mobile-nav" :aria-expanded="mobileNavOpen" @click="mobileNavOpen = !mobileNavOpen">
            <span class="sr-only">Menu</span>
            <svg class="w-6 h-6 fill-current text-gray-300 hover:text-purple-600 transition duration-150 ease-in-out" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <rect y="4" width="24" height="2" rx="1" />
              <rect y="11" width="24" height="2" rx="1" />
              <rect y="18" width="24" height="2" rx="1" />
            </svg>
          </button>

          <!-- Mobile navigation -->
          <nav id="mobile-nav" ref="mobileNav" class="absolute top-full z-20 left-0 w-full px-4 sm:px-6 overflow-hidden transition-all duration-300 ease-in-out" :style="[ mobileNavOpen ? { maxHeight: $refs.mobileNav.scrollHeight + 'px', opacity: 1 } : { maxHeight: 0, opacity: .8 } ]">
            <ul class="bg-gray-800 px-4 py-2">
              <li>
                <Link href="/jobs" class="flex text-gray-300 font-medium hover:text-purple-600 py-2">Jobs</Link>
              </li>
              <li>
                <Link href="/companies" class="flex text-gray-300 font-medium hover:text-purple-600 py-2">Companies</Link>
              </li>
              <li>
                <Link href="/articles" class="flex text-gray-300 font-medium hover:text-purple-600 py-2">News</Link>
              </li>
              
              <!--li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 2" href="/dashboard" class="flex text-gray-300 font-medium hover:text-purple-600 py-2">Dashboard</Link>
              </li>
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/dashboard" class="flex text-gray-300 font-medium hover:text-purple-600 py-2">Dashboard</Link>
              </li-->
              <li>
                <Link  v-if="isLoggedIn && isLoggedIn.role == 2" href="/profile" class="flex text-gray-300 font-medium hover:text-purple-600 py-2">Profile ({{getUserEmail()}})</Link>
              </li>
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/profile" class="flex text-gray-300 font-medium hover:text-purple-600 py-2">Profile ({{getUserEmail()}}) </Link>
              </li>
              <li>
                <Link v-if="!isLoggedIn" href="/register" class="flex text-gray-300 font-medium w-full hover:text-purple-600 py-2 justify-center">Join</Link>
              </li>
              <li>
                <Link v-if="!isLoggedIn" href="/login" class="flex text-gray-300 font-medium w-full  hover:text-purple-600 py-2 justify-center">Sign In</Link>
              </li>
              <li>
                <Link v-if="!isLoggedIn" href="#" class="font-medium w-full inline-flex items-center justify-center border border-transparent px-4 py-2 my-2 rounded-sm text-gray-300 bg-purple-600 hover:bg-purple-700 transition duration-150 ease-in-out">Employers</Link>
              </li>
              <li>
                <Link v-if="isLoggedIn" v-on:click="logout" href="/logout" class="font-medium w-full inline-flex items-center justify-center border border-transparent px-4 py-2 my-2 rounded-sm text-gray-300 bg-purple-600 hover:bg-purple-700 transition duration-150 ease-in-out">Sign Out</Link>
              </li>
            </ul>
          </nav>  
          </div>
    </div>
    </div>
  </header>
</template>

<script>
import Dropdown from "../utils/Dropdown.vue";
import { Link } from '@inertiajs/inertia-vue'
export default {
  name: "Header",
  components: {
    Dropdown,
    Link
  },
  computed: {
      isLoggedIn() {
        return this.$page.props.auth.user;
      },
    },
  data: function () {
    return {
      mobileNavOpen: false,
      currentUrl : window.location.pathname,
    };
  },
  methods: {
     logout() {
        window.localStorage.removeItem("username");
        window.location.replace("/logout")      
      },
      getUserEmail(){
        if(this.$page.props.auth.user){
          return this.$page.props.auth.user.email
        }
        
      },
    clickOutside(e) {
      if (
        !this.mobileNavOpen ||
        this.$refs.mobileNav.contains(e.target) ||
        this.$refs.hamburger.contains(e.target)
      )
        return;
      this.mobileNavOpen = false;
    },
    keyPress() {
      if (!this.mobileNavOpen || event.keyCode !== 27) return;
      this.mobileNavOpen = false;
    },
  },
  mounted() {
    document.addEventListener("click", this.clickOutside);
    document.addEventListener("keydown", this.keyPress);
  },
  beforeUnmount() {
    document.removeEventListener("click", this.clickOutside);
    document.removeEventListener("keydown", this.keyPress);
  },
};
</script>