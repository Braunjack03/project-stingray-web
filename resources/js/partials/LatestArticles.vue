<template>
  <section>
    <div class="max-w-6xl px-4 mx-auto sm:px-6">
      <div class="py-8 md:py-12">
        <!-- Items -->
        <div
          class="grid gap-20"
          data-aos-id-target
        >
          <!-- Item -->

          <div
            v-if="articles.length > 0"
            class="companyJobList"
          >
            <div class="max-w-6xl px-4 mx-auto sm:px-6">
              <div class="max-w-3xl mx-auto text-center">
                <h2
                  class="pb-8 mb-4 text-center h2 darkColor md:pb-16 sectionTitle"
                  data-aos="fade-up"
                >
                Stay Ahead of the Curve with News Delivered Fresh to You

                </h2>
              </div>
              <v-row>
                <Article
                  v-for="data in articles"
                  :key="data.id"
                  :data="data"
                />

                <v-col
                  cols="12"
                  class="mt-5 text-center text-gray-700"
                >
                  <Link
                    class="text-center underline"
                    href="/articles"
                  >
                    More Articles
                  </Link>
                </v-col>
              </v-row>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue';
import Article from '../components/Article.vue';

export default {
  name: 'LatestArticles',
  components: {
    Article,
    Link,
  },
  props: {
    articles: {
      type: Array,
      default() {
        return [];
      },
    },
  },
};
</script>
