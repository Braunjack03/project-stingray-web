<template>
  <section>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
      <div class="pt-10 pb-12 md:pt-16 md:pb-20 processOuter">
        <!-- Section header -->
        <div class="max-w-3xl mx-auto text-center pb-6 md:pb-10">
          <h2 class="h2 mb-4 darkColor sectionTitle">
            Get a comprehensive look inside innovative Tampa Bay companies hiring
            now
          </h2>
        </div>

        <!-- Items -->
        <div
          class="
            max-w-sm
            mx-auto
            grid
            gap-8
            md:grid-cols-3
            lg:gap-16
            items-start
            md:max-w-none
            processblock
          "
        >
          <!-- 1st item -->
          <div class="relative flex flex-col items-center" data-aos="fade-up">
            <div class="porcessIocn mb-5">
              <img src="images/process01.svg" width="30" />
            </div>
            <h4 class="h4 mb-2 darkColor">The Right Job for You</h4>
            <p class="text-lg textColor text-center">
              Find a workplace that fits your lifestyle whether you prefer to come into the office or work 100% remote.
            </p>
          </div>

          <!-- 2nd item -->
          <div
            class="relative flex flex-col items-center"
            data-aos="fade-up"
            data-aos-delay="200"
          >
            <div class="porcessIocn mb-5">
              <img src="images/process02.svg" width="30" />
            </div>
            <h4 class="h4 mb-2 darkColor">Cool Kids</h4>
            <p class="text-lg textColor text-center">
              The nations's most experimental and creative tech companies call Tampa Bay home.
              You'll find everything from cyber security start-ups to crypto and
              Web 3.0
            </p>
          </div>

          <!-- 3rd item -->
          <div
            class="relative flex flex-col items-center"
            data-aos="fade-up"
            data-aos-delay="400"
          >
            <div class="porcessIocn mb-5">
              <img src="images/process03.svg" width="30" />
            </div>
            <h4 class="h4 mb-2 darkColor">We Go Deeper</h4>
            <p class="text-lg textColor text-center">
              Our in-depth reporting helps you understand workplace culture before you even talk to a recruiter.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "Process",
};
</script>