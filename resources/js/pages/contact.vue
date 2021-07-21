<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">
                <v-form ref="form">
                    <v-text-field label="Email" required></v-text-field>
                    <v-textarea label="Message" required></v-textarea>
                    <v-btn color="success">Submit</v-btn>
                </v-form>
            </v-card>          
        </v-container>
    </v-app>
</template>   