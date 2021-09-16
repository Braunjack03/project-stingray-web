<template>

    <v-card class="mx-auto my-12" max-width="600">
        <v-card-title><Link :href="'jobs/'+data.company_slug+'/'+data.job_slug" color="text" class="mr-4">{{data.name}}</Link></v-card-title>

        <v-card-text>
            <v-row align="center" class="mx-0">
            </v-row>

            <div class="my-4 text-subtitle-1">
            Company Name: <Link :href="'companies/'+data.company_slug">{{data.company_name}}</Link>
            </div>

            <div class="my-4 text-subtitle-1">
            <Link :href="data.apply_url">Apply Now</Link>
            </div>

            <div>{{data.content.substring(0,200) | stripHTML}}</div>
            <div>{{data.created_at}}</div>
        </v-card-text>

    </v-card>

</template>

<script>
  import {Link } from '@inertiajs/inertia-vue'
    export default {
         components: {
        Link
        },
        props: ['data']
    }
</script>
