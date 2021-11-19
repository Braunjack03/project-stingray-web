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
              <img class="mx-auto md:max-w-none" src="/images/features-02-image.png" width="540" height="520" alt="Features 02" />
            </div>

            <!-- Content -->
            <div class="max-w-xl md:max-w-none md:w-full mx-auto md:col-span-7 lg:col-span-6">
              <div class="md:pl-4 lg:pl-12 xl:pl-16">
                <div class="max-w-3xl mx-auto text-center pb-6 md:pb-10">
                  <h2 class="h2 mb-4 darkColor">How It Works?</h2>
                </div>
                <div class="mt-6" data-aos="fade-left" data-aos-delay="200" data-aos-anchor="[data-aos-id-target]">
                  <h4 class="h4 mb-2"><span class="text-purple-600">.</span> For developers</h4>
                </div>
                <div class="mt-6" data-aos="fade-left" data-aos-delay="400" data-aos-anchor="[data-aos-id-target]">
                  <h4 class="h4 mb-2"><span class="text-teal-500">.</span> For designers</h4>
                </div>
                <div class="mt-6" data-aos="fade-left" data-aos-delay="600" data-aos-anchor="[data-aos-id-target]">
                  <h4 class="h4 mb-2"><span class="text-pink-500">.</span> For teams</h4>
                </div>
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