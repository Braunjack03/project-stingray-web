<template>
    <div v-if="links.length > 3">

        <div class="flex flex-wrap text-gray-500 items-center justify-center -mb-1 custom-pagination">
            <div v-for="(link, p) in links" :key="p">
                <div v-if="link.label === 5" class="mr-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-purple-600 hover:text-white transition focus:border-indigo-500 focus:text-indigo-500" v-html="link.label" />
                <Link v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-purple-600 focus:border-indigo-500 hover:text-white transition focus:text-indigo-500" :class="{ 'bg-purple-600 text-white active': link.active }" :href="(link.url == null) ? 'jobs' : (location_id && location_id != NaN && term != null) ? link.url+'&loc='+location_id+'&q='+term : link.url" v-html="link.label" />
            </div>
        </div>
    </div>  
</template>      
  
<script>
import { Link } from '@inertiajs/inertia-vue'
export default {
    components: {
        Link,
    },
    props: {
        links: Array,
        location_id: Number,
        term:String,
    },
}
</script>