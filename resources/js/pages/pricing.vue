<template>
  <Layout class="pricingPage">
    <!-- Page sections -->
    <PricingTables />
    <Faqs />
    <Testimonials />
    <Cta />
  </Layout>
</template>

<script>
import Layout from './Layout.vue';
import PricingTables from '../partials/PricingTables.vue';
import Faqs from '../partials/Faqs.vue';
import Testimonials from '../partials/Testimonials.vue';
import Cta from '../partials/Cta.vue';

export default {
  name: 'Pricing',
  components: {
    PricingTables,
    Faqs,
    Testimonials,
    Cta,
    Layout,
  },
};
</script>
