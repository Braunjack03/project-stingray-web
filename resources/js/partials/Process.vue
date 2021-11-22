<template>
  <section>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
      <div class="pt-10 pb-12 md:pt-16 md:pb-20 processOuter">

        <!-- Section header -->
        <div class="max-w-3xl mx-auto text-center pb-6 md:pb-10">
          <h2 class="h2 mb-4 darkColor sectionTitle">Get an exclusive look inside hundreds of companies hiring now</h2>
        </div>

        <!-- Items --> 
        <div class="max-w-sm mx-auto grid gap-8 md:grid-cols-3 lg:gap-16 items-start md:max-w-none processblock">

          <!-- 1st item -->
          <div class="relative flex flex-col items-center" data-aos="fade-up">
            <div class="porcessIocn mb-5"><img src="images/process01.svg" width="30"></div>
            <h4 class="h4 mb-2 darkColor">Find Your Work Fam</h4>
            <p class="md:text-lg textColor text-center">Find a workplace that fits your lifestyle with up-to-date information about what a company has to offer.</p>
          </div>

          <!-- 2nd item -->
          <div class="relative flex flex-col items-center" data-aos="fade-up" data-aos-delay="200">
            <div class="porcessIocn mb-5"><img src="images/process02.svg" width="30"></div>
            <h4 class="h4 mb-2 darkColor">Spotlight on Values</h4>
            <p class="md:text-lg textColor text-center">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
          </div>

          <!-- 3rd item -->
          <div class="relative flex flex-col items-center" data-aos="fade-up" data-aos-delay="400">
            <div class="porcessIocn mb-5"><img src="images/process03.svg" width="30"></div>
            <h4 class="h4 mb-2 darkColor">Benefits & Beyond</h4>
            <p class="md:text-lg textColor text-center">Find a workplace that fits your lifestyle with up-to-date information about what a company has to offer.</p>
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