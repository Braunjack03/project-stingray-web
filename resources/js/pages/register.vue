<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

            <h2>Create an Account (it's free)</h2>   
            <v-alert v-if="success" type="success">{{success}}</v-alert>
            <v-alert v-if="error" type="error">{{error}}</v-alert>
            <br/>
                <v-form ref="form" v-model="valid" lazy-validations >
                    <label>Email address</label>
                    <v-text-field v-model="fields.email" :rules="fields.emailRules" required></v-text-field>
                    <label>Password</label>
                    <v-text-field v-model="fields.password" :rules="fields.passwordRules" type="password" required></v-text-field>
                    <label>Your role:</label>
                    <v-radio-group
                        v-model="fields.user_type" :rules="fields.userTypeRules"
                        required
                        >
                    <v-radio
                        label="Job Seeker"
                        value="job_seeker"
                    ></v-radio>
                    <v-radio
                        label="Employer"
                        value="employer"
                    ></v-radio>
                    </v-radio-group>
                    <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit()" >Create Acount</v-btn>
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
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        password: '',
        passwordRules : [
            v => !!v || 'Password is required',
        ],
        userTypeRules: '',
        userTypeRules : [
            v => !!v || 'Your role is required',
        ]
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
        axios.post('register', {
            data: this.fields
        }).then((res)=> {
            this.success = res.data.message
            this.error.clear();
            this.$refs.form.reset()
        }).catch((error)=>{
            if (error.response.status == 400){
                this.error = error.response.data.message;
            }
            this.success.clear();
        })
       },
    },
  }
</script>