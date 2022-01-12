<template>
  <section>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 border-t border-gray-200 border-b pt-12 pb-20">
      <h2
        class="h2 mb-4 darkColor text-center pb-8 md:pb-16 sectionTitle"
        data-aos="fade-up"
      >
        Find a Technology or Start-up Job
      </h2>
      <div class="browseList--block">
        <v-row>
          <v-col
            v-for="data in data"
            :key="data.id"
            cols="6"
            sm="4"
            md="3"
            class="browseList--block"
          >
            <div class="browseList darkColor">
              {{ data.name }}
            </div>
          </v-col>
        </v-row>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Newsletter',
  props: ['data'],
};
</script>
