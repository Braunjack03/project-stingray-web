<template>
    <v-app app>
        <v-container>
            <v-card class="mx-auto px-8 py-12" max-width="500" elevation="2">

            <h2  >Create an Account (it's free)  </h2>   
            <br/>
                <div v-if="errors.message" class="mt-2 error">{{ errors.message }}</div>
                <v-form ref="form" v-model="valid" lazy-validations >
                    <label>Email address</label>
                    <v-text-field v-model="form.email" :rules="form.emailRules" required></v-text-field>
                    <div v-if="errors.email" class="mt-2 error">{{ errors.email }}</div>
                    <label>Password</label>
                    <v-text-field v-model="form.password" :rules="form.passwordRules" type="password" required></v-text-field>
                    <div v-if="errors.password" class="mt-2 error">{{ errors.password }}</div>
                    <label>Your role:</label>
                    <v-radio-group
                        v-model="form.user_type" :rules="form.userTypeRules"
                        required
                        >
                    <v-radio
                        label="Job Seeker"
                        value="2"
                    ></v-radio>
                    <v-radio
                        label="Employer"
                        value="1"
                    ></v-radio>
                    </v-radio-group>
                    <v-btn :disabled="!valid" color="success" class="mr-4" @click="submit()" >Create Acount</v-btn>
                </v-form>
                <br/>
                 <Link href="/login" text >Already Have Account? Login </Link>
            </v-card> 
       
        </v-container>
    </v-app>
</template>   
<script>
import { Link } from '@inertiajs/inertia-vue'
  export default {
    components: {
      Link,
    },
    props: {
        errors: Object,
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
            password: '',
            passwordRules : [
                v => !!v || 'Password is required',
            ],
            user_type: '',
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
      submit() {
            this.$inertia.post('/register', this.form );
            this.$refs.form.resetValidation();
       },
    },
  }

</script>