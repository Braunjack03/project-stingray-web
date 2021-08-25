<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

            <h2>Reset Password</h2>   
            <br/>
             <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                <v-form ref="form"  v-model="valid" lazy-validations >

                    <label>Password</label>
                    <v-text-field v-model="form.password" :rules="form.passwordRules" type="password" required></v-text-field>
                    <div v-if="errors.password" class="mt-2 error">{{ errors.password }}</div>

                     <label>Confirm Password</label>
                    <v-text-field v-model="form.password_confirmation" :rules="form.cpasswordRules" type="password" required></v-text-field>
                    <div v-if="errors.password_confirmation" class="mt-2 error">{{ errors.password_confirmation }}</div>

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
    data: () => ({
        message: '',
        valid: true,
        form: {
            password: '',
            confirm_password: '',
            passwordRules : [
                v => !!v || 'Password is required',
            ],
            cpasswordRules : [
                v => !!v || 'Confirm Password is required',
            ],
        },
    }),
    methods: {
      submit() {
            this.$inertia.post('/reset-password/'+this.user.token, this.form );
       },
    },
  }

</script>