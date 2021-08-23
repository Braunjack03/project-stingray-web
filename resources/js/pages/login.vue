<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

            <h2>Login</h2>   
            <br/>
                <v-form ref="form" >
                    <div v-if="errors.message" class="mt-2">{{ errors.message }}</div>
                    <label>Email address</label>
                    <v-text-field label="Email" v-model="form.email" required></v-text-field>
                    <div v-if="errors.email" class="mt-2">{{ errors.email }}</div>

                    <label>Password</label>
                    <v-text-field v-model="form.password" type="password" required></v-text-field>
                    
                    <div v-if="errors.password" class="mt-2">{{ errors.password }}</div>

                     <a href="/forgot-password" replace>Forgot Password?</a><br/><br/>
                    <v-btn :disabled="form.processing" color="success" class="mr-4"  @click="submit()">Login</v-btn>
                </v-form>
            </v-card>           
        </v-container>
    </v-app>
</template>   
<script>
  export default {
     props: {
        errors: Object,
    },
  data() {
    return {
      form: this.$inertia.form({
        email: null,
        password: null,
      }),
    }
  },
  methods :{
      submit() {
        this.$inertia.post('/login', this.form )
        }
    }
}
</script>