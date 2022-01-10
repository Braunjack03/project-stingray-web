<template>
    <Layout>
        <Head title="Unauthorized" />
        <section class="relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="pt-36 pb-12 md:pt-40 md:pb-20">

                     <!-- Page header -->
                    <div class="max-w-3xl mx-auto text-center pb-12 md:pb-9">
                        <h1 class="h1 text-gray-700">You cannot access this page! This is for only {{role}}</h1>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue'
import Layout from './Layout'

export default {
    components: {
        Link,
        Head,
        Layout,
    },
     props: {
        role: Array,
    },
};
</script>

