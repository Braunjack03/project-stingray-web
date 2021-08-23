<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

            <h2>Enter Your Email</h2>   
            <br/>
             <div v-if="errors.message" class="mt-2 errors">{{ errors.message }}</div>
                <v-form ref="form"  v-model="valid" lazy-validations >
                    <label>Email address</label>
                    <v-text-field label="Email" v-model="form.email" required></v-text-field>

                    <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit()" >Send</v-btn>
                </v-form>
            </v-card>           
        </v-container>
    </v-app>
</template>   
<script>
  export default {
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
      reset () {
        this.$refs.form.reset()
      },
      resetValidation () {
        this.$refs.form.resetValidation()
      },
      submit() {
            this.$inertia.post('/forgot-password', this.form );
       },
    },
  }

</script>