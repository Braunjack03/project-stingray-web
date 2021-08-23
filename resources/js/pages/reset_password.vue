<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

            <h2>Reset Password</h2>   

            <h2>{{ user.token }}</h2>   

            <br/>
             <div v-if="errors.message" class="mt-2 errors">{{ errors.message }}</div>
                <v-form ref="form"  v-model="valid" lazy-validations >

                    <label>Password</label>
                    <v-text-field v-model="form.password" :rules="form.passwordRules" type="password" required></v-text-field>
                    <div v-if="errors.password" class="mt-2 error">{{ errors.password }}</div>

                     <label>Confirm Password</label>
                    <v-text-field v-model="form.cpassword" :rules="form.cpasswordRules" type="password" required></v-text-field>
                    <div v-if="errors.cpassword" class="mt-2 error">{{ errors.cpassword }}</div>

                    <v-text-field v-model="form.token" type="hidden" @input="user.token">{{user.token}}</v-text-field>

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
        user: Object
    },
    data: (user) => ({
        message: '',
        valid: true,
        form: {
            token : '',
            password: '',
            passwordRules: [
                v => !!v || 'Password is required',
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
            this.$inertia.post('/reset-password/', this.form );
       },
    },
  }

</script>