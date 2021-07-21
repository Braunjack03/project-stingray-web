<template>
    <v-card class="mx-auto my-12" max-width="374">
        <v-img height="250" :src="data.img" />
        <v-card-title>{{data.name}}</v-card-title>

        <v-card-text>
            <v-row align="center" class="mx-0">
                <div class="grey--text ms-4">{{data.ratings.score}} ({{data.ratings.total}})</div>
            </v-row>

            <div class="my-4 text-subtitle-1">
            $ • {{data.type}}
            </div>

            <div>{{data.description}}</div>
        </v-card-text>

        <v-divider class="mx-4"></v-divider>

        <v-card-title>Tonight's availability</v-card-title>

        <v-card-text>
            <v-chip-group active-class="deep-purple accent-4 white--text" column>
                <v-chip>5:30PM</v-chip>
                <v-chip>7:30PM</v-chip>
                <v-chip>8:00PM</v-chip>
                <v-chip>9:00PM</v-chip>
            </v-chip-group>
        </v-card-text>

        <v-card-actions>
            <v-btn color="deep-purple lighten-2" text>Reserve</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        props: ['data']
    }
</script>
