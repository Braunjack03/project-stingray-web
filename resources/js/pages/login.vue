<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

            <h2>Login</h2>   
            <br/>
                <v-form ref="form" >
                    <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                    <div v-if="success" class="mt-2 success">{{ success.message }}</div>
                    <label>Email address</label>
                    <v-text-field v-model="form.email" :rules="form.emailRules" required></v-text-field>
                    <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>

                    <label>Password</label>
                    <v-text-field v-model="form.password" :rules="form.passwordRules" type="password" required></v-text-field>
                    
                    <div v-if="errors.password" class="mt-2 error">{{ errors.password }}</div>

                     <a href="/forgot-password" replace>Forgot Password?</a><br/><br/>
                    <v-btn :disabled="form.processing" color="success" class="mr-4"  @click="submit()">Login</v-btn>
                </v-form>
                 <br/>
                 <v-btn href="/register" text >Don't Have an Account? Register Here </v-btn>
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
  data() {
    return {
      form: this.$inertia.form({
        email: null,
        password: null,
          emailRules: [
              v => !!v || 'E-mail is required',
              v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
          ],
          passwordRules : [
              v => !!v || 'Password is required',
           ],
      }),
    }
  },
  methods :{
      submit() {
          this.$inertia.post('/login', this.form );
          this.$refs.form.resetValidation();
        }
    }
}
</script>