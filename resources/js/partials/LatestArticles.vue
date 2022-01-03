<template>
    <section>
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="py-8 md:py-12">
    
                <!-- Items -->
                <div class="grid gap-20" data-aos-id-target>
    
                    <!-- Item -->
    
                    <div class="companyJobList" v-if="articles.length > 0">
                        <div class="max-w-6xl mx-auto px-4 sm:px-6">
    
                            <div class="max-w-3xl mx-auto text-center">
                                <h2 class="h2 mb-4 darkColor text-center pb-8 md:pb-16 sectionTitle" data-aos="fade-up">Refreshing news for developers and designers</h2>
                            </div>
                            <v-row>
                                <Article v-for="data in articles" :key="data.id" :data="data" />
    
                                <v-col cols="12" class="mt-5 text-center text-gray-700">
    
                                    <Link class="text-center underline" href="/articles">More Articles</Link>
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
import Article from '../components/Article.vue';
import { Head, Link } from "@inertiajs/inertia-vue";
export default {
    name: 'Target',
    components: {
        Article,
        Link,
    },
    props: {
        articles: Array,
    },
}
</script>
