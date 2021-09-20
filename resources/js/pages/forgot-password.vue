<template>
    <Layout>
        <v-app app>
            <v-container>
                <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

                <h2>Enter Your Email</h2>   
                <br/>
                    <v-form ref="form"  v-model="valid" lazy-validations >
                    <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                    <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                        <label>Email address</label>
                        <v-text-field v-model="form.email" :rules="form.emailRules" required></v-text-field>
                        <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>

                        <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit()" >Send</v-btn>
                    </v-form>
                </v-card>           
            </v-container>
        </v-app>
    </Layout>
</template>   
<script>
import Layout from './Layout'
  export default {
      components: {
      Layout,
    },
    props: {
        errors: Object,
        success: Object,
    },
    data: () => ({
        message: '',
        valid: true,
        form: {
            email: '',
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
        },
    }),
    methods: {
      validate () {
        this.$refs.form.validate();
        return true;
      },
      submit() {
            this.$inertia.post('/forgot-password', this.form );
            this.form.email = '';
            this.$refs.form.resetValidation();
       },
    },
  }

</script>