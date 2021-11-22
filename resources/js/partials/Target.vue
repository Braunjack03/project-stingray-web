<template>
  <section>
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
      <div class="py-12 md:py-20">

        <!-- Items -->
        <div class="grid gap-20" data-aos-id-target>

          <!-- Item -->
          <div class="md:grid md:grid-cols-12 md:gap-6 items-center">

            <!-- Image -->
            <div class="max-w-xl md:max-w-none md:w-full mx-auto md:col-span-5 lg:col-span-6 mb-8 md:mb-0 md:rtl" data-aos="fade-right" data-aos-delay="200" data-aos-anchor="[data-aos-id-target]">
              <img class="mx-auto md:max-w-none pl-3" src="/images/how-it-work.jpg" width="100%" height="100%" alt="Features 02" />
            </div>

            <!-- Content -->
            <div class="max-w-xl md:max-w-none md:w-full mx-auto md:col-span-7 lg:col-span-6">
              <div class="md:pl-4 lg:pl-3 xl:pl-5">
                <div class="pb-6 md:pb-10">
                  <h2 class="h2 darkColor sectionTitle">How It Works?</h2>
                </div>
                <ul class="howItWork--list">
                  <li>
                    <span><img src="images/how01.svg" width="30"></span> 
                    <p>Let us know what you're looking for.</p>
                  </li>
                  <li>
                    <span><img src="images/how02.svg" width="30"></span>
                    <p>We'll send them to our proffessionals.</p>
                  </li>
                  <li>
                    <span><img src="images/how03.svg" width="30"></span> 
                    <p>Voila! Here's your job done :)</p>
                  </li>
                </ul>
              </div>
            </div>

          </div>

        </div>

      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Target'
}
</script>