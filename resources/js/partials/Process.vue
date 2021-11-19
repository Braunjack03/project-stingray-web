<template>
  <section>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
      <div class="pt-10 pb-12 md:pt-16 md:pb-20 processOuter">

        <!-- Section header -->
        <div class="max-w-3xl mx-auto text-center pb-6 md:pb-10">
          <h2 class="h2 mb-4 darkColor">Get an exclusive look inside hundreds of companies hiring now</h2>
        </div>

        <!-- Items --> 
        <div class="max-w-sm mx-auto grid gap-8 md:grid-cols-3 lg:gap-16 items-start md:max-w-none">

          <!-- 1st item -->
          <div class="relative flex flex-col items-center" data-aos="fade-up">
            <svg class="w-16 h-16 mb-5" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
              <rect class="fill-current text-purple-600" width="64" height="64" rx="32" />
              <path class="stroke-current text-purple-300" stroke-width="2" stroke-linecap="square" d="M21 23h22v18H21z" fill="none" fill-rule="evenodd" />
              <path class="stroke-current text-purple-100" d="M26 28h12M26 32h12M26 36h5" stroke-width="2" stroke-linecap="square" />
            </svg>
            <h4 class="h4 mb-2 darkColor">Find Your Work Fam</h4>
            <p class="text-lg textColor text-center">Find a workplace that fits your lifestyle with up-to-date information about what a company has to offer.</p>
          </div>

          <!-- 2nd item -->
          <div class="relative flex flex-col items-center" data-aos="fade-up" data-aos-delay="200">
            <svg class="w-16 h-16 mb-5" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
              <rect class="fill-current text-purple-600" width="64" height="64" rx="32" />
              <g fill="none" fill-rule="evenodd">
                <path class="stroke-current text-purple-300" d="M40 22a2 2 0 012 2v16a2 2 0 01-2 2H24a2 2 0 01-2-2V24a2 2 0 012-2" stroke-width="2" stroke-linecap="square" />
                <path class="stroke-current text-purple-100" stroke-width="2" stroke-linecap="square" d="M36 32l-4-3-4 3V22h8z" />
              </g>
            </svg>
            <h4 class="h4 mb-2 darkColor">Spotlight on Values</h4>
            <p class="text-lg textColor text-center">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
          </div>

          <!-- 3rd item -->
          <div class="relative flex flex-col items-center" data-aos="fade-up" data-aos-delay="400">
            <svg class="w-16 h-16 mb-5" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
              <rect class="fill-current text-purple-600" width="64" height="64" rx="32" />
              <path class="stroke-current text-purple-300" stroke-width="2" stroke-linecap="square" d="M21 35l4 4 12-15" fill="none" fill-rule="evenodd" />
              <path class="stroke-current text-purple-100" d="M42 29h-3M42 34h-7M42 39H31" stroke-width="2" stroke-linecap="square" />
            </svg>
            <h4 class="h4 mb-2 darkColor">Benefits & Beyond</h4>
            <p class="text-lg textColor text-center">Find a workplace that fits your lifestyle with up-to-date information about what a company has to offer.</p>
          </div>

        </div>

      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Process'
}
</script>