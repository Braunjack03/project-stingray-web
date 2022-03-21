<template>
  <header
    class="absolute z-30 w-full"
    :class="(currentUrl == '/') ? 'homePage' : '' "
  >
    <div class="max-w-6xl px-4 mx-auto sm:px-6">
      <div class="flex items-center justify-between h-20">
        <!-- Site branding -->
        <div class="flex-shrink-0 mr-4">
          <!-- Logo -->
          <Link
            class="block"
            href="/"
            aria-label="Cruip"
          >
            <img
              src="/images/made_in_tampa_logo.svg"
              width="200"
            >
          </Link>
        </div>

        <!-- Desktop navigation -->
        <nav class="hidden lg:flex lg:flex-grow">
          <!-- Desktop menu links -->
          <!-- <ul class="flex flex-wrap items-center justify-end flex-grow">
            <li>
              <Link href="#"  class="ml-3 text-white bg-purple-600 btn-sm hover:bg-purple-700">Post a Job</Link>
            </li>
          </ul> -->

          <!-- Desktop sign in links -->
          <ul class="flex flex-wrap items-center justify-end flex-grow">
            <li>
              <Link
                href="/jobs"
                class="flex items-center px-4 py-2 font-bold text-gray-300 transition duration-150 ease-in-out hover:text-purple-600"
              >
                Jobs
              </Link>
            </li>
            <li>
              <Link
                href="/companies"
                class="flex items-center px-4 py-2 font-bold text-gray-300 transition duration-150 ease-in-out hover:text-purple-600"
              >
                Companies
              </Link>
            </li>
            <li>
              <Link
                href="/articles"
                class="flex items-center px-4 py-2 font-bold text-gray-300 transition duration-150 ease-in-out hover:text-purple-600"
              >
                News
              </Link>
            </li>
            <li>
              <Link
                href="#"
                class="mx-4 text-white bg-purple-600 btn-sm hover:bg-purple-700"
              >
                Employers
              </Link>
            </li>
            <li v-if="!isLoggedIn">
              <Link
                href="/register"
                class="flex items-center px-4 py-3 font-bold text-gray-300 transition duration-150 ease-in-out hover:text-purple-600"
              >
                Join
              </Link>
            </li>
            <li v-if="!isLoggedIn">
              <Link
                href="/login"
                class="flex items-center py-3 pl-4 font-bold text-gray-300 transition duration-150 ease-in-out hover:text-purple-600"
              >
                Sign In
              </Link>
            </li>
            <li v-if="isLoggedIn">
              <Dropdown :title="getUserEmail()">
                <li>
                  <Link
                    v-if="isLoggedIn && isLoggedIn.role == 2"
                    href="/profile"
                    class="flex items-center px-4 py-2 text-gray-700 transition duration-150 ease-in-out hover:text-purple-600"
                  >
                    Profile
                  </Link>
                </li>
                <li>
                  <Link
                    v-if="isLoggedIn && isLoggedIn.role == 1"
                    href="/employer/profile"
                    class="flex items-center px-4 py-2 text-gray-700 transition duration-150 ease-in-out hover:text-purple-600"
                  >
                    Profile
                  </Link>
                </li>
                <li class="">
                  <Link
                    href="/logout"
                    class="flex items-center px-4 py-2 text-gray-700 transition duration-150 ease-in-out hover:text-purple-600"
                    @click="logout"
                  >
                    Sign Out
                  </Link>
                </li>
              </Dropdown>
            </li>
          </ul>

          <!-- <ul class="flex flex-wrap items-center justify-end flex-grow text-gray-500 dropMain" v-if="isLoggedIn">
             <Dropdown :title="getUserEmail()" >
              li>
              <Link v-if="isLoggedIn && isLoggedIn.role == 2" href="/dashboard" class="flex items-center px-4 py-2 text-gray-700 transition duration-150 ease-in-out hover:text-purple-600">Dashboard</Link>
              </li>
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/dashboard" class="flex items-center px-4 py-2 text-gray-700 transition duration-150 ease-in-out hover:text-purple-600">Dashboard</Link>
              </li
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 2" href="/profile" class="flex items-center px-4 py-2 text-gray-700 transition duration-150 ease-in-out hover:text-purple-600">Profile</Link>
              </li>
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/profile" class="flex items-center px-4 py-2 text-gray-700 transition duration-150 ease-in-out hover:text-purple-600">Profile</Link>
              </li>
              <li class="">
                <Link v-on:click="logout" href="/logout" class="flex items-center px-4 py-2 text-gray-700 transition duration-150 ease-in-out hover:text-purple-600">Sign Out</Link>
              </li>
            </Dropdown>
          </ul> -->
        </nav>

        <!-- Mobile menu -->
        <div class="lg:hidden">
          <!-- Hamburger button -->
          <button
            ref="hamburger"
            class="hamburger"
            :class="{ active: mobileNavOpen }"
            aria-controls="mobile-nav"
            :aria-expanded="mobileNavOpen"
            @click="mobileNavOpen = !mobileNavOpen"
          >
            <span class="sr-only">Menu</span>
            <svg
              class="w-6 h-6 text-gray-300 transition duration-150 ease-in-out fill-current hover:text-purple-600"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <rect
                y="4"
                width="24"
                height="2"
                rx="1"
              />
              <rect
                y="11"
                width="24"
                height="2"
                rx="1"
              />
              <rect
                y="18"
                width="24"
                height="2"
                rx="1"
              />
            </svg>
          </button>

          <!-- Mobile navigation -->
          <nav
            id="mobile-nav"
            ref="mobileNav"
            class="absolute left-0 z-20 w-full px-4 overflow-hidden transition-all duration-300 ease-in-out top-full sm:px-6"
            :style="[ mobileNavOpen ? { maxHeight: $refs.mobileNav.scrollHeight + 'px', opacity: 1 } : { maxHeight: 0, opacity: .8 } ]"
          >
            <ul class="px-4 py-2 bg-gray-800">
              <li>
                <Link
                  href="/jobs"
                  class="flex py-2 font-medium text-gray-300 hover:text-purple-600"
                >
                  Jobs
                </Link>
              </li>
              <li>
                <Link
                  href="/companies"
                  class="flex py-2 font-medium text-gray-300 hover:text-purple-600"
                >
                  Companies
                </Link>
              </li>
              <li>
                <Link
                  href="/articles"
                  class="flex py-2 font-medium text-gray-300 hover:text-purple-600"
                >
                  News
                </Link>
              </li>

              <!--li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 2" href="/dashboard" class="flex py-2 font-medium text-gray-300 hover:text-purple-600">Dashboard</Link>
              </li>
              <li>
                <Link v-if="isLoggedIn && isLoggedIn.role == 1" href="/employer/dashboard" class="flex py-2 font-medium text-gray-300 hover:text-purple-600">Dashboard</Link>
              </li-->
              <li>
                <Link
                  v-if="isLoggedIn && isLoggedIn.role == 2"
                  href="/profile"
                  class="flex py-2 font-medium text-gray-300 hover:text-purple-600"
                >
                  Profile ({{ getUserEmail() }})
                </Link>
              </li>
              <li>
                <Link
                  v-if="isLoggedIn && isLoggedIn.role == 1"
                  href="/employer/profile"
                  class="flex py-2 font-medium text-gray-300 hover:text-purple-600"
                >
                  Profile ({{ getUserEmail() }})
                </Link>
              </li>
              <li>
                <Link
                  v-if="!isLoggedIn"
                  href="/register"
                  class="flex justify-center w-full py-2 font-medium text-gray-300 hover:text-purple-600"
                >
                  Join
                </Link>
              </li>
              <li>
                <Link
                  v-if="!isLoggedIn"
                  href="/login"
                  class="flex justify-center w-full py-2 font-medium text-gray-300 hover:text-purple-600"
                >
                  Sign In
                </Link>
              </li>
              <li>
                <Link
                  v-if="!isLoggedIn"
                  href="#"
                  class="inline-flex items-center justify-center w-full px-4 py-2 my-2 font-medium text-gray-300 transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-sm hover:bg-purple-700"
                >
                  Employers
                </Link>
              </li>
              <li>
                <Link
                  v-if="isLoggedIn"
                  href="/logout"
                  class="inline-flex items-center justify-center w-full px-4 py-2 my-2 font-medium text-gray-300 transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-sm hover:bg-purple-700"
                  @click="logout"
                >
                  Sign Out
                </Link>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue';
import Dropdown from '../utils/Dropdown.vue';

export default {
  name: 'Header',
  components: {
    Dropdown,
    Link,
  },
  data() {
    return {
      mobileNavOpen: false,
      currentUrl: window.location.pathname,
    };
  },
  computed: {
    isLoggedIn() {
      return this.$page.props.auth.user;
    },
  },
  mounted() {
    document.addEventListener('click', this.clickOutside);
    document.addEventListener('keydown', this.keyPress);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.clickOutside);
    document.removeEventListener('keydown', this.keyPress);
  },
  methods: {
    logout() {
      window.localStorage.removeItem('username');
      window.location.replace('/logout');
    },
    getUserEmail() {
      if (this.$page.props.auth.user) {
        return this.$page.props.auth.user.email;
      }
      return false;
    },
    clickOutside(e) {
      if (
        !this.mobileNavOpen
        || this.$refs.mobileNav.contains(e.target)
        || this.$refs.hamburger.contains(e.target)
      ) return;
      this.mobileNavOpen = false;
    },
    keyPress(event) {
      if (!this.mobileNavOpen || event.keyCode !== 27) return;
      this.mobileNavOpen = false;
    },
  },
};
</script>
