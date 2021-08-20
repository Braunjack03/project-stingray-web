<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

            <h2>Login</h2>   
            <br/>
                <v-form @submit.prevent="submit" ref="form"  v-model="valid" lazy-validations >
                    <label>Email address</label>
                    <v-text-field label="Email" v-model="fields.email"  :rules="fields.emailRules" required></v-text-field>
                    <label>Password</label>
                    <v-text-field v-model="fields.password" type="password" :rules="fields.passwordRules" required></v-text-field>
                     
                     <a href="/forgot-password" replace>Forgot Password?</a><br/><br/>
                    <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit()" >Login</v-btn>
                </v-form>
            </v-card>           
        </v-container>
    </v-app>
</template>   
<script>
  export default {
    data: () => ({
        success: '',
        error: '',
        message: '',
        valid: true,
        fields: {
        email: '',
        emailRules: [
            v => !!v || 'E-mail is required',
        ],
        password: '',
        passwordRules : [
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
          alert('ok');
        this.validate();
        this.$inertia.post('login', {
            data: this.fields
        })
        
        /*.then((res)=> {
            this.success = res.data.message
            this.error.clear();
            this.$refs.form.reset()
        }).catch((error)=>{
            if (error.response.status == 400){
                this.error = error.response.data.message;
            }
            this.success.clear();
        })*/
       },
    },
  }
</script>