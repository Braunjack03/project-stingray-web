<template>
    <v-card class="mx-auto my-12" max-width="600">
        <v-card-title>{{data.name}}</v-card-title>

        <v-card-text>
            <v-row align="center" class="mx-0">
            </v-row>

            <div class="my-4 text-subtitle-1">
            Company Name: {{data.company_name}}
            </div>

            <div class="my-4 text-subtitle-1">
            {{data.apply_url}}
            </div>

            <div>{{data.content}}</div>
            <div>{{data.created_at}}</div>
        </v-card-text>

    </v-card>
</template>

<script>
    export default {
        props: ['data']
    }
</script>
