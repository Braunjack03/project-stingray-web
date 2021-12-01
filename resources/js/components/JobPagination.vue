<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap text-gray-500 items-center justify-center -mb-1 custom-pagination">
            <div v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                    v-html="link.label" />
                <Link v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'bg-blue-700 text-white active': link.active }" :href="link.url" v-html="link.label" />
            </div>
        </div>
    </div>
</template>

<script>
  import {Link } from '@inertiajs/inertia-vue'
    export default {
           components: {
            Link,
        },
        props: {
            links: Array
        },
    }
</script>