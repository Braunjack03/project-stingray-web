<template>
  <footer class="footerBg">
    <div class="py-10 md:py-14">
      <div class="max-w-6xl px-4 mx-auto sm:px-6">
        <!-- Top area: Blocks -->
        <div class="grid gap-8 mb-8 md:grid-cols-12 lg:gap-20 md:mb-12">
          <!-- 1st block -->
          <div class="md:col-span-4 lg:col-span-5">
            <div class="mb-2">
              <!-- Logo -->
              <Link
                href="/"
                class="inline-block"
                aria-label="Cruip"
              >
                <img
                  src="/images/made_in_tampa_logo.svg"
                  width="200"
                >
              </Link>
            </div>
            <div class="text-gray-400">Connecting top talent to innovative tech
companies and startups across Tampa Bay.
Find jobs, news, company profiles, and
more. 
            </div>
          </div>

          <!-- 2nd, 3rd and 4th blocks -->
          <div class="grid gap-8 md:col-span-8 lg:col-span-7 sm:grid-cols-3">
            <!-- 2nd block -->
            <div class="text-sm">
              <h6 class="mb-1 font-medium text-white">
                About
              </h6>
              <ul>
                <li class="mb-1">
                  <Link
                    href="/about_us"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    About Us
                  </Link>
                </li>
                <li class="mb-1">
                  <Link
                    href="/contact"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    Contact Us
                  </Link>
                </li>
                <li class="mb-1">
                  <Link
                    href="/privacy"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    Privacy Policy
                  </Link>
                </li>
                <li class="mb-1">
                  <Link
                    href="/terms"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    Terms of use
                  </Link>
                </li>
              </ul>
            </div>

            <!-- 3rd block -->
            <div class="text-sm">
              <h6 class="mb-1 font-medium text-white">
                Resources
              </h6>
              <ul>
                <li class="mb-1">
                  <Link
                    href="/contact"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    Provide Feedback
                  </Link>
                </li>
                <li class="mb-1">
                  <Link
                    href="/contact"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    Report a Concern
                  </Link>
                </li>
                <li class="mb-1">
                  <Link
                    href="/articles"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    Browse Articles
                  </Link>
                </li>
                <li class="mb-1">
                  <Link
                    href="/jobs"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    Browse Jobs
                  </Link>
                </li>
              </ul>
            </div>

            <!-- 4th block -->
            <div class="text-sm">
              <h6 class="mb-1 font-medium text-white">
                Get Involved
              </h6>
              <ul>
                <li class="mb-1">
                  <Link
                    href="/pricing"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    Pricing
                  </Link>
                </li>
                <li class="mb-1">
                  <Link
                    href="/for_employers"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    For Employers
                  </Link>
                </li>
                <li class="mb-1">
                  <Link
                    href="/contact"
                    class="text-gray-400 transition duration-150 ease-in-out hover:text-gray-100"
                  >
                    Partnerships
                  </Link>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Bottom area -->
        <div class="md:flex md:items-center md:justify-between">
          <!-- Social links -->
          <ul class="flex mb-4 md:order-1 md:ml-4 md:mb-0 md:justify-end">
              <!---
            <li>
              <Link
                href="#"
                class="flex items-center justify-center text-purple-600 transition duration-150 ease-in-out rounded-full footerIcon--bg hover:text-gray-100 hover:bg-purple-600"
                aria-label="Twitter"
              >
                <svg
                  class="w-8 h-8 fill-current"
                  viewBox="0 0 32 32"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path d="M24 11.5c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.7 0-3.2 1.5-3.2 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4 0 1.6 1.1 2.9 2.6 3.2-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H8c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4c.7-.5 1.3-1.1 1.7-1.8z" />
                </svg>
              </Link>
            </li>
            <li class="ml-4">
              <Link
                href="#"
                class="flex items-center justify-center text-purple-600 transition duration-150 ease-in-out rounded-full footerIcon--bg hover:text-gray-100 hover:bg-purple-600"
                aria-label="Github"
              >
                <svg
                  class="w-8 h-8 fill-current"
                  viewBox="0 0 32 32"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path d="M16 8.2c-4.4 0-8 3.6-8 8 0 3.5 2.3 6.5 5.5 7.6.4.1.5-.2.5-.4V22c-2.2.5-2.7-1-2.7-1-.4-.9-.9-1.2-.9-1.2-.7-.5.1-.5.1-.5.8.1 1.2.8 1.2.8.7 1.3 1.9.9 2.3.7.1-.5.3-.9.5-1.1-1.8-.2-3.6-.9-3.6-4 0-.9.3-1.6.8-2.1-.1-.2-.4-1 .1-2.1 0 0 .7-.2 2.2.8.6-.2 1.3-.3 2-.3s1.4.1 2 .3c1.5-1 2.2-.8 2.2-.8.4 1.1.2 1.9.1 2.1.5.6.8 1.3.8 2.1 0 3.1-1.9 3.7-3.7 3.9.3.4.6.9.6 1.6v2.2c0 .2.1.5.6.4 3.2-1.1 5.5-4.1 5.5-7.6-.1-4.4-3.7-8-8.1-8z" />
                </svg>
              </Link>
            </li>
        --->
            <li class="ml-4">
              <a
                href="https://linkedin.com/company/made-in-tampa"
                class="flex items-center justify-center text-purple-600 transition duration-150 ease-in-out rounded-full footerIcon--bg hover:text-gray-100 hover:bg-purple-600"
                aria-label="Linkedin"
              >
                <svg
                  class="w-8 h-8 fill-current"
                  viewBox="0 0 32 32"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path d="M23.3 8H8.7c-.4 0-.7.3-.7.7v14.7c0 .3.3.6.7.6h14.7c.4 0 .7-.3.7-.7V8.7c-.1-.4-.4-.7-.8-.7zM12.7 21.6h-2.3V14h2.4v7.6h-.1zM11.6 13c-.8 0-1.4-.7-1.4-1.4 0-.8.6-1.4 1.4-1.4.8 0 1.4.6 1.4 1.4-.1.7-.7 1.4-1.4 1.4zm10 8.6h-2.4v-3.7c0-.9 0-2-1.2-2s-1.4 1-1.4 2v3.8h-2.4V14h2.3v1c.3-.6 1.1-1.2 2.2-1.2 2.4 0 2.8 1.6 2.8 3.6v4.2h.1z" />
                </svg>
              </a>
            </li>
          </ul>

          <!-- Copyrights note -->
          <div class="mr-4 text-sm text-gray-400">
            &copy; {{ new Date().getFullYear() }} Water Street Technologies. All rights reserved.
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue';

export default {
  name: 'Footer',
  components: {
    Link,
  },
};
</script>
