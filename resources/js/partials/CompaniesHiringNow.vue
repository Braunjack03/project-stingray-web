<template>
  <section>
    <div class="max-w-6xl px-4 mx-auto sm:px-6">
      <div class="pt-10 pb-12 md:pt-16 md:pb-20 processOuter">
        <!-- Section header -->
        <div class="max-w-3xl pb-6 mx-auto text-center md:pb-10">
          <h2 class="mb-4 h2 darkColor sectionTitle">
            Get a comprehensive look inside innovative Tampa Bay companies hiring
            now
          </h2>
        </div>

        <!-- Items -->
        <div
          class="grid items-start max-w-sm gap-8 mx-auto md:grid-cols-3 lg:gap-16 md:max-w-none processblock"
        >
          <!-- 1st item -->
          <div class="relative flex flex-col items-center" data-aos="fade-up">
            <div class="mb-5 porcessIocn">
              <img src="images/process01.svg" width="30" />
            </div>
            <h4 class="mb-2 h4 darkColor">Find a Working Lifestyle</h4>
            <p class="text-lg text-center textColor">
                Access job search tools to
help you easily find the
perfect place to work –
whether you're looking for a
co-working office or remote
work opportunities. 
            </p>
          </div>

          <!-- 2nd item -->
          <div
            class="relative flex flex-col items-center"
            data-aos="fade-up"
            data-aos-delay="200"
          >
            <div class="mb-5 porcessIocn">
              <img src="images/process02.svg" width="30" />
            </div>
            <h4 class="mb-2 h4 darkColor">Join an Innovative Network</h4>
            <p class="text-lg text-center textColor">
              Connect with experimental
and creative thought leaders
in the hottest tech niches -
ranging from cyber security
start-ups to crypto and Web
3.0.
            </p>
          </div>

          <!-- 3rd item -->
          <div
            class="relative flex flex-col items-center"
            data-aos="fade-up"
            data-aos-delay="400"
          >
            <div class="mb-5 porcessIocn">
              <img src="images/process03.svg" width="30" />
            </div>
            <h4 class="mb-2 h4 darkColor">Get Workplace Stats</h4>
            <p class="text-lg text-center textColor">
                Gain access to reporting that
offers a thorough description
of workplace culture - so you
can find the perfect
professional setting to thrive.
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