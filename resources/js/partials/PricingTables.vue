<template>
  <section class="relative">
    <div class="max-w-6xl px-4 mx-auto sm:px-6">
      <div class="pt-32 pb-12 md:pt-40 md:pb-20">
        <!-- Section header -->
        <div class="max-w-3xl pb-12 mx-auto text-center">
          <h1 class="mb-4 text-gray-700 h1" data-aos="fade-up">
            Attract the Best Candidates
          </h1>
          <p
            class="pt-2 text-xl textColor"
            data-aos="fade-up"
            data-aos-delay="200"
          >
            Get the Made in Tampa plan that fits your needs at a special
            introductory price... and let qualified candidates come to you.
          </p>
        </div>

        <!-- Pricing tables -->
        <div>
          <!-- Pricing toggle -->
          <div
            class="flex justify-center mb-16"
            data-aos="fade-up"
            data-aos-delay="400"
          >
            <div class="inline-flex items-center">
              <div class="mr-3 font-medium textColor">Billed Monthly</div>
              <div class="form-switch focus-within:shadow-outline">
                <input
                  type="checkbox"
                  name="pricing-toggle"
                  id="pricing-toggle"
                  class="sr-only"
                  v-model="value"
                />
                <label class="bg-gray-600" for="pricing-toggle">
                  <span class="bg-gray-200" aria-hidden="true"></span>
                  <span class="sr-only">Enable to see yearly prices</span>
                </label>
              </div>
              <div class="ml-3 font-medium textColor">Billed Annually</div>
            </div>
          </div>

          <div
            class="grid items-start max-w-sm gap-8 mx-auto lg:grid-cols-3 lg:gap-6 lg:max-w-none"
          >
            <!-- Pricing table 1 -->
            <div
              class="relative flex flex-col h-full p-6 bg-gray-800"
              data-aos="fade-up"
              data-aos-delay="700"
            >
              <div class="pb-4 mb-4 border-b border-gray-700">
                <div class="mb-1 text-purple-600 h4">Seed Plan</div>
                <div class="inline-flex items-baseline mb-2">
                  <span
                    class="text-2xl font-medium text-gray-400 md:text-3xl"
                    >{{ priceOutput.plan1[value][0] }}</span
                  >
                  <span class="h2">{{ priceOutput.plan1[value][1] }}</span>
                  <span class="font-medium text-gray-400">{{
                    priceOutput.plan1[value][2]
                  }}</span>
                </div>
                <div class="text-gray-400">Ideal plan for starting small.</div>
              </div>
              <div class="mb-3 font-medium">Features include:</div>
              <ul class="flex-grow -mb-3 text-gray-400">
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>50 Placeholder text commonly</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Consectetur adipiscing elit</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Excepteur sint occaecat cupidatat</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Officia deserunt mollit anim</span>
                </li>
              </ul>
              <div class="p-3 mt-6 border border-gray-700">
                <span v-if="!isLoggedIn">
                  <a
                    class="w-full text-white bg-purple-600 btn-sm hover:bg-purple-700"
                    href="/login"
                    >Join Today</a
                  >
                </span>
                <span v-if="isLoggedIn">
                  <a
                    class="w-full text-white bg-purple-600 btn-sm hover:bg-purple-700"
                    href="/billing"
                    >Subscribe Now</a
                  >
                </span>
              </div>
            </div>

            <!-- Pricing table 2 -->
            <div
              class="relative flex flex-col h-full p-6 bg-gray-800"
              data-aos="fade-up"
              data-aos-delay="600"
            >
              <div class="absolute top-0 right-0 mr-6 -mt-4">
                <div
                  class="inline-flex px-3 py-1 mt-px text-sm font-semibold text-green-600 bg-green-200 rounded-full "
                >
                  Most Popular
                </div>
              </div>
              <div class="pb-4 mb-4 border-b border-gray-700">
                <div class="mb-1 text-purple-600 h4">Start-up Plan</div>
                <div class="inline-flex items-baseline mb-2">
                  <span
                    class="text-2xl font-medium text-gray-400 md:text-3xl"
                    >{{ priceOutput.plan2[value][0] }}</span
                  >
                  <span class="h2">{{ priceOutput.plan2[value][1] }}</span>
                  <span class="font-medium text-gray-400">{{
                    priceOutput.plan2[value][2]
                  }}</span>
                </div>
                <div class="text-gray-400">
                  Accelerated hiring for companies of any size.
                </div>
              </div>
              <div class="mb-3 font-medium">Features:</div>
              <ul class="flex-grow -mb-3 text-gray-400">
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>100 placeholder text commonly</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Consectetur adipiscing elit</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Excepteur sint occaecat cupidatat</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Officia deserunt mollit anim</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Placeholder text commonly used</span>
                </li>
              </ul>
              <div class="p-3 mt-6 border border-gray-700">
                <span v-if="!isLoggedIn">
                  <a
                    class="w-full text-white bg-purple-600 btn-sm hover:bg-purple-700"
                    href="/login"
                    >Join Today</a
                  >
                </span>
                <span v-if="isLoggedIn">
                  <a
                    class="w-full text-white bg-purple-600 btn-sm hover:bg-purple-700"
                    href="/billing"
                    >Subscribe Now</a
                  >
                </span>
              </div>
            </div>

            <!-- Pricing table 3 -->
            <div
              class="relative flex flex-col h-full p-6 bg-gray-800"
              data-aos="fade-up"
              data-aos-delay="800"
            >
              <div class="pb-4 mb-4 border-b border-gray-700">
                <div class="mb-1 text-purple-600 h4">Growth Plan</div>
                <div class="inline-flex items-baseline mb-2">
                  <span
                    class="text-2xl font-medium text-gray-400 md:text-3xl"
                    >{{ priceOutput.plan3[value][0] }}</span
                  >
                  <span class="h2">{{ priceOutput.plan3[value][1] }}</span>
                  <span class="font-medium text-gray-400">{{
                    priceOutput.plan3[value][2]
                  }}</span>
                </div>
                <div class="text-gray-400">
                  Perfect for fast growing companies
                </div>
              </div>
              <div class="mb-3 font-medium">Features:</div>
              <ul class="flex-grow -mb-3 text-gray-400">
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>200 placeholder text commonly</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Consectetur adipiscing elit</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Excepteur sint occaecat cupidatat</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Officia deserunt mollit anim</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Voluptate velit esse cillum</span>
                </li>
                <li class="flex items-center mb-3">
                  <svg
                    class="flex-shrink-0 w-3 h-3 mr-3 text-green-500 fill-current "
                    viewBox="0 0 12 12"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"
                    />
                  </svg>
                  <span>Placeholder text commonly used</span>
                </li>
              </ul>
              <div class="p-3 mt-6 border border-gray-700">
                <span v-if="!isLoggedIn">
                  <a
                    class="w-full text-white bg-purple-600 btn-sm hover:bg-purple-700"
                    href="/login"
                    >Join Today</a
                  >
                </span>
                <span v-if="isLoggedIn">
                  <a
                    class="w-full text-white bg-purple-600 btn-sm hover:bg-purple-700"
                    href="/billing"
                    >Subscribe Now</a
                  >
                </span>
              </div>
            </div>
          </div>

          <!-- Bottom infobox -->
          <div
            class="flex flex-col items-center justify-between mt-12 lg:flex-row lg:mt-6 lg:py-8 lg:border-t lg:border-b lg:border-gray-700"
          >
            <div
              class="mb-4 text-lg font-medium text-center text-gray-700 lg:text-left lg:mb-0"
            >
              Expecting more than 1000 Active End Users?
            </div>
            <div>
              <a
                class="text-white bg-purple-600 btn-sm hover:bg-purple-700"
                href="/contact"
                >Contact us</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "PricingTables",
  computed: {
    isLoggedIn() {
      return this.$page.props.auth.user;
    },
  },
  data: function () {
    return {
      value: false,
      priceOutput: {
        plan1: {
          false: ["$", "19.95", "/mo"],
          true: ["$", "167", "/yr"],
        },
        plan2: {
          false: ["$", "195", "/mo"],
          true: ["$", "1990", "/yr"],
        },
        plan3: {
          false: ["$", "495", "/mo"],
          true: ["$", "4750", "/yr"],
        },
      },
    };
  },
};
</script>